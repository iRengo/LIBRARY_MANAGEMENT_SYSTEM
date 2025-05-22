<?php
session_start();
include 'db_connect.php';

$student_no = $_SESSION['student_no'] ?? null;

if (!$student_no || !isset($_POST['notif_id'])) {
    http_response_code(400);
    echo "Invalid request.";
    exit;
}

$notif_id = $_POST['notif_id'];

$sql = "UPDATE tbl_user_notifications SET is_read = 1 WHERE notif_id = ? AND student_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $notif_id, $student_no);

if ($stmt->execute()) {
    echo "Notification marked as read.";
} else {
    echo "Failed to update notification.";
}

$stmt->close();
