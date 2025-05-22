<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/vendor/autoload.php';
include 'db_connect.php';

$current_date = date('Y-m-d');

$sql = "SELECT * FROM tbl_books WHERE status = 'Upcoming' AND publication_date <= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $current_date);
$stmt->execute();
$result = $stmt->get_result();

while ($book = $result->fetch_assoc()) {
    $book_id = $book['book_id'];
    $book_title = $book['book_title'];

    // Update book status to 'Available'
    $update_sql = "UPDATE tbl_books SET status = 'Available' WHERE book_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $book_id);

    if ($update_stmt->execute()) {
        // Check for reservations
        $res_sql = "SELECT student_no, first_name, email FROM reserved_books WHERE book_id = ?";
        $res_stmt = $conn->prepare($res_sql);
        $res_stmt->bind_param("i", $book_id);
        $res_stmt->execute();
        $res_result = $res_stmt->get_result();

        while ($reservation = $res_result->fetch_assoc()) {
            $student_no = $reservation['student_no'];
            $first_name = $reservation['first_name'];
            $email = $reservation['email'];

            // Insert notification record
            $notif_message = "The book '{$book_title}' you reserved is now available.";
            $notif_type = 'reserved-available';

            $insert_sql = "INSERT INTO tbl_user_notifications (student_no, book_id, message, type, is_read, created_at) VALUES (?, ?, ?, ?, 0, NOW())";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("iiss", $student_no, $book_id, $notif_message, $notif_type);
            $insert_stmt->execute();
            $insert_stmt->close();

            // Send email with PHPMailer
            $mail = new PHPMailer(true);
            try {
                // SMTP server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username = 'systemlibrarymanagement8@gmail.com';
                $mail->Password = 'ndur otbh aalt vicl';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('systemlibrarymanagement8@gmail.com', 'Released Notifications');
                $mail->addAddress($email, $first_name);

                // Email content
                $mail->isHTML(true);
                $mail->Subject = "Book Available Notification";
                $mail->Body    = "
                    <p>Hi {$first_name},</p>
                    <p>The book <strong>{$book_title}</strong> you reserved is now available for borrowing.</p>
                    <p>Please check the library catalog to borrow the book.</p>
                    <p>Thank you!</p>
                ";

                $mail->send();
            } catch (Exception $e) {
                error_log("Email to {$email} failed: {$mail->ErrorInfo}");
            }
        }

        $res_stmt->close();
    }

    $update_stmt->close();
}

$stmt->close();
$conn->close();
