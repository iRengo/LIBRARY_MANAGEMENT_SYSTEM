<?php
session_start();
include '../homepage/db_connect.php';

ini_set('display_errors', 0); 
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php-error.log'); 
error_reporting(E_ALL);

// Ensure JSON output only
header('Content-Type: application/json');

// Check if session exists
if (!isset($_SESSION['librarian_no'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

$librarian_id = $_SESSION['librarian_no'];

// Get librarian name
$librarian_query = "SELECT first_name FROM librarian_acc WHERE librarian_no = ?";
$stmt = $conn->prepare($librarian_query);
$stmt->bind_param("s", $librarian_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $handled_by = $result->fetch_assoc()['first_name'];
} else {
    echo json_encode(["success" => false, "message" => "Librarian not found."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $borrow_id = $_POST['borrow_id'] ?? '';
    $student_no = $_POST['student_no'] ?? '';
    $book_id = $_POST['book_id'] ?? '';
    $book_condition = $_POST['book_condition'] ?? '';
    $return_date = date('Y-m-d H:i:s');

    if (!$borrow_id || !$student_no || !$book_id || !$book_condition) {
        echo json_encode(["success" => false, "message" => "Missing required fields."]);
        exit;
    }

    // Get book title
    $book_query = "SELECT book_title FROM tbl_books WHERE book_id = ?";
    $stmt = $conn->prepare($book_query);
    $stmt->bind_param("s", $book_id);
    $stmt->execute();
    $book_result = $stmt->get_result();

    if ($book_result && $book_result->num_rows > 0) {
        $book_title = $book_result->fetch_assoc()['book_title'];
    } else {
        echo json_encode(["success" => false, "message" => "Book not found."]);
        exit;
    }

    // Insert into returned_books
    $insert_query = "INSERT INTO returned_books (borrow_id, book_id, book_title, student_no, return_date, book_condition, handled_by)
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("sssssss", $borrow_id, $book_id, $book_title, $student_no, $return_date, $book_condition, $handled_by);

    if ($stmt->execute()) {
        // Update borrowed_books status
        $update = $conn->prepare("UPDATE borrowed_books SET status = 'Returned' WHERE borrow_id = ?");
        $update->bind_param("s", $borrow_id);
        $update->execute();

        echo json_encode(["success" => true, "message" => "Book return recorded successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
    }
}
?>
