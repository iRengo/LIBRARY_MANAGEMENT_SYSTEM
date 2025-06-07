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
    $damage_description = $_POST['damage_description'];
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
    // Get overdue fine rate from lms_settings (setting_id = 3)
    $settings_sql = "SELECT setting_value FROM lms_settings WHERE setting_id = 3";
    $settings_result = $conn->query($settings_sql);
    $overdue_fine_rate = 0;

    if ($settings_result && $settings_result->num_rows > 0) {
        $setting = $settings_result->fetch_assoc();
        $overdue_fine_rate = (int)$setting['setting_value'];
    }

    // Get due_date from borrowed_books to calculate overdue days
    $borrow_q = $conn->prepare("SELECT due_date FROM borrowed_books WHERE borrow_id = ?");
    $borrow_q->bind_param("s", $borrow_id);
    $borrow_q->execute();
    $borrow_result = $borrow_q->get_result();

    $overdue_days = 0;
    $overdue_amount = 0;

    if ($borrow_result && $borrow_result->num_rows > 0) {
        $borrow_data = $borrow_result->fetch_assoc();
        $due_date = new DateTime($borrow_data['due_date']);
        $today = new DateTime();

        if ($today > $due_date) {
            $interval = $due_date->diff($today);
            $overdue_days = $interval->days;
            $overdue_amount = $overdue_days * $overdue_fine_rate;
        }
    }
    $borrow_q->close();

    // ✅ Fetch damage fine amount using fine_id
    $damage_fine_amount = 0;
    $fine_q = $conn->prepare("SELECT price FROM fines_table WHERE fine_id = ?");
    $fine_q->bind_param("i", $fine_id);
    $fine_q->execute();
    $fine_result = $fine_q->get_result();
    if ($fine_result && $fine_result->num_rows > 0) {
        $damage_fine_amount = $fine_result->fetch_assoc()['price'];
    }
    $fine_q->close();

    // ✅ Compute total fine
    $total_fine = $damage_fine_amount + $overdue_amount;

    // Step 1: Insert into student_fines
    $stmt = $conn->prepare("INSERT INTO student_fines 
(student_no, book_id, fine_id, date_issued, status, proof, updated_by, overdue_days, overdue_amount) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssisssiii",
        $student_no,
        $book_id,
        $fine_id,
        $date_issued,
        $status,
        $proof_filename,
        $loggedInUser,
        $overdue_days,
        $overdue_amount
    );

    if ($stmt->execute()) {
        // Step 2: Insert general fine notification
        $notif_type = 'pending_fine';
        $notif_message = "You have been issued a fine due to book damage (₱$damage_fine_amount). " .
            ($overdue_days > 0 ? "Additionally, ₱$overdue_amount was charged for being $overdue_days day(s) late. " : "") .
            "Total fine: ₱$total_fine.";

        $notif_stmt = $conn->prepare("INSERT INTO tbl_user_notifications (student_no, book_id, type, message, created_at) VALUES (?, ?, ?, ?, NOW())");
        $notif_stmt->bind_param("ssss", $student_no, $book_id, $notif_type, $notif_message);
        $notif_stmt->execute();
        $notif_stmt->close();

        // Step 3: Check if this is a Lost Book fine
        $fine_name_q = $conn->prepare("SELECT fine_name FROM fines_table WHERE fine_id = ?");
        $fine_name_q->bind_param("i", $fine_id);
        $fine_name_q->execute();
        $fine_name_result = $fine_name_q->get_result();

        $is_lost_book = false;
        if ($fine_name_result && $fine_name_result->num_rows > 0) {
            $fine_row = $fine_name_result->fetch_assoc();
            $is_lost_book = ($fine_id == 4);
        }
        $fine_name_q->close();

        if ($is_lost_book) {
            $lost_book = 'lost_fine';

            // Include the total fine amount in the lost book notification message
            $lost_notif_message = "You have been issued a LOST BOOK fine of ₱$total_fine. Please contact the library immediately.";

            $lost_notif_stmt = $conn->prepare("INSERT INTO tbl_user_notifications (student_no, book_id, type, message, created_at) VALUES (?, ?, ?, ?, NOW())");
            $lost_notif_stmt->bind_param("ssss", $student_no, $book_id, $lost_book, $lost_notif_message);
            $lost_notif_stmt->execute();
            $lost_notif_stmt->close();
            $book_title_q = $conn->prepare("SELECT book_title FROM tbl_books WHERE book_id = ?");
            $book_title_q->bind_param("s", $book_id);
            $book_title_q->execute();
            $book_title_result = $book_title_q->get_result();
            $book_title = '';

            if ($book_title_result && $book_title_result->num_rows > 0) {
                $book_row = $book_title_result->fetch_assoc();
                $book_title = $book_row['book_title'];
            }
            $book_title_q->close();

            $date_reported = date('Y-m-d');
            $lost_stmt = $conn->prepare("INSERT INTO lost_books (book_id, student_no, borrow_id, book_title, date_reported, fine_amount) VALUES (?, ?, ?, ?, ?, ?)");
            $lost_stmt->bind_param("ssissd", $book_id, $student_no, $borrow_id, $book_title, $date_reported, $total_fine);
            $lost_stmt->execute();
            $lost_stmt->close();


            $update = $conn->prepare("UPDATE borrowed_books SET status = 'Lost' WHERE borrow_id = ?");
        } else {
            // Not a lost book — set to Returned
            $update = $conn->prepare("UPDATE borrowed_books SET status = 'Returned' WHERE borrow_id = ?");
        }
        $update->bind_param("s", $borrow_id);

        if ($update->execute()) {
            // Step 4: Get book details
            $book_q = $conn->prepare("SELECT book_title, book_author, book_cover FROM tbl_books WHERE book_id = ?");
            $book_q->bind_param("s", $book_id);
            $book_q->execute();
            $book_result = $book_q->get_result();

            if ($book_result && $book_result->num_rows > 0) {
                $book = $book_result->fetch_assoc();
                $repair_status = 'Under Repair';
                $date_reported = date('Y-m-d');

                // Step 5: Insert into under_repair_books
                $repair_stmt = $conn->prepare("INSERT INTO under_repair_books (book_id, book_cover, book_title, book_author, damage_description, date_reported, reported_by, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $repair_stmt->bind_param("ssssssss", $book_id, $book['book_cover'], $book['book_title'], $book['book_author'], $damage_description, $date_reported, $loggedInUser, $repair_status);

                if ($repair_stmt->execute()) {
                    echo json_encode(["success" => true, "message" => "Fine issued and book processed successfully."]);
                } else {
                    echo json_encode(["success" => false, "message" => "Failed to add to repair list: " . $conn->error]);
                }

                $repair_stmt->close();
            }

            $book_q->close();
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update book status: " . $conn->error]);
        }

        $update->close();
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
