<?php
include '../homepage/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];

    if ($role === 'Librarian') {
        $sourceTable = 'librarian_acc';
        $idColumn = 'librarian_no';
    } elseif ($role === 'Student') {
        $sourceTable = 'stud_acc';
        $idColumn = 'acc_no';
    } else {
        echo 'Invalid role';
        exit;
    }

    // Fetch user from source table
    $stmt = $conn->prepare("SELECT * FROM $sourceTable WHERE $idColumn = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Handle student_no (only for Student role)
        $student_no = ($role === 'Student') ? $user['student_no'] : null;
        $contact = $user['contact'] ?? '';
        $verified = $user['verified'] ?? 0;

        // Insert into archived_acc
        $insert = $conn->prepare("INSERT INTO archived_acc 
            (user_id, student_no, password, first_name, last_name, email, contact, role, archived_at, verified) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");

        $insert->bind_param(
            "ssssssssi",
            $user_id,
            $student_no,
            $user['password'],
            $user['first_name'],
            $user['last_name'],
            $user['email'],
            $contact,
            $role,
            $verified
        );

        if ($insert->execute()) {
            // Delete from original table
            $delete = $conn->prepare("DELETE FROM $sourceTable WHERE $idColumn = ?");
            $delete->bind_param("s", $user_id);
            $delete->execute();

            echo "User archived successfully.";
        } else {
            echo "Failed to archive user.";
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid request.";
}
?>
