<?php
session_start();
include '../homepage/db_connect.php';

$loggedInUser = $_SESSION['librarian_no'];

if (isset($_POST['fine_id'])) {
    $fine_id = $_POST['fine_id'];

    // Fetch violation_id and student_no (and optionally book_id if needed)
    $fetch_sql = "SELECT violation_id, student_no, book_id FROM student_fines WHERE fine_id = ? AND status = 'unpaid' LIMIT 1";
    $stmt = mysqli_prepare($conn, $fetch_sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $fine_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $violation_id, $student_no, $book_id);

        if (mysqli_stmt_fetch($stmt)) {
            mysqli_stmt_close($stmt);

            // Update fine status to paid
            $update_sql = "UPDATE student_fines SET status = 'paid', updated_by = ? WHERE violation_id = ?";
            $update_stmt = mysqli_prepare($conn, $update_sql);

            if ($update_stmt) {
                mysqli_stmt_bind_param($update_stmt, 'ii', $loggedInUser, $violation_id);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);

                // Add notification
                $message = "Your fine has been marked as paid. Thank you!";
                $type = "paid";

                $notif_sql = "INSERT INTO tbl_user_notifications (student_no, book_id, message, type, created_at, is_read) 
                              VALUES (?, ?, ?, ?, NOW(), 0)";
                $notif_stmt = $conn->prepare($notif_sql);
                $notif_stmt->bind_param("siss", $student_no, $book_id, $message, $type);
                $notif_stmt->execute();

                echo "Fine marked as paid and notification sent.";
            } else {
                echo "Failed to prepare update statement.";
            }
        } else {
            mysqli_stmt_close($stmt);
            echo "No unpaid fine found for this fine ID.";
        }
    } else {
        echo "Error preparing fetch statement: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
