<?php
include '../homepage/db_connect.php';
session_start();

if (!isset($_SESSION['acc_no'])) {
    die("Access Denied. Please log in.");
}

$acc_no = $_SESSION['acc_no'];

$query_borrow = "SELECT borrowing_id, book_id, book_title, borrow_date, due_date, return_date, status 
                 FROM borrowing_history 
                 WHERE acc_no = ?";
$stmt_borrow = $conn->prepare($query_borrow);
$stmt_borrow->bind_param("s", $acc_no);
$stmt_borrow->execute();
$result_borrow = $stmt_borrow->get_result();

$stmt_borrow->close();
?>
