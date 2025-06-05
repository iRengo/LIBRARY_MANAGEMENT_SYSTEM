<?php
include '../homepage/db_connect.php';

if (isset($_GET['query'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['query']); 

    // SQL query to fetch books based on the search term
    $query = "SELECT book_id, book_cover, book_title, book_author, book_category FROM tbl_books WHERE book_title LIKE '%$search_query%' AND (status = 'Available' OR status = 'Upcoming')";
    $result = mysqli_query($conn, $query);

   $books[] = [
    'book_id' => $row['book_id'],
    'book_cover' => $row['book_cover'],
    'book_title' => $row['book_title'],
    'book_author' => $row['book_author'],
    'category' => $row['book_category'], 
];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $books[] = $row; 
        }
    }

    // Return the result as a JSON object
    echo json_encode($books);
} else {
    echo json_encode([]);
}
?>
