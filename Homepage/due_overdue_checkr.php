<?php
date_default_timezone_set('Asia/Manila');
include '../Homepage/db_connect.php';

$student_no = $_SESSION['student_no'] ?? null;
if (!$student_no) {
    return; // no student logged in
}

$today = date('Y-m-d');

// Function to check if notification already exists
function notification_exists($conn, $student_no, $book_id, $type) {
    $sql = "SELECT 1 FROM tbl_user_notifications WHERE student_no = ? AND book_id = ? AND type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $student_no, $book_id, $type);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

// Function to insert notification
function insert_notification($conn, $student_no, $book_id, $type, $message) {
    $sql = "INSERT INTO tbl_user_notifications (student_no, book_id, type, message, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $student_no, $book_id, $type, $message);
    $stmt->execute();
    $stmt->close();
}

// Check overdue books
$overdue_sql = "
    SELECT bb.book_id, b.book_title, b.book_cover, DATEDIFF(CURRENT_DATE, bb.due_date) AS days_overdue
    FROM borrowed_books bb
    JOIN tbl_books b ON bb.book_id = b.book_id
    WHERE bb.student_no = ?
    AND bb.status = 'Borrowed'
    AND DATEDIFF(CURRENT_DATE, bb.due_date) > 0
    ORDER BY bb.due_date ASC
";
$overdue_stmt = $conn->prepare($overdue_sql);
$overdue_stmt->bind_param("s", $student_no);
$overdue_stmt->execute();
$overdue_result = $overdue_stmt->get_result();

while ($row = $overdue_result->fetch_assoc()) {
    $book_id = $row['book_id'];
    $type = 'overdue';
    $message = "Your borrowed book '{$row['book_title']}' is overdue by {$row['days_overdue']} day" . ($row['days_overdue'] > 1 ? 's' : '') . ".";

    if (!notification_exists($conn, $student_no, $book_id, $type)) {
        insert_notification($conn, $student_no, $book_id, $type, $message);
    }
}

// Check books due today
$due_sql = "
    SELECT bb.book_id, b.book_title, b.book_cover
    FROM borrowed_books bb
    JOIN tbl_books b ON bb.book_id = b.book_id
    WHERE bb.student_no = ?
    AND bb.status = 'Borrowed'
    AND bb.due_date = ?
    ORDER BY bb.due_date ASC
";
$due_stmt = $conn->prepare($due_sql);
$due_stmt->bind_param("ss", $student_no, $today);
$due_stmt->execute();
$due_result = $due_stmt->get_result();

while ($row = $due_result->fetch_assoc()) {
    $book_id = $row['book_id'];
    $type = 'due';
    $message = "Your borrowed book '{$row['book_title']}' is due today.";

    if (!notification_exists($conn, $student_no, $book_id, $type)) {
        insert_notification($conn, $student_no, $book_id, $type, $message);
    }
}
?>
