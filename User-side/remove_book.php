<?php
include '../homepage/db_connect.php';   

if (isset($_GET['collection_id'])) {
    $collection_id = intval($_GET['collection_id']);

    // Delete the book from the collection_books table
    $query = "DELETE FROM collection_books WHERE collection_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $collection_id);
    
    if ($stmt->execute()) {
        // Redirect without alert
        header("Location: USER_COLLECTION.PHP");
        exit(); // Ensure script stops execution after redirect
    }
    $stmt->close();
}

$conn->close();
?>
