<?php
session_start();
include 'db_connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_no = trim($_POST["user_no"]);
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

    // Check if fields are filled
    if (empty($user_no) || empty($password)) {
        $_SESSION['error_message'] = "User Number and Password are required!";
        header("Location: signin.php");
        exit();
    }

    // 1️⃣ **Check if the user is an admin**
    $stmt = $conn->prepare("SELECT admin_no, password FROM admin_acc WHERE admin_no = ?");
    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }
    $stmt->bind_param("s", $user_no);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($admin_no, $hashed_password);
        $stmt->fetch();
        $stmt->close();

        // Use password_verify for hashed admin passwords
        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_no'] = $admin_no;
            header("Location: ../admin-side/admin_dashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Invalid password!";
            header("Location: signin.php");
            exit();
        }
    }
    $stmt->close();

    // 2️⃣ **Check if the user is a librarian**
    $stmt = $conn->prepare("SELECT librarian_no, password FROM librarian_acc WHERE librarian_no = ?");
    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }
    $stmt->bind_param("s", $user_no);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($librarian_no, $hashed_password);
        $stmt->fetch();
        $stmt->close();

        // Use password_verify for hashed librarian passwords
        if (password_verify($password, $hashed_password)) {
            $_SESSION['librarian_no'] = $librarian_no;
            header("Location: ../librarian-side/librarian_dashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Invalid password!";
            header("Location: signin.php");
            exit();
        }
    }
    $stmt->close();

    // 3️⃣ **Check if the user is a student**
    $stmt = $conn->prepare("SELECT acc_no, student_no, password FROM stud_acc WHERE student_no = ?");
    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }
    $stmt->bind_param("s", $user_no);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($acc_no, $student_no, $hashed_password);
        $stmt->fetch();
        $stmt->close();

        // Use password_verify for hashed student passwords
        if (password_verify($password, $hashed_password)) {
            $_SESSION['acc_no'] = $acc_no;
            $_SESSION['student_no'] = $student_no;
            header("Location: ../user-side/user_dashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Invalid password!";
            header("Location: signin.php");
            exit();
        }
    }
    $stmt->close();

    // ❌ **If none of the checks succeed**
    $_SESSION['error_message'] = "Invalid user number or password.";
    $conn->close();
    header("Location: signin.php");
    exit();
}
?>
