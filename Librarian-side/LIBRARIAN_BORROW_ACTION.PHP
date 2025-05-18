<?php
session_start();
include '../Homepage/db_connect.php';

date_default_timezone_set('Asia/Manila'); // Make sure the timezone is consistent

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $borrow_id = $_POST['borrow_id'];
    $approved_by = $_SESSION['librarian_no'];

    if ($action === 'accept') {
        $update_sql = "UPDATE borrowed_books 
                   SET status = 'Approved', 
                       update_datetime = NOW(), 
                       updated_by = '$approved_by' 
                   WHERE borrow_id = '$borrow_id'";
        mysqli_query($conn, $update_sql);
        echo "Success";
    } elseif ($action === 'decline') {
        $student_no = $_POST['student_no'];
        $email = $_POST['email'];
        $title = $_POST['title'];
        $contact = $_POST['contact'];
        $preferred_date = $_POST['preferred_date'];
        $status = $_POST['status'];
        $reason = $_POST['reason'];

        $updated_by = $_SESSION['librarian_no'];

        $book_id_result = mysqli_query($conn, "SELECT book_id FROM borrowed_books WHERE borrow_id = '$borrow_id'");
        $book_id_row = mysqli_fetch_assoc($book_id_result);
        $book_id = $book_id_row['book_id'];

        $insert_sql = "INSERT INTO rejected_requests 
            (borrow_id, book_id, updated_by, student_no, email, book_title, contact, preferred_date, status, reason, update_datetime)
            VALUES 
            ('$borrow_id', '$book_id', '$updated_by', '$student_no', '$email', '$title', '$contact', '$preferred_date', '$status', '$reason', NOW())";

        $insert_result = mysqli_query($conn, $insert_sql);

        if ($insert_result) {
            $delete_sql = "DELETE FROM borrowed_books WHERE borrow_id = '$borrow_id'";
            mysqli_query($conn, $delete_sql);
            echo "Rejected and deleted from borrowed_books";
        } else {
            echo "Failed to log rejection";
        }
    } elseif ($action === 'mark_borrowed') {
        $update_sql = "UPDATE borrowed_books SET status = 'Borrowed', update_datetime = NOW() WHERE borrow_id = '$borrow_id'";
        $result = mysqli_query($conn, $update_sql);

        if ($result) {
            echo "Borrowed status updated";
        } else {
            echo "Error updating status";
        }
    }
}

// ⚠️ Auto-reject AFTER POST handling
$updated_by = isset($_SESSION['librarian_no']) ? $_SESSION['librarian_no'] : 'system';

$auto_reject_sql = "SELECT * FROM borrowed_books 
                    WHERE status = 'Approved' 
                    AND TIMESTAMPDIFF(MINUTE, update_datetime, NOW()) >= 1";

$auto_reject_result = mysqli_query($conn, $auto_reject_sql);

if ($auto_reject_result && mysqli_num_rows($auto_reject_result) > 0) {
    while ($row = mysqli_fetch_assoc($auto_reject_result)) {
        $borrow_id = $row['borrow_id'];
        $book_id = $row['book_id'];
        $student_no = $row['student_no'];
        $email = $row['email'];
        $title = $row['book_title'];
        $contact = $row['contact'];
        $preferred_date = $row['preferred_date'];
        $reason = "Automatically rejected due to pickup time limit";
        $status = "Declined";

        $insert_sql = "INSERT INTO rejected_requests 
            (borrow_id, book_id, updated_by, student_no, email, book_title, contact, preferred_date, status, reason, update_datetime)
            VALUES 
            ('$borrow_id', '$book_id', '$updated_by', '$student_no', '$email', '$title', '$contact', '$preferred_date', '$status', '$reason', NOW())";

        if (mysqli_query($conn, $insert_sql)) {
            mysqli_query($conn, "DELETE FROM borrowed_books WHERE borrow_id = '$borrow_id'");
        } else {
            error_log("Insert failed for auto-reject on borrow_id=$borrow_id: " . mysqli_error($conn));
        }
    }
}
