<?php
session_start();
include '../homepage/db_connect.php';

if (isset($_GET['book_id'])) {
    $book_id = intval($_GET['book_id']);


    $conn->begin_transaction();

    try {

        $select_query = "SELECT * FROM tbl_books WHERE book_id = ?";
        $stmt = $conn->prepare($select_query);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $book = $result->fetch_assoc();

        if (!$book) {
            throw new Exception("Book not found.");
        }

       
        $book_cover = $book['book_cover'];
        $book_title = $book['book_title'];
        $book_author = $book['book_author'];
        $book_description = $book['book_description'];
        $publisher = $book['publisher'];
        $publication_date = $book['publication_date']; 
        $isbn = $book['ISBN']; 
        $book_genre = $book['book_genre'];
        $book_stocks = $book['book_stocks']; 
        $status = $book['status'];


        $insert_query = "INSERT INTO tbl_archived_books 
            (book_id, book_cover, book_title, book_author, book_description, publisher, publication_date, ISBN, book_genre, book_stocks, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_insert = $conn->prepare($insert_query);
        $stmt_insert->bind_param(
            "issssssssis", 
            $book_id,
            $book_cover,
            $book_title,
            $book_author,
            $book_description,
            $publisher,
            $publication_date,
            $isbn,
            $book_genre,
            $book_stocks,
            $status
        );

        if (!$stmt_insert->execute()) {
            throw new Exception("Failed to archive book: " . $stmt_insert->error);
        }

        // SUCCESSFUL INSERT INTO ARCHIVE — continue with deletion

        // returned_books
        $del_returned = $conn->prepare("DELETE FROM returned_books WHERE book_id = ?");
        $del_returned->bind_param("i", $book_id);
        if (!$del_returned->execute()) {
            throw new Exception("Failed deleting returned_books: " . $del_returned->error);
        }

        // borrowed_books
        $del_borrowed = $conn->prepare("DELETE FROM borrowed_books WHERE book_id = ?");
        $del_borrowed->bind_param("i", $book_id);
        if (!$del_borrowed->execute()) {
            throw new Exception("Failed deleting borrowed_books: " . $del_borrowed->error);
        }

        // reserved_books
        $del_reserved = $conn->prepare("DELETE FROM reserved_books WHERE book_id = ?");
        $del_reserved->bind_param("i", $book_id);
        if (!$del_reserved->execute()) {
            throw new Exception("Failed deleting reserved_books: " . $del_reserved->error);
        }

        // Finally, delete the book from tbl_books
        $del_book = $conn->prepare("DELETE FROM tbl_books WHERE book_id = ?");
        $del_book->bind_param("i", $book_id);
        if (!$del_book->execute()) {
            throw new Exception("Failed deleting book: " . $del_book->error);
        }

        // Commit all changes
        $conn->commit();

        $_SESSION['archive_success'] = "Book archived successfully.";
        header("Location: admin_catalog.php");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "Invalid request.";
}
?>
