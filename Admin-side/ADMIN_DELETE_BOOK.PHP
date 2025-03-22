<?php
include '../homepage/db_connect.php';

if (isset($_GET['book_id'])) {
    $book_id = intval($_GET['book_id']);
    
    $query = "DELETE FROM tbl_books WHERE book_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $book_id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: admin_catalog.php?success=Book deleted successfully");
        exit();
    } else {
        echo "Error deleting book: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
