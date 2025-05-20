<?php
include '../Homepage/db_connect.php';

$all = isset($_GET['all']) && $_GET['all'] === 'true';

if ($all) {
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
        GROUP BY b.book_id
        ORDER BY borrow_count DESC
    ";
} else {
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 13;
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
        GROUP BY b.book_id
        ORDER BY borrow_count DESC
        LIMIT $offset, $limit
    ";
}

$result = mysqli_query($conn, $query);
$books = [];

while ($row = mysqli_fetch_assoc($result)) {
    $books[] = $row;
}

header('Content-Type: application/json');
echo json_encode($books);
