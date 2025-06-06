<?php
header('Content-Type: application/json');
include '../homepage/db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['archived_id'], $data['role'])) {
    echo json_encode(['success' => false, 'message' => 'Missing data']);
    exit();
}

$archived_id = $data['archived_id'];
$role = $data['role'];

$role_tables = [
    'Admin' => 'admin_acc',
    'Librarian' => 'librarian_acc',
    'Student' => 'stud_acc'
];

if (!isset($role_tables[$role])) {
    echo json_encode(['success' => false, 'message' => 'Invalid role']);
    exit();
}

$table = $role_tables[$role];

$select_sql = "SELECT * FROM archived_acc WHERE archived_id = ?";
$stmt = $conn->prepare($select_sql);
$stmt->bind_param("i", $archived_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if ($role === 'Student') {
        $insert_sql = "INSERT INTO stud_acc 
            (student_no, password, first_name, last_name, email, contact, verified) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ssssssi", 
            $user['student_no'], 
            $user['password'], 
            $user['first_name'], 
            $user['last_name'], 
            $user['email'],
            $user['contact'],
            $user['verified']
        );
    } elseif ($role === 'Librarian') {
        $insert_sql = "INSERT INTO librarian_acc 
            (librarian_no, password, first_name, last_name, email) 
            VALUES (?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sssss", 
            $user['user_id'], 
            $user['password'], 
            $user['first_name'], 
            $user['last_name'], 
            $user['email']
        );
    } else { // Admin
        $insert_sql = "INSERT INTO admin_acc 
            (password, first_name, last_name, email) 
            VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ssss", 
            $user['password'], 
            $user['first_name'], 
            $user['last_name'], 
            $user['email']
        );
    }

    if ($insert_stmt->execute()) {
        $delete_sql = "DELETE FROM archived_acc WHERE archived_id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $archived_id);
        $delete_stmt->execute();

        echo json_encode(['success' => true, 'message' => 'User restored successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error restoring user: ' . $insert_stmt->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
}

$stmt->close();
$conn->close();
?>
