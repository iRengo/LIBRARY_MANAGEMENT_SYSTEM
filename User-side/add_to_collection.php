<?php
session_start();
include '../homepage/db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['acc_no']) || empty($_SESSION['acc_no'])) {
    $_SESSION['message'] = "Error: User not logged in.";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])) {
    $book_id = intval($_POST['book_id']);
    $acc_no = $_SESSION['acc_no'];

    // Fetch book details from tbl_books
    $bookQuery = "SELECT book_title, book_author, book_cover, book_description FROM tbl_books WHERE book_id = ?";
    $stmt = $conn->prepare($bookQuery);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $bookResult = $stmt->get_result();

    if ($bookResult->num_rows > 0) {
        $bookData = $bookResult->fetch_assoc();
        $book_title = $bookData['book_title'];
        $author = $bookData['book_author'];
        $image_path = $bookData['book_cover'];
        $description = $bookData['book_description'];

        // Check if the book is already in the collection
        $checkQuery = "SELECT * FROM collection_books WHERE acc_no = ? AND book_id = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("ii", $acc_no, $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['message'] = "This book is already in your collection!";
        } else {
            // Insert into collection_books
            $insertQuery = "INSERT INTO collection_books (acc_no, book_id, book_title, author, image_path, description) 
                            VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("iissss", $acc_no, $book_id, $book_title, $author, $image_path, $description);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Book successfully added to your collection!";
            } else {
                $_SESSION['message'] = "Failed to add book. Please try again.";
            }
        }
    } else {
        $_SESSION['message'] = "Error: Book not found.";
    }
}

// Redirect back with message
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>
