<?php
include '../homepage/db_connect.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fine_id = $_POST['fine_id'];
    $student_no = $_POST['student_no'];
    $book_id = $_POST['book_id'];
    $borrow_id = $_POST['borrow_id']; // added this line
    $date_issued = date('Y-m-d H:i:s');
    $status = 'Unpaid';

    $stmt = $conn->prepare("INSERT INTO student_fines (student_no, book_id, fine_id, date_issued, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $student_no, $book_id, $fine_id, $date_issued, $status);

    if ($stmt->execute()) {
        // Now update the borrowed_books table
        $update = $conn->prepare("UPDATE borrowed_books SET status = 'Returned' WHERE borrow_id = ?");
        $update->bind_param("s", $borrow_id);
        if ($update->execute()) {
            echo json_encode(["success" => true, "message" => "Fine issued and book marked as returned."]);
        } else {
            echo json_encode(["success" => false, "message" => "Fine issued, but failed to update book status: " . $conn->error]);
        }
        $update->close();
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
