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
        // Check for the first reservation
        $res_sql = "SELECT * FROM reserved_books WHERE book_id = ? ORDER BY reserve_id ASC LIMIT 1";
        $res_stmt = $conn->prepare($res_sql);
        $res_stmt->bind_param("i", $book_id);
        $res_stmt->execute();
        $res_result = $res_stmt->get_result();

        if ($res_result->num_rows > 0) {
            $reservation = $res_result->fetch_assoc();

            $student_no = $reservation['student_no'];
            $first_name = $reservation['first_name'];
            $last_name = $reservation['last_name'];
            $email = $reservation['email'];
            $contact = $reservation['contact'];
            $preferred_date = $reservation['preferred_date'];

            $new_borrow_id = uniqid('BRW-');
            $due_date = date('Y-m-d', strtotime($preferred_date . ' +7 days'));
            $now = date('Y-m-d H:i:s');
            $handled_by = 'SystemAutoRelease';

            // Get ISBN
            $isbn_stmt = $conn->prepare("SELECT ISBN FROM tbl_books WHERE book_id = ?");
            $isbn_stmt->bind_param("i", $book_id);
            $isbn_stmt->execute();
            $isbn_result = $isbn_stmt->get_result();
            $isbn = $isbn_result->fetch_assoc()['ISBN'] ?? '';

            // Insert into borrowed_books
            $insert_borrow = $conn->prepare("INSERT INTO borrowed_books 
                (borrow_id, student_no, first_name, last_name, email, contact, book_id, ISBN, book_title, preferred_date, due_date, status, update_datetime, updated_by)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Approved', ?, ?)");
            $insert_borrow->bind_param(
                "ssssssissssss",
                $new_borrow_id,
                $student_no,
                $first_name,
                $last_name,
                $email,
                $contact,
                $book_id,
                $isbn,
                $book_title,
                $preferred_date,
                $due_date,
                $now,
                $handled_by
            );
            $insert_borrow->execute();

            // Delete reservation
            $delete_res = $conn->prepare("DELETE FROM reserved_books WHERE reserve_id = ?");
            $delete_res->bind_param("i", $reservation['reserve_id']);
            $delete_res->execute();

            // Decrement stock
            $dec_stock = $conn->prepare("UPDATE tbl_books SET book_stocks = book_stocks - 1 WHERE book_id = ?");
            $dec_stock->bind_param("i", $book_id);
            $dec_stock->execute();

            // Send notification
            $message = "Your reserved book '{$book_title}' is now available and automatically borrowed for you. Please pick it up on {$preferred_date}. You have 24 hours before it is canceled.";
            $type = "borrowed";

            $notif_stmt = $conn->prepare("INSERT INTO tbl_user_notifications (student_no, book_id, message, type, created_at, is_read) VALUES (?, ?, ?, ?, NOW(), 0)");
            $notif_stmt->bind_param("siss", $student_no, $book_id, $message, $type);
            $notif_stmt->execute();

            // Send email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'systemlibrarymanagement8@gmail.com';
                $mail->Password = 'ndur otbh aalt vicl';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('systemlibrarymanagement8@gmail.com', 'Libraspehere Support');
                $mail->addAddress($email, $first_name . ' ' . $last_name);

                $mail->isHTML(true);
                $mail->Subject = 'Reserved Book Now Available';
                $mail->Body    = "
                    <p>Hello {$first_name},</p>
                    <p>Your reserved book <strong>{$book_title}</strong> is now available and has been <strong>automatically borrowed</strong> for you.</p>
                    <p>Please pick it up by <strong>{$preferred_date}</strong>. You only have <strong>24 hours</strong> before the request is automatically canceled.</p>
                    <p>Thank you,<br>Library Team</p>";

                $mail->send();
            } catch (Exception $e) {
                error_log("Email to {$email} failed: {$mail->ErrorInfo}");
            }

        }

        $res_stmt->close();
    }

    $update_stmt->close();
}
