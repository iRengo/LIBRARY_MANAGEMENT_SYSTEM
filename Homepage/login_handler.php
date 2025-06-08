
<?php 
session_start();
include 'db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_no = trim($_POST["user_no"]);
    $password = trim($_POST["password"]);
    $recaptcha_response = $_POST["g-recaptcha-response"];

    $secret_key = "6LcbyK0qAAAAAPDOL2x3oYM8ZTRrgnKvRZR3QLWQ";
    $verify_url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret_key . "&response=" . $recaptcha_response;
    $response = file_get_contents($verify_url);
    $response_keys = json_decode($response, true);

    if (!$response_keys["success"]) {
        $_SESSION['error_message'] = "Please verify that you are not a robot!";
        header("Location: signin.php");
        exit();
    }

    if (empty($user_no) || empty($password)) {
        $_SESSION['error_message'] = "User Number and Password are required!";
        header("Location: signin.php");
        exit();
    }

    // Admin Login
    $stmt = $conn->prepare("SELECT admin_no, password, first_name FROM admin_acc WHERE admin_no = ?");
    if ($stmt) {
        $stmt->bind_param("s", $user_no);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($admin_no, $hashed_password, $first_name);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['admin_no'] = $admin_no;
                $_SESSION['first_name'] = $first_name;

                $update = $conn->prepare("UPDATE admin_acc SET last_logged_in = NOW() WHERE admin_no = ?");
                $update->bind_param("s", $admin_no);
                $update->execute();
                $update->close();

                $stmt->close();
                header("Location: ../admin-side/admin_dashboard.php");
                exit();
            }
        }
        $stmt->close();
    }

    // Librarian Login
    $stmt = $conn->prepare("SELECT librarian_no, password, first_name FROM librarian_acc WHERE librarian_no = ?");
    if ($stmt) {
        $stmt->bind_param("s", $user_no);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($librarian_no, $hashed_password, $first_name);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['librarian_no'] = $librarian_no;
                $_SESSION['first_name'] = $first_name;

                $update = $conn->prepare("UPDATE librarian_acc SET last_logged_in = NOW() WHERE librarian_no = ?");
                $update->bind_param("s", $librarian_no);
                $update->execute();
                $update->close();

                $stmt->close();
                header("Location: ../librarian-side/librarian_dashboard.php");
                exit();
            }
        }
        $stmt->close();
    }

    // Student Login
    $stmt = $conn->prepare("SELECT acc_no, student_no, password, first_name, verified FROM stud_acc WHERE student_no = ?");
    if ($stmt) {
        $stmt->bind_param("s", $user_no);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($acc_no, $student_no, $hashed_password, $first_name, $verified);
            $stmt->fetch();

            if (!$verified) {
                $_SESSION['error_message'] = "Please verify your email before logging in. <br> (Check your Email) <br><br>";
                $stmt->close();
                header("Location: signin.php");
                exit();
            }

            if (password_verify($password, $hashed_password)) {
                $_SESSION['acc_no'] = $acc_no;
                $_SESSION['student_no'] = $student_no;
                $_SESSION['first_name'] = $first_name;

                $update = $conn->prepare("UPDATE stud_acc SET last_logged_in = NOW() WHERE student_no = ?");
                $update->bind_param("s", $student_no);
                $update->execute();
                $update->close();

                $stmt->close();
                header("Location: ../user-side/user_dashboard.php");
                exit();
            }
        }
        $stmt->close();
    }

    // If no match
    $_SESSION['error_message'] = "Invalid user number or password.";
    $conn->close();
    header("Location: signin.php");
    exit();
}
?>
