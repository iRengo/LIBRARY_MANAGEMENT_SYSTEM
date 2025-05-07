<?php
session_start();
include '../Homepage/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $borrow_id = $_POST['borrow_id'];

    if ($action === 'accept') {
        $update_sql = "UPDATE borrowed_books SET status = 'Approved' WHERE borrow_id = '$borrow_id'";
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

        // Get librarian number from session
        $updated_by = $_SESSION['librarian_no'];

        // 1. Insert into rejected_requests
        $insert_sql = "INSERT INTO rejected_requests 
            (borrow_id, updated_by, student_no, email, book_title, contact, preferred_date, status, reason)
            VALUES 
            ('$borrow_id', '$updated_by', '$student_no', '$email', '$title', '$contact', '$preferred_date', '$status', '$reason')";
        $insert_result = mysqli_query($conn, $insert_sql);

        // 2. If insert was successful, delete from borrowed_books
        if ($insert_result) {
            $delete_sql = "DELETE FROM borrowed_books WHERE borrow_id = '$borrow_id'";
            mysqli_query($conn, $delete_sql);
            echo "Rejected and deleted from borrowed_books";
        } else {
            echo "Failed to log rejection";
        }
    }
}
?>
