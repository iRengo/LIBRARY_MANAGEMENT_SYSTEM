<?php
session_start();
include 'db_connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_no = trim($_POST["student_no"]);
    $password = trim($_POST["password"]);
    $recaptcha_response = $_POST["g-recaptcha-response"];

    // Google reCAPTCHA secret key
    $secret_key = "6LcbyK0qAAAAAPDOL2x3oYM8ZTRrgnKvRZR3QLWQ";

    // Verify reCAPTCHA
    $verify_url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret_key . "&response=" . $recaptcha_response;
    $response = file_get_contents($verify_url);
    $response_keys = json_decode($response, true);

    if (!$response_keys["success"]) {
        $_SESSION['error_message'] = "Please verify that you are not a robot!";
        header("Location: signin.php");
        exit();
    }

    // Check if student_no and password fields are filled
    if (empty($student_no) || empty($password)) {
        $_SESSION['error_message'] = "Student Number and Password are required!";
        header("Location: signin.php");
        exit();
    }

    // Securely fetch user data
    $stmt = $conn->prepare("SELECT acc_no, student_no, password FROM stud_acc WHERE student_no = ?");
    $stmt->bind_param("s", $student_no);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Use password_verify for hashed passwords
        if (password_verify($password, $user['password'])) {
            $_SESSION['acc_no'] = $user['acc_no'];
            $_SESSION['student_no'] = $user['student_no'];
            header("Location: ../user-side/user_dashboard.php"); // Redirect to the dashboard
            exit();
        } else {
            $_SESSION['error_message'] = "Invalid password!";
            header("Location: signin.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Student unregistered or wrong password";
        header("Location: signin.php");
        exit();
    }

    $stmt->close();
}
?>
