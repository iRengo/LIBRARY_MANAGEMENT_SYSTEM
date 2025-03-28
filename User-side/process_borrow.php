<?php
session_start();
include '../homepage/db_connect.php';

if (isset($_POST['borrow_book'])) {
    $acc_no = $_SESSION['acc_no'];
    
    // Extract first_name and last_name
    $student_name = $_POST['student_name'];
    $name_parts = explode(' ', $student_name, 2);
    $first_name = $name_parts[0] ?? ''; 
    $last_name = $name_parts[1] ?? '';

    $student_no = $_POST['student_no'];
    $book_id = $_POST['book_id'];
    $book_title = $_POST['book_title'];
    $book_author = $_POST['book_author'];
    $ISBN = $_POST['isbn']; 

    $borrow_date = $_POST['borrow_date'];
    $due_date = $_POST['due_date'];

    // Check if user already borrowed this book
    $check_query = "SELECT * FROM borrowed_books WHERE acc_no = ? AND book_id = ? AND status = 'Pending'";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("si", $acc_no, $book_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Your borrow status is pending!";
        header("Location: book-details.php?book_id=" . $book_id);
        exit();
    }

    // Insert into borrowed_books
    $insert_query = "INSERT INTO borrowed_books (acc_no, student_no, first_name, last_name, book_id, book_title, author, ISBN, borrow_date, due_date, status) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
    
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssssisssss", $acc_no, $student_no, $first_name, $last_name, $book_id, $book_title, $book_author, $ISBN, $borrow_date, $due_date);

    if ($stmt->execute()) {
        // Reduce book stocks by 1
        $update_stock_query = "UPDATE tbl_books SET book_stocks = book_stocks - 1 WHERE book_id = ?";
        $update_stmt = $conn->prepare($update_stock_query);
        $update_stmt->bind_param("i", $book_id);
        $update_stmt->execute();

       // Insert into borrowing_history
        $insert_history = "INSERT INTO borrowing_history (book_id, acc_no, book_title, borrow_date, due_date, status) 
        VALUES (?, ?, ?, ?, ?, 'Pending')";
        $stmt_history = $conn->prepare($insert_history);
        $stmt_history->bind_param("issss", $book_id, $acc_no, $book_title, $borrow_date, $due_date);
        $stmt_history->execute();

        $_SESSION['success'] = "Book successfully borrowed!";
        header("Location: user_dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Error borrowing book. Please try again.";
        header("Location: book-details.php?book_id=" . $book_id);
        exit();
    }
}
?>
