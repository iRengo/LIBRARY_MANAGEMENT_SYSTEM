<?php
session_start();
include("db_connection.php"); // Ensure you have a file for DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM stud_acc WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email exists, generate OTP
        $otp = rand(100000, 999999); // 6-digit OTP
        $expiry = date("Y-m-d H:i:s", time() + (5 * 60));

        // Store OTP in session and database
        $_SESSION["otp"] = $otp;
        $_SESSION["email"] = $email;

        $stmt = $conn->prepare("UPDATE stud_acc SET otp = ?, otp_expiry = ? WHERE email = ?");
        $stmt->bind_param("sss", $otp, $expiry, $email);
        $stmt->execute();

        // Send OTP via email
        $subject = "Your OTP for Password Reset";
        $message = "Your OTP code is: $otp. It is valid for 5 minutes.";
        $headers = "From: no-reply@yourwebsite.com\r\n";
        mail($email, $subject, $message, $headers);

        // Redirect to OTP page
        header("Location: otp.php");
        exit();
    } else {
        // Email not found
        echo "<script>alert('Email does not exist!'); window.location.href='forgot.php';</script>";
    }
}
