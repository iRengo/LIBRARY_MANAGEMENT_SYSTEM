<?php
header('Content-Type: application/json');
include '../homepage/db_connect.php';

// Get the data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($data['archived_id'], $data['role'])) {
    echo json_encode(['success' => false, 'message' => 'Missing data']);
    exit();
}

$archived_id = $data['archived_id'];
$role = $data['role'];

// Define table names for each role
$role_tables = [
    'Admin' => 'admin_acc',
    'Librarian' => 'librarian_acc',
    'Student' => 'stud_acc'
];

// Check if the role is valid
if (!isset($role_tables[$role])) {
    echo json_encode(['success' => false, 'message' => 'Invalid role']);
    exit();
}

$table = $role_tables[$role];

// Fetch archived user data
$select_sql = "SELECT * FROM archived_acc WHERE archived_id = ?";
$stmt = $conn->prepare($select_sql);
$stmt->bind_param("i", $archived_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Insert the user data back into their original table (without user_id or role)
    $insert_sql = "INSERT INTO $table (password, first_name, last_name, email)
                   VALUES (?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("ssss", $user['password'], $user['first_name'], $user['last_name'], $user['email']);
    $insert_stmt->execute();

    // Delete the user from the archived_acc table
    $delete_sql = "DELETE FROM archived_acc WHERE archived_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $archived_id);
    $delete_stmt->execute();

    echo json_encode(['success' => true, 'message' => 'User restored successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
}

$stmt->close();
$conn->close();
?>
