<?php
include '../Homepage/db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['book_id'])) {
    $book_id = $data['book_id'];
    $title = mysqli_real_escape_string($conn, $data['book_title']);
    $author = mysqli_real_escape_string($conn, $data['book_author']);
    $isbn = mysqli_real_escape_string($conn, $data['ISBN']);
    $genre = mysqli_real_escape_string($conn, $data['book_category']);
    $pub_date = mysqli_real_escape_string($conn, $data['publication_date']);
    $publisher = mysqli_real_escape_string($conn, $data['publisher']);
    $stocks = intval($data['book_stocks']);
    $desc = mysqli_real_escape_string($conn, $data['book_description']);

    $sql = "UPDATE tbl_books SET 
        book_title='$title',
        book_author='$author',
        ISBN='$isbn',
        book_category='$genre',
        publication_date='$pub_date',
        publisher='$publisher',
        book_stocks=$stocks,
        book_description='$desc'
        WHERE book_id=$book_id";

    if (mysqli_query($conn, $sql)) {
        echo "Book updated successfully.";
    } else {
        echo "Error updating book: " . mysqli_error($conn);
    }
} else {
    echo "Invalid data.";
}
?>
