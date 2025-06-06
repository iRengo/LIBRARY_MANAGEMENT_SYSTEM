<?php
session_start();
include '../Homepage/db_connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/vendor/autoload.php';

date_default_timezone_set('Asia/Manila');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $borrow_id = $_POST['borrow_id'];
    $approved_by = $_SESSION['librarian_no'];

    $borrow_sql = "SELECT book_id, student_no, book_title FROM borrowed_books WHERE borrow_id = ?";
    $borrow_stmt = $conn->prepare($borrow_sql);
    $borrow_stmt->bind_param("i", $borrow_id);
    $borrow_stmt->execute();
    $borrow_res = $borrow_stmt->get_result();
    $borrow_row = $borrow_res->fetch_assoc();

    if (!$borrow_row) {
        echo "Borrow record not found";
        exit;
    }

    $book_id = $borrow_row['book_id'];
    $student_no = $borrow_row['student_no'];
    $title = $borrow_row['book_title'];

    if ($action === 'accept') {
        $update_sql = "UPDATE borrowed_books 
                       SET status = 'Approved', 
                           update_datetime = NOW(), 
                           updated_by = ? 
                       WHERE borrow_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $approved_by, $borrow_id);
        $update_stmt->execute();

        // Insert notification with book_id
        $message = "Your borrow request for '{$title}' has been approved. Please pick it up. You only have 24hrs, after that your request will be automatically cancelled";
        $type = "approved";

        $notif_sql = "INSERT INTO tbl_user_notifications (student_no, book_id, message, type, created_at, is_read) 
                      VALUES (?, ?, ?, ?, NOW(), 0)";
        $notif_stmt = $conn->prepare($notif_sql);
        $notif_stmt->bind_param("siss", $student_no, $book_id, $message, $type);
        $notif_stmt->execute();

        echo "Success";
    } elseif ($action === 'decline') {
        // Use posted values or fallback to borrow_row data
        $student_no = $_POST['student_no'] ?? $borrow_row['student_no'];
        $email = $_POST['email'];
        $title = $_POST['title'] ?? $borrow_row['book_title'];
        $contact = $_POST['contact'];
        $preferred_date = $_POST['preferred_date'];
        $status = $_POST['status'];
        $reason = $_POST['reason'];
        $type = "rejected";

        $updated_by = $_SESSION['librarian_no'];

        $insert_sql = "INSERT INTO rejected_requests 
            (borrow_id, book_id, updated_by, student_no, email, book_title, contact, preferred_date, status, reason, update_datetime)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iissssssss", $borrow_id, $book_id, $updated_by, $student_no, $email, $title, $contact, $preferred_date, $status, $reason);
        $insert_stmt->execute();

        if ($insert_stmt->affected_rows > 0) {
            // Insert notification with book_id
            $message = "Your borrow request for '{$title}' was rejected. Reason: {$reason}";
            $type = "rejected";

            $notif_sql = "INSERT INTO tbl_user_notifications (student_no, book_id, message, type, created_at, is_read) 
                          VALUES (?, ?, ?, ?, NOW(), 0)";
            $notif_stmt = $conn->prepare($notif_sql);
            $notif_stmt->bind_param("siss", $student_no, $book_id, $message, $type);
            $notif_stmt->execute();

            // Delete from borrowed_books
            $delete_sql = "DELETE FROM borrowed_books WHERE borrow_id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $borrow_id);
            $delete_stmt->execute();

            echo "Rejected and deleted from borrowed_books";
        } else {
            echo "Failed to log rejection";
        }
    } elseif ($action === 'mark_borrowed') {
        $update_sql = "UPDATE borrowed_books 
                   SET status = 'Borrowed', 
                       update_datetime = NOW(), 
                       updated_by = ? 
                   WHERE borrow_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $approved_by, $borrow_id);
        $update_stmt->execute();

        if ($update_stmt->affected_rows > 0) {
            // Send notification
            $message = "You have successfully borrowed '{$title}'. Due date: Check your account.";
            $type = "borrowed";

            $notif_sql = "INSERT INTO tbl_user_notifications (student_no, book_id, message, type, created_at, is_read) 
                      VALUES (?, ?, ?, ?, NOW(), 0)";
            $notif_stmt = $conn->prepare($notif_sql);
            $notif_stmt->bind_param("siss", $student_no, $book_id, $message, $type);
            $notif_stmt->execute();

            echo "Success";
        } else {
            echo "Failed to update status";
        }
        exit;
    } elseif ($action === 'return_book') {
        $borrow_id = $_POST['borrow_id'];
        $student_no = $_POST['student_no'];
        $book_id = $_POST['book_id'];
        $handled_by = $_SESSION['librarian_no'];
        $book_condition = 'Good';

        // Fetch book title from borrowed_books
        $fetch_sql = "SELECT book_title FROM borrowed_books WHERE borrow_id = ?";
        $fetch_stmt = $conn->prepare($fetch_sql);
        $fetch_stmt->bind_param("i", $borrow_id);
        $fetch_stmt->execute();
        $result = $fetch_stmt->get_result();

        if ($result->num_rows === 0) {
            echo "Book record not found.";
            exit;
        }

        $row = $result->fetch_assoc();
        $book_title = $row['book_title'];
        $return_date = date("Y-m-d H:i:s");

        // 1. Update borrowed_books status
        $update_sql = "UPDATE borrowed_books 
                   SET status = 'Returned', 
                       update_datetime = NOW(), 
                       updated_by = ? 
                   WHERE borrow_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $handled_by, $borrow_id);
        $update_stmt->execute();

        if ($update_stmt->affected_rows > 0) {
            $insert_sql = "INSERT INTO returned_books 
                       (borrow_id, book_id, book_title, student_no, return_date, book_condition, handled_by)
                       VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("iisssss", $borrow_id, $book_id, $book_title, $student_no, $return_date, $book_condition, $handled_by);
            $insert_stmt->execute();

            // 3. Send notification
            $message = "Thank you for returning '{$book_title}'. It has been marked as returned.";
            $type = "returned";

            $notif_sql = "INSERT INTO tbl_user_notifications 
                      (student_no, book_id, message, type, created_at, is_read) 
                      VALUES (?, ?, ?, ?, NOW(), 0)";
            $notif_stmt = $conn->prepare($notif_sql);
            $notif_stmt->bind_param("siss", $student_no, $book_id, $message, $type);
            $notif_stmt->execute();

            echo "Book marked as returned and logged in returned_books.";
        } else {
            echo "Failed to update return status.";
        }

        $update_stock = $conn->prepare("UPDATE tbl_books SET book_stocks = book_stocks + 1 WHERE book_id = ?");
        $update_stock->bind_param("i", $book_id);
        $update_stock->execute();

        // 5. Check if there are reservations for this book
        $res_query = $conn->prepare("SELECT * FROM reserved_books WHERE book_id = ? ORDER BY reserve_id ASC LIMIT 1");
        $res_query->bind_param("i", $book_id);
        $res_query->execute();
        $res_result = $res_query->get_result();

        if ($res_result->num_rows > 0) {
            $reservation = $res_result->fetch_assoc();

            $new_borrow_id = uniqid('BRW-');
            $preferred_date = $reservation['preferred_date'];
            $due_date = date('Y-m-d', strtotime($preferred_date . ' +7 days'));
            $now = date('Y-m-d H:i:s');

            // Get ISBN
            $isbn_query = $conn->prepare("SELECT ISBN FROM tbl_books WHERE book_id = ?");
            $isbn_query->bind_param("i", $book_id);
            $isbn_query->execute();
            $isbn_result = $isbn_query->get_result();
            $isbn = $isbn_result->fetch_assoc()['ISBN'];

            // Insert into borrowed_books
            $insert_borrow = $conn->prepare("INSERT INTO borrowed_books 
        (borrow_id, student_no, first_name, last_name, email, contact, book_id, ISBN, book_title, preferred_date, due_date, status, update_datetime, updated_by)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Approved', ?, ?)");
            $insert_borrow->bind_param(
                "ssssssissssss",
                $new_borrow_id,
                $reservation['student_no'],
                $reservation['first_name'],
                $reservation['last_name'],
                $reservation['email'],
                $reservation['contact'],
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

            // Decrement stock (auto-consumed by approved reservation)
            $dec_stock = $conn->prepare("UPDATE tbl_books SET book_stocks = book_stocks - 1 WHERE book_id = ?");
            $dec_stock->bind_param("i", $book_id);
            $dec_stock->execute();

            // Send notification
            $message = "Your reserved book '{$book_title}' is now available and automatically borrowed for you. Please Pickup on {$preferred_date}. you only have 24hours or your Request will automatically cancelled";
            $type = "borrowed";

            // Send email notification to the student
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
                $mail->addAddress($reservation['email'], $reservation['first_name'] . ' ' . $reservation['last_name']);

                $mail->isHTML(true);
                $mail->Subject = 'Reserved Book Now Available';
                $mail->Body    = "Hello {$reservation['first_name']},<br><br>"
                    . "Your reserved book <strong>{$book_title}</strong> is now available and has been automatically borrowed for you.<br>"
                    . "Please pick it up by <strong>{$preferred_date} you only have 24 HOURS or it will be automatically cancelled</strong>.<br><br>"
                    . "Thank you,<br>Library Team";

                $mail->send();
            } catch (Exception $e) {

                error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }


            $notif_stmt = $conn->prepare("INSERT INTO tbl_user_notifications (student_no, book_id, message, type, created_at, is_read) VALUES (?, ?, ?, ?, NOW(), 0)");
            $notif_stmt->bind_param("siss", $reservation['student_no'], $book_id, $message, $type);
            $notif_stmt->execute();
        }


        exit;
    }
}
