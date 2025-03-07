<?php
session_start();
include("db_connect.php"); // Ensure this file contains the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_otp = trim($_POST["otp"]);
    $email = $_SESSION["email"];

    // Fetch OTP from database
    $stmt = $conn->prepare("SELECT otp, otp_expiry FROM stud_acc WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && $row["otp"] == $user_otp && time() < $row["otp_expiry"]) {
        // OTP is correct and not expired
        $_SESSION["verified"] = true; // Allow password reset
        header("Location: reset.php");
        exit();
    } else {
        // Invalid or expired OTP
        $_SESSION['error'] = "Invalid or expired OTP!";
        header("Location: otp.php");
        exit();
    }
}
?>
