<?php
include '../homepage/db_connect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookTitle = $_POST['bookTitle'];
    $bookDescription = $_POST['bookDescription'];
    $publisherId = $_POST['publisher_id'];
    $publicationDate = $_POST['publication_date'];
    $isbn = $_POST['isbn'];
    $bookGenreId = $_POST['book_genre_id'];
    $bookStocks = $_POST['book_stocks'];
    $status = $_POST['status'];

    // Handle Book Cover Upload
    if (isset($_FILES['bookCover']) && $_FILES['bookCover']['error'] == 0) {
        $targetDir = "book_covers/";
        $fileName = basename($_FILES["bookCover"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (!move_uploaded_file($_FILES["bookCover"]["tmp_name"], $targetFilePath)) {
            echo json_encode(["success" => false, "message" => "File upload failed."]);
            exit;
        }
    } else {
        echo json_encode(["success" => false, "message" => "No valid file uploaded."]);
        exit;
    }

    // Insert into Database
    $stmt = $conn->prepare("INSERT INTO tbl_books (book_cover, book_title, book_description, publisher_id, publication_date, isbn, book_genre_id, book_stocks, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssis", $targetFilePath, $bookTitle, $bookDescription, $publisherId, $publicationDate, $isbn, $bookGenreId, $bookStocks, $status);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Database Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
