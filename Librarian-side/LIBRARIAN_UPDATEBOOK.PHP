<?php
// update_book.php
header('Content-Type: application/json');

include '../Homepage/db_connect.php'; 

// Get POST data safely
$book_id = $_POST['book_id'] ?? null;
$book_title = $_POST['book_title'] ?? null;
$book_author = $_POST['book_author'] ?? null;
$ISBN = $_POST['ISBN'] ?? null;
$book_language = $_POST['book_language'] ?? '';
$publisher = $_POST['publisher'] ?? null;
$publication_date = $_POST['publication_date'] ?? null;
$book_stocks = $_POST['book_stocks'] ?? null;
$book_description = $_POST['book_description'] ?? null;

if (!$book_id || !$book_title || !$book_author || !$ISBN || !$publisher || !$publication_date || $book_stocks === null || !$book_description) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

// Validate numeric stock
if (!is_numeric($book_stocks) || $book_stocks < 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid stocks value.']);
    exit;
}

$book_id = intval($book_id);
$book_stocks = intval($book_stocks);

// Prepare and bind
$stmt = $conn->prepare("UPDATE tbl_books SET 
    book_title = ?, 
    book_author = ?, 
    ISBN = ?, 
    book_genre = ?, 
    publisher = ?, 
    publication_date = ?, 
    book_stocks = ?, 
    book_description = ?
    WHERE book_id = ?");

if(!$stmt){
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement.']);
    exit;
}

// Assuming book_genre is empty or you can add input field for it; for now empty
$book_genre = ''; 

$stmt->bind_param("ssssssisi", $book_title, $book_author, $ISBN, $book_genre, $publisher, $publication_date, $book_stocks, $book_description, $book_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update book info.']);
}

$stmt->close();
$conn->close();
?>
