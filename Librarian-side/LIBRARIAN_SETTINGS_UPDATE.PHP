<?php
session_start();
include '../homepage/db_connect.php';

$librarian_no = $_SESSION['librarian_no'] ?? null;

if (!$librarian_no) {
    header("Location: ../homepage/signin.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_profile'])) {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Get current password hash
    $stmt = $conn->prepare("SELECT password FROM librarian_acc WHERE librarian_no = ?");
    $stmt->bind_param("i", $librarian_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $current_password_hash = $row['password'] ?? '';

    if (!password_verify($current_password, $current_password_hash)) {
        header("Location: librarian_settings.php?status=incorrect_password");
        exit;
    }

    if (!empty($new_password)) {
        if ($new_password !== $confirm_password) {
            header("Location: librarian_settings.php?status=password_mismatch");
            exit;
        }

        if (!preg_match('/^(?=.*[0-9])(?=.*[\W_]).{8,}$/', $new_password)) {
            header("Location: librarian_settings.php?status=weak_password");
            exit;
        }

        $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query = "UPDATE librarian_acc SET first_name = ?, last_name = ?, email = ?, password = ? WHERE librarian_no = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssssi", $first_name, $last_name, $email, $new_hashed, $librarian_no);
    } else {
        $update_query = "UPDATE librarian_acc SET first_name = ?, last_name = ?, email = ? WHERE librarian_no = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssi", $first_name, $last_name, $email, $librarian_no);
    }

    if ($stmt->execute()) {
        header("Location: librarian_settings.php?status=success");
    } else {
        header("Location: librarian_settings.php?status=failed");
    }
    exit;
}
?>
