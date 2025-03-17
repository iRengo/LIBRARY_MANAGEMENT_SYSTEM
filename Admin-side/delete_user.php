<?php
include '../homepage/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];

    if ($role == 'Student') {
        $sql = "DELETE FROM stud_acc WHERE student_no = ?";
    } elseif ($role == 'Librarian') {
        $sql = "DELETE FROM librarian_acc WHERE librarian_no = ?";
    } elseif ($role == 'Admin') {
        $sql = "DELETE FROM admin_acc WHERE admin_no = ?";
    } else {
        echo json_encode(["success" => false, "error" => "Invalid role."]);
        exit;
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to delete user."]);
    }

    $stmt->close();
    $conn->close();
}
?>
