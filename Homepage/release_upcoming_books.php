<?php
include 'db_connect.php'; 

$current_date = date('Y-m-d');

$sql = "SELECT * FROM tbl_books WHERE status = 'Upcoming' AND publication_date <= '$current_date'";

// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while ($book = $result->fetch_assoc()) {
        $book_id = $book['book_id'];
        $book_cover = $book['book_cover'];
        $book_title = $book['book_title'];
        $book_author = $book['book_author'];
        $book_description = $book['book_description'];
        $publisher = $book['publisher'];
        $publication_date = $book['publication_date'];
        $isbn = $book['ISBN'];
        $book_genre = $book['book_genre'];
        $book_category = $book['book_category'];
        $book_stocks = $book['book_stocks'];
        $status = 'Available';  

        $update_sql = "UPDATE tbl_books SET status = '$status' WHERE book_id = $book_id";

        if ($conn->query($update_sql) === TRUE) {
        }
    }
}
$conn->close();
?>
