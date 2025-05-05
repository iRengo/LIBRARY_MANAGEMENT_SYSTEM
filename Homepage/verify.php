<?php
session_start();
include 'db_connect.php'; // Database connection

$email = $_GET['email'] ?? '';

// Validate the email
if (empty($email)) {
    header("Location: signin.php?message=invalid");
    exit();
}

// Check if the user is unverified
$stmt = $conn->prepare("SELECT student_no FROM stud_acc WHERE email = ? AND verified = 0");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Update verified status
    $update = $conn->prepare("UPDATE stud_acc SET verified = 1 WHERE email = ?");
    $update->bind_param("s", $email);
    $update->execute();

    // Redirect to signin page with success message
    header("Location: signin.php?message=verified");
    exit();
} else {
    // Already verified or invalid
    header("Location: signin.php?message=already_verified");
    exit();
}
?>
