<?php
include '../homepage/db_connect.php';

if (isset($_GET['query'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['query']); // Get and sanitize the search query

    // SQL query to fetch books based on the search term
    $query = "SELECT book_id, book_cover, book_title, book_author FROM tbl_books WHERE book_title LIKE '%$search_query%' AND status = 'Available' or status = 'Upcoming'";
    $result = mysqli_query($conn, $query);

    // Initialize an array to hold the results
    $books = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $books[] = $row; // Add each row to the books array
        }
    }

    // Return the result as a JSON object
    echo json_encode($books);
} else {
    echo json_encode([]);
}
?>
