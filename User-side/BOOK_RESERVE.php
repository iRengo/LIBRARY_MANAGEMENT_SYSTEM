<?php
session_start();
include '../homepage/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $book_id = $_POST['book_id'];
    $book_title = $_POST['book_title'];
    $author = $_POST['author'];
    $ISBN = $_POST['ISBN'];
    $acc_no = $_POST['acc_no'];
    $student_no = $_POST['student_no'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $borrow_date = $_POST['borrow_date'];
    $reserved_date = date("Y-m-d");
    $status = "Pending";  // Default status for reservation

    // Check if the user has already reserved this book
    $sql_check = "SELECT * FROM reserved_books WHERE book_id = ? AND student_no = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $book_id, $student_no);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // User has already reserved this book
        echo '<script>alert("You have already reserved this book.");</script>';
        header("Location: BOOK-DETAILS.PHP?book_id=" . urlencode($book_id)); // Redirect back to the book details page
        exit();
    } else {
        // Proceed with reservation
        $sql = "INSERT INTO reserved_books 
            (book_title, author, reserved_date, acc_no, book_id, student_no, first_name, last_name, ISBN, email) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $book_title, $author, $reserved_date, $acc_no, $book_id, $student_no, $first_name, $last_name, $ISBN, $email);

        if ($stmt->execute()) {
            // Redirect back to book details page with the success parameter
            header("Location: BOOK-DETAILS.PHP?book_id=" . urlencode($book_id) . "&success=1");
            exit();
        } else {
            echo '<script>alert("Reservation failed: ' . $stmt->error . '");</script>';
        }

        $stmt->close();
    }

    $stmt_check->close();
    $conn->close();
}
?>
