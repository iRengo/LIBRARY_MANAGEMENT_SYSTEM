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
    $damage_description = $_POST['damage_description'];
    $penalty_amount = $_POST['penalty_amount'];
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

    $targetDir = "proofs/";
    $proof_name = basename($_FILES["proof"]["name"]);
    $targetFilePath = $targetDir . time() . "_" . $proof_name;

    if (move_uploaded_file($_FILES["proof"]["tmp_name"], $targetFilePath)) {
        // Insert into returned_books including book_title
        $sql = "INSERT INTO returned_books 
                (borrow_id, book_id, book_title, student_no, return_date, book_condition, damage_description, penalty_amount, proof, handled_by)
                VALUES 
                ('$borrow_id', '$book_id', '$book_title', '$student_no', '$return_date', '$book_condition', '$damage_description', '$penalty_amount', '$targetFilePath', '$handled_by')";

        if (mysqli_query($conn, $sql)) {
            // Update status in borrowed_books
            $update_sql = "UPDATE borrowed_books SET status='Returned' WHERE borrow_id='$borrow_id'";
            mysqli_query($conn, $update_sql);
            echo json_encode(["success" => true, "message" => "Book return recorded successfully!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Database error: " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Failed to upload proof file."]);
    }
}
?>
