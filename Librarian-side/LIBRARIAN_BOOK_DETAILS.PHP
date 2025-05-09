<?php
include '../homepage/db_connect.php';

// Get book_id from the request
$data = json_decode(file_get_contents('php://input'), true);
$book_id = $data['book_id'];

if ($book_id) {
    // Fetch the book details
    $query = "SELECT book_title, book_cover FROM tbl_books WHERE book_id = '$book_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $book = mysqli_fetch_assoc($result);
        echo json_encode([
            'success' => true,
            'book_title' => $book['book_title'],
            'book_cover' => $book['book_cover']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Book not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Book ID is missing.']);
}
?>
