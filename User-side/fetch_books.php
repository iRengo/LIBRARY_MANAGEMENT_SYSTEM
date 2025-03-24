<?php
session_start();
include '../homepage/db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['acc_no']) || !isset($_GET['type'])) {
    echo json_encode(["error" => "Access Denied."]);
    exit;
}

$acc_no = $_SESSION['acc_no'];
$type = $_GET['type'];

$query = "";
if ($type == "due") {
    $query = "SELECT book_title, author, due_date FROM borrowed_books WHERE acc_no = ? AND due_date = CURDATE() AND status = 'borrowed'";
} elseif ($type == "borrowed") {
    $query = "SELECT book_title, author, borrowed_at FROM borrowed_books WHERE acc_no = ? AND status = 'borrowed'";
} elseif ($type == "overdue") {
    $query = "SELECT book_title, author, borrowed_at FROM borrowed_books WHERE acc_no = ? AND due_date < NOW() AND status = 'borrowed'";
} elseif ($type == "reserved") {
    $query = "SELECT book_title, author, reserved_date FROM reserved_books WHERE acc_no = ? AND status = 'reserved'";
} else {
    echo json_encode(["error" => "Invalid request."]);
    exit;
}

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $acc_no);
$stmt->execute();
$result = $stmt->get_result();

$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

echo json_encode($books);

$stmt->close();
$conn->close();
?>
