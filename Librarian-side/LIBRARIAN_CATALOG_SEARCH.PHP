<?php
include '../homepage/db_connect.php'; 

header('Content-Type: application/json');

$search = isset($_GET['query']) ? trim($_GET['query']) : '';

if ($search === '') {
    echo json_encode([]);
    exit;
}

// Sanitize and prepare
$search_safe = mysqli_real_escape_string($conn, $search);

// SQL to match title or author
$query = "
    SELECT 
        b.book_id, 
        b.book_cover, 
        b.book_title, 
        b.book_author, 
        b.book_stocks, 
        COUNT(bb.book_id) AS borrow_count
    FROM tbl_books b
    LEFT JOIN borrowed_books bb ON b.book_id = bb.book_id AND bb.status = 'returned'
    WHERE b.status = 'available'
      AND (
        b.book_title LIKE '%$search_safe%' OR 
        b.book_author LIKE '%$search_safe%'
      )
    GROUP BY b.book_id
    ORDER BY borrow_count DESC
    LIMIT 50
";

$result = mysqli_query($conn, $query);

$books = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = [
            'book_id' => $row['book_id'],
            'book_cover' => $row['book_cover'],
            'book_title' => $row['book_title'],
            'book_author' => $row['book_author'],
            'book_stocks' => (int)$row['book_stocks'],
            'borrow_count' => (int)$row['borrow_count'],
        ];
    }
}

echo json_encode($books);
exit;
