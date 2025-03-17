<?php
include '../homepage/db_connect.php';

// Get the data from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$archived_id = $data['archived_id'];

// Delete the user from the archived_acc table
$delete_sql = "DELETE FROM archived_acc WHERE archived_id = ?";
$stmt = $conn->prepare($delete_sql);
$stmt->bind_param("i", $archived_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting the user']);
}
?>
