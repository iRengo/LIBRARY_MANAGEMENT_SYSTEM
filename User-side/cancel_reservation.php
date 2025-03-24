<?php
// Include database connection
include '../homepage/db_connect.php';

// Start session
session_start();
if (!isset($_SESSION['acc_no'])) {
    echo json_encode(["status" => "error", "message" => "Access Denied. Please log in."]);
    exit;
}

$acc_no = $_SESSION['acc_no']; // Get logged-in user
$book_title = $_POST['book_title'] ?? ''; // Get book title from AJAX request

if (empty($book_title)) {
    echo json_encode(["status" => "error", "message" => "Invalid book title."]);
    exit;
}

// Delete from reservation_history
$sql_delete_reservation = "DELETE FROM reservation_history WHERE acc_no = ? AND book_title = ?";
$stmt1 = $conn->prepare($sql_delete_reservation);
$stmt1->bind_param("is", $acc_no, $book_title);
$success1 = $stmt1->execute();
$stmt1->close();

// Delete from reserved_books
$sql_delete_reserved_books = "DELETE FROM reserved_books WHERE acc_no = ? AND book_title = ?";
$stmt2 = $conn->prepare($sql_delete_reserved_books);
$stmt2->bind_param("is", $acc_no, $book_title);
$success2 = $stmt2->execute();
$stmt2->close();

// Check if deletion was successful
if ($success1 && $success2) {
    echo json_encode(["status" => "success", "message" => "Reservation canceled successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to cancel reservation."]);
}

$conn->close();
?>
