<?php
include '../homepage/db_connect.php';
session_start();

$loggedInUser = $_SESSION['librarian_no'];

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fine_id = $_POST['fine_id'];
    $student_no = $_POST['student_no'];
    $book_id = $_POST['book_id'];
    $borrow_id = $_POST['borrow_id'];
    $date_issued = date('Y-m-d H:i:s');
    $status = 'Unpaid';

    // Handle file upload
    $upload_dir = '../public/proofs/';
    $proof_filename = null;

    if (!empty($_FILES['proof_image']['name'])) {
        $file_tmp = $_FILES['proof_image']['tmp_name'];
        $file_name = basename($_FILES['proof_image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_ext, $allowed_ext)) {
            echo json_encode(["success" => false, "message" => "Invalid file type. Only JPG, PNG, and GIF allowed."]);
            exit;
        }

        $new_filename = uniqid("proof_") . '.' . $file_ext;
        $target_path = $upload_dir . $new_filename;


        if (!move_uploaded_file($file_tmp, $target_path)) {
            echo json_encode(["success" => false, "message" => "Failed to upload proof image."]);
            exit;
        }

        $proof_filename = $new_filename;
    }
    $stmt = $conn->prepare("INSERT INTO student_fines (student_no, book_id, fine_id, date_issued, status, proof, updated_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisssi", $student_no, $book_id, $fine_id, $date_issued, $status, $proof_filename, $loggedInUser);


    if ($stmt->execute()) {

        // Insert into tbl_user_notifications
        $notif_type = 'pending_fine';
        $notif_message = "You have been issued a fine for a returned book due to damage or other issues.";
        $notif_created_at = date('Y-m-d H:i:s');

        $notif_stmt = $conn->prepare("INSERT INTO tbl_user_notifications (student_no, book_id, type, message, created_at) VALUES (?, ?, ?, ?, ?)");
        $notif_stmt->bind_param("sssss", $student_no, $book_id, $notif_type, $notif_message, $notif_created_at);
        $notif_stmt->execute();
        $notif_stmt->close();
        // Update book status
        $update = $conn->prepare("UPDATE borrowed_books SET status = 'Returned' WHERE borrow_id = ?");
        $update->bind_param("s", $borrow_id);
        if ($update->execute()) {
            echo json_encode(["success" => true, "message" => "Fine issued and book marked as returned."]);
        } else {
            echo json_encode(["success" => false, "message" => "Fine issued, but failed to update book status: " . $conn->error]);
        }
        $update->close();
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
