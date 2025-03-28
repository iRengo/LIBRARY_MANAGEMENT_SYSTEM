<?php
// fetch_books.php

// Include database connection
include '../homepage/db_connect.php';

// Get the status from the POST request
$status = json_decode(file_get_contents('php://input'))->status;

if ($status == 'borrowed') {
    $query = "SELECT book_title, author, borrow_date, status FROM borrowed_books";
} elseif ($status == 'reserved') {
    $query = "SELECT book_title, author, reserved_date AS borrow_date, status FROM reserved_books";
} else {
    echo json_encode([]);
    exit;
}

$result = $conn->query($query);

$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

echo json_encode($books);

$conn->close();
?>
