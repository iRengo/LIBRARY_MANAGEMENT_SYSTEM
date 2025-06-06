<?php
include '../Homepage/db_connect.php';
date_default_timezone_set('Asia/Manila');
require '../phpmailer/vendor/autoload.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



$today = date('Y-m-d');

$query = "SELECT * FROM borrowed_books WHERE status = 'Pending' AND preferred_date = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $borrowId = $row['borrow_id'];
        $bookId = $row['book_id'];
        $studentNo = $row['student_no'];
        $bookTitle = $row['book_title'];
        $email = $row['email']; 
        $firstName = $row['first_name'];
        $updatedBy = "Auto Approval";

        // Update book request
        $updateQuery = "UPDATE borrowed_books 
                        SET status = 'Approved', update_datetime = NOW(), updated_by = ? 
                        WHERE borrow_id = ? AND status = 'Pending' AND preferred_date = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("sis", $updatedBy, $borrowId, $today);
        $updateStmt->execute();

        // Insert in-app notification
        $notifMsg = "Your borrow request for '<strong>$bookTitle</strong>' has been approved. Please pick it up today.";
        $notifType = "Approved";
        $isRead = 0;

        $insertNotif = "INSERT INTO tbl_user_notifications (book_id, student_no, message, type, created_at, is_read)
                        VALUES (?, ?, ?, ?, NOW(), ?)";
        $notifStmt = $conn->prepare($insertNotif);
        $notifStmt->bind_param("isssi", $bookId, $studentNo, $notifMsg, $notifType, $isRead);
        $notifStmt->execute();

        // Send email via PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
           $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'systemlibrarymanagement8@gmail.com';
            $mail->Password = 'ndur otbh aalt vicl'; // Use an App Password if using Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('no-reply@librasphere.com', 'LibraSphere Support');
            $mail->addAddress($email, $firstName);

            $mail->isHTML(true);
            $mail->Subject = "Book Pickup Reminder $bookTitle";
            $mail->Body = "
                <p>Dear $firstName,</p>
                <p>Your borrow request for <strong>$bookTitle</strong> has been approved.</p>
                <p>Please pick up the book <strong>within 24 hours</strong> (today).</p>
                <p>Failure to pick it up today will result in automatic cancellation.</p>
                <p>– Librasphere Team</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Email could not be sent to $email. Mailer Error: {$mail->ErrorInfo}");
        }
    }
}

$conn->close();

?>