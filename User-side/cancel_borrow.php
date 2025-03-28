<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../homepage/db_connect.php';

if (isset($_POST['book_id']) && isset($_POST['borrowing_id'])) {
    $book_id = $_POST['book_id'];
    $borrowing_id = $_POST['borrowing_id'];

    // Delete from borrowed_books
    $delete_borrowed_query = "DELETE FROM borrowed_books WHERE book_id = ? AND acc_no = ?";
    $delete_borrowed_stmt = $conn->prepare($delete_borrowed_query);
    if (!$delete_borrowed_stmt) {
        die("Error preparing delete query: " . $conn->error);
    }
    $delete_borrowed_stmt->bind_param("is", $book_id, $_SESSION['acc_no']);
    if (!$delete_borrowed_stmt->execute()) {
        die("Error executing delete query: " . $delete_borrowed_stmt->error);
    }

    // Delete from borrowing_history
    $delete_history_query = "DELETE FROM borrowing_history WHERE borrowing_id = ? AND acc_no = ?";
    $delete_history_stmt = $conn->prepare($delete_history_query);
    if (!$delete_history_stmt) {
        die("Error preparing delete query: " . $conn->error);
    }
    $delete_history_stmt->bind_param("is", $borrowing_id, $_SESSION['acc_no']);
    if (!$delete_history_stmt->execute()) {
        die("Error executing delete query: " . $delete_history_stmt->error);
    }

    // Restore book stock
    $update_stock_query = "UPDATE tbl_books SET book_stocks = book_stocks + 1 WHERE book_id = ?";
    $update_stock_stmt = $conn->prepare($update_stock_query);
    if (!$update_stock_stmt) {
        die("Error preparing stock update query: " . $conn->error);
    }
    $update_stock_stmt->bind_param("i", $book_id);
    if (!$update_stock_stmt->execute()) {
        die("Error executing stock update query: " . $update_stock_stmt->error);
    }

    $_SESSION['success'] = "Borrow request canceled successfully!";
    header("Location: user_dashboard.php");
    exit();
} else {
    die("Error: Missing book_id or borrowing_id.");
}
?>
