<?php
include '../homepage/db_connect.php';
session_start();

$librarian_id = $_SESSION['librarian_no'];

$librarian_query = "SELECT first_name FROM librarian_acc WHERE librarian_no = '$librarian_id'";
$librarian_result = mysqli_query($conn, $librarian_query);

if ($librarian_result && mysqli_num_rows($librarian_result) > 0) {
    $librarian_row = mysqli_fetch_assoc($librarian_result);
    $handled_by = $librarian_row['first_name'];
} else {
    echo json_encode(["success" => false, "message" => "Librarian not found."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $borrow_id = $_POST['borrow_id'];
    $student_no = $_POST['student_no'];
    $book_id = $_POST['book_id'];
    $book_condition = $_POST['book_condition'];
    $return_date = date('Y-m-d H:i:s');

    // Fetch the book title
    $book_query = "SELECT book_title FROM tbl_books WHERE book_id = '$book_id'";
    $book_result = mysqli_query($conn, $book_query);
    if ($book_result && mysqli_num_rows($book_result) > 0) {
        $book_row = mysqli_fetch_assoc($book_result);
        $book_title = $book_row['book_title'];
    } else {
        echo json_encode(["success" => false, "message" => "Book not found."]);
        exit;
    }

    // Insert into returned_books (only the existing fields)
    $sql = "INSERT INTO returned_books 
            (borrow_id, book_id, book_title, student_no, return_date, book_condition, handled_by)
            VALUES 
            ('$borrow_id', '$book_id', '$book_title', '$student_no', '$return_date', '$book_condition', '$handled_by')";

    if (mysqli_query($conn, $sql)) {
        // Update status in borrowed_books
        $update_sql = "UPDATE borrowed_books SET status='Returned' WHERE borrow_id='$borrow_id'";
        mysqli_query($conn, $update_sql);
        echo json_encode(["success" => true, "message" => "Book return recorded successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . mysqli_error($conn)]);
    }
}
?>
