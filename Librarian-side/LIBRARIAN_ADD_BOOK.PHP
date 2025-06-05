<?php
include '../homepage/db_connect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookTitle = $_POST['bookTitle'];
    $bookAuthor = $_POST['author']; // Capture the author input
    $bookDescription = $_POST['bookDescription'];
    $publisherId = $_POST['publisher'];
    $publicationDate = $_POST['publication_date'];
    $isbn = $_POST['isbn'];
    $bookGenreId = $_POST['book_genre'];
    $bookCategory = $_POST['book_category'];
    $bookStocks = $_POST['book_stocks'];
    $status = $_POST['status'];

    if (isset($_FILES['bookCover']) && $_FILES['bookCover']['error'] == 0) {
        $targetDir = "../public/book_covers/";

        // Make sure the directory exists or create it
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fileName = basename($_FILES["bookCover"]["name"]);
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $fileName);
        $targetFilePath = $targetDir . $fileName;

        if (!move_uploaded_file($_FILES["bookCover"]["tmp_name"], $targetFilePath)) {
            echo json_encode(["success" => false, "message" => "File upload failed."]);
            exit;
        }
    } else {
        echo json_encode(["success" => false, "message" => "No valid file uploaded."]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO tbl_books (book_cover, book_title, book_author, book_description, publisher, publication_date, isbn, book_category, book_genre, book_stocks, status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssis", $targetFilePath, $bookTitle, $bookAuthor, $bookDescription, $publisherId, $publicationDate, $isbn, $bookCategory, $bookGenreId, $bookStocks, $status);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Book added successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Database Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
