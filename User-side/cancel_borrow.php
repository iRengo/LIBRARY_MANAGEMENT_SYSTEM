<?php
session_start();
include '../homepage/db_connect.php';

if (!isset($_SESSION['acc_no'])) {
    echo '<script>
        alert("You are not logged in!");
        window.location.href = "../homepage/homepage.php";
    </script>';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_no = $_POST['student_no'];
    $book_id = $_POST['book_id'];

    // Only cancel if the request is still pending
    $check = $conn->prepare("SELECT * FROM borrowed_books WHERE student_no = ? AND book_id = ? AND status = 'Pending'");
    $check->bind_param("si", $student_no, $book_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Delete the pending request
        $delete = $conn->prepare("DELETE FROM borrowed_books WHERE student_no = ? AND book_id = ? AND status = 'Pending'");
        $delete->bind_param("si", $student_no, $book_id);
        if ($delete->execute()) {
            // Restore the book stock
            $update = $conn->prepare("UPDATE tbl_books SET book_stocks = book_stocks + 1 WHERE book_id = ?");
            $update->bind_param("i", $book_id);
            $update->execute();
            $update->close();

            // Redirect to book-details.php with a success flag
            header("Location: book-details.php?book_id=" . urlencode($book_id) . "&cancelled=1");
            exit();
        }
        $delete->close();
    } else {
        // Redirect with error flag (optional: can be used to show another alert)
        header("Location: book-details.php?book_id=" . urlencode($book_id) . "&cancelled=0");
        exit();
    }

    $check->close();
    $conn->close();
}
?>
