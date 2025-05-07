<?php
session_start();
include '../Homepage/db_connect.php';

$student_no = $_SESSION['student_no'] ?? null;

if (!$student_no) {
    die("Unauthorized access.");
}

// Fetch rejected notifications
$rejected_sql = "SELECT * FROM rejected_requests WHERE student_no = ? ORDER BY borrow_id DESC";
$rejected_stmt = $conn->prepare($rejected_sql);
$rejected_stmt->bind_param("s", $student_no);
$rejected_stmt->execute();
$rejected_result = $rejected_stmt->get_result();

// Fetch approved notifications (assuming from a general borrow_requests table)
$approved_sql = "SELECT * FROM borrowed_books WHERE student_no = ? AND status = 'approved' ORDER BY borrow_id DESC";
$approved_stmt = $conn->prepare($approved_sql);
$approved_stmt->bind_param("s", $student_no);
$approved_stmt->execute();
$approved_result = $approved_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title> USER_NOTIFICATION </title>
    <link rel="stylesheet" href="USER_NOTIFICATION.css">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP' ?>

    <!-- Notifications Section -->
    <div class="notifications-section">
        <h3>Your Notifications</h3>
        <p class="text-muted">Manage, renew and review your books</p>

        <!-- Approved Notifications -->
        <?php while ($row = $approved_result->fetch_assoc()): ?>
            <div class="notification-box green clearfix">
                <div class="avatar">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/user.png" alt="user">
                </div>
                <div class="notification-time text-success">
                    <strong><?= date('M d, Y H:i', strtotime($row['updated_at'] ?? 'now')) ?></strong>
                </div>
                <div class="notification-content">
                    <span class="status">Approved</span>
                    <div>Your request to borrow <strong><?= htmlspecialchars($row['book_title']) ?></strong> has been approved.</div>
                </div>
            </div>
        <?php endwhile; ?>

        <!-- Rejected Notifications -->
        <?php while ($row = $rejected_result->fetch_assoc()): ?>
            <div class="notification-box red clearfix">
                <div class="avatar">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/user.png" alt="user">
                </div>
                <div class="notification-time text-danger">
                    <strong><?= date('M d, Y H:i', strtotime($row['created_at'] ?? 'now')) ?></strong>
                </div>
                <div class="notification-content">
                    <span class="status">Rejected</span>
                    <div>Your request to borrow <strong><?= htmlspecialchars($row['book_title']) ?></strong> was rejected.</div>
                    <br>
                    <div><em>Reason: <?= htmlspecialchars($row['reason']) ?></em></div>
                </div>
            </div>
        <?php endwhile; ?>

        <!-- View All -->
        <div class="view-all">
            <a href="#">View All</a>
        </div>
    </div>
    </div>

</body>

</html>