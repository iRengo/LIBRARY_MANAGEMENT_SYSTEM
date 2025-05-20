<?php
include '../homepage/db_connect.php';

if (isset($_GET['book_id'])) {
    $book_id = intval($_GET['book_id']);

    // Fetch the book details from the archived table
    $select_query = "SELECT * FROM tbl_archived_books WHERE book_id = ?";
    $stmt = $conn->prepare($select_query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();

    if ($book) {
        // Insert into the books table
        $insert_query = "INSERT INTO tbl_books (book_id, book_cover, book_title, book_author, book_description, publisher, publication_date, ISBN, book_genre, book_stocks, status) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($insert_query);
        $stmt_insert->bind_param(
            "issssssssis",
            $book['book_id'],
            $book['book_cover'],
            $book['book_title'],
            $book['book_author'],
            $book['book_description'],
            $book['publisher'],
            $book['publication_date'],
            $book['ISBN'],
            $book['book_genre'],
            $book['book_stocks'],
            $book['status']
        );
        $stmt_insert->execute();

        // Delete from archived table
        $delete_query = "DELETE FROM tbl_archived_books WHERE book_id = ?";
        $stmt_delete = $conn->prepare($delete_query);
        $stmt_delete->bind_param("i", $book_id);
        $stmt_delete->execute();

        session_start();
        $_SESSION['archive_success'] = "Book restored successfully.";
        header("Location: admin_catalog.php");
        exit();
    } else {
        echo "Book not found in archive.";
    }
} else {
    echo "Invalid request.";
}
