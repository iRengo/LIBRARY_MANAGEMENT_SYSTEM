<?php
session_start();
include 'db_connect.php';
require '../phpmailer/vendor/autoload.php'; // Update path if needed

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT * FROM stud_acc WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $_SESSION['error'] = "Email not found!";
        header("Location: forgot.php");
        exit();
    }

    // Generate OTP and expiration time
    $otp = rand(100000, 999999); // 6-digit OTP
    $otp_expiry = date("Y-m-d H:i:s", time() + (5 * 60)); // Set expiry 5 minutes from now

    // Store OTP in the database
    $update_stmt = $conn->prepare("UPDATE stud_acc SET otp = ?, otp_expiry = ? WHERE email = ?");
    $update_stmt->bind_param("sss", $otp, $otp_expiry, $email);
    $update_stmt->execute();

    if ($update_stmt->affected_rows > 0) {
        // Send OTP email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'systemlibrarymanagement8@gmail.com';
            $mail->Password = 'ndur otbh aalt vicl'; // Use an App Password if using Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('systemlibrarymanagement8@gmail.com', 'LibraSphere Support');
            $mail->addAddress($email);
            $mail->Subject = 'Your OTP for Password Reset';
            $mail->Body = "Your OTP code is: $otp. This code is valid for 5 minutes.";

            $mail->send();

            $_SESSION["email"] = $email; // Store email for verification
            header("Location: otp.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed to send OTP. Error: {$mail->ErrorInfo}";
            header("Location: forgot.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Failed to generate OTP!";
        header("Location: forgot.php");
        exit();
    }
}
