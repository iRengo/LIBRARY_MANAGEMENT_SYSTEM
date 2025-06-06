<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/vendor/autoload.php'; 

include '../Homepage/db_connect.php';
date_default_timezone_set('Asia/Manila');

$current_time = date("Y-m-d H:i:s");

$sql = "SELECT borrow_id, student_no, book_id, book_title, first_name, email 
        FROM borrowed_books 
        WHERE status = 'Approved' 
        AND TIMESTAMPDIFF(HOUR, update_datetime, ?) >= 24";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $current_time);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $borrow_id = $row['borrow_id'];
    $student_no = $row['student_no'];
    $book_id = $row['book_id'];
    $title = $row['book_title'];
    $first_name = $row['first_name'];
    $email = $row['email'];
    $status = 'Unclaimed';
    $reason = 'Not picked up within 24 hours';
    $type = "auto-cancelled";
    $handled_by = 'System';

    // Insert into rejected_requests
    $insert_sql = "INSERT INTO rejected_requests 
        (borrow_id, book_id, updated_by, student_no, book_title, status, reason, update_datetime) 
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("iisssss", $borrow_id, $book_id, $handled_by, $student_no, $title, $status, $reason);
    $insert_stmt->execute();


    $notif_msg = "Your borrow request for '{$title}' was auto-cancelled because it was not picked up within 24 hours.";
    $notif_sql = "INSERT INTO tbl_user_notifications (student_no, book_id, message, type, created_at, is_read) 
                  VALUES (?, ?, ?, ?, NOW(), 0)";
    $notif_stmt = $conn->prepare($notif_sql);
    $notif_stmt->bind_param("siss", $student_no, $book_id, $notif_msg, $type);
    $notif_stmt->execute();


    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'systemlibrarymanagement8@gmail.com';
        $mail->Password = 'ndur otbh aalt vicl'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('no-reply@librasphere.com', 'LibraSphere Support');
        $mail->addAddress($email, $first_name);

        $mail->isHTML(true);
        $mail->Subject = "Auto-Cancellation: Book Not Picked Up";
        $mail->Body = "
            <p>Dear $first_name,</p>
            <p>This is to inform you that your borrow request for <strong>$title</strong> has been <span style='color:red;'><strong>automatically cancelled</strong></span>.</p>
            <p>Reason: You did not pick up the book within the allowed 24-hour window.</p>
            <p>If you still wish to borrow this book, please submit a new request.</p>
            <p>– Librasphere Team</p>
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("Auto-cancel email to $email failed. Error: {$mail->ErrorInfo}");
    }

    $delete_sql = "DELETE FROM borrowed_books WHERE borrow_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $borrow_id);
    $delete_stmt->execute();
}

$stmt->close();
