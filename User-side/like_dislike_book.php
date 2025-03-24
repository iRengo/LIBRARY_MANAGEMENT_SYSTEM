<?php
session_start();
include '../homepage/db_connect.php';

if (!isset($_SESSION['acc_no'])) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit();
}

$acc_no = $_SESSION['acc_no'];
$book_id = $_POST['book_id'];
$action = $_POST['action']; // "like" or "dislike"

// Remove previous vote if exists
$stmt = $conn->prepare("DELETE FROM book_likes_dislikes WHERE acc_no = ? AND book_id = ?");
$stmt->bind_param("ii", $acc_no, $book_id);
$stmt->execute();

// Insert new vote
$stmt = $conn->prepare("INSERT INTO book_likes_dislikes (acc_no, book_id, action) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $acc_no, $book_id, $action);
$stmt->execute();

// Count likes & dislikes
$stmt = $conn->prepare("SELECT 
    SUM(CASE WHEN action='like' THEN 1 ELSE 0 END) AS likes, 
    SUM(CASE WHEN action='dislike' THEN 1 ELSE 0 END) AS dislikes 
    FROM book_likes_dislikes WHERE book_id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$stmt->bind_result($like_count, $dislike_count);
$stmt->fetch();

echo json_encode(["success" => true, "likes" => $like_count, "dislikes" => $dislike_count]);

$stmt->close();
$conn->close();
?>
