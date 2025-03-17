<?php
include '../homepage/db_connect.php';

// Fetch archived users from the archived_acc table
$sql = "SELECT archived_id,user_id,first_name,last_name,email,role, archived_at FROM archived_acc";
$result = $conn->query($sql);

$archived_users = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $archived_users[] = $row;
    }
}

echo json_encode($archived_users);
?>
