<?php
session_start();
include '../Homepage/db_connect.php';

$student_no = $_SESSION['student_no'] ?? null;

if (!$student_no) {
    echo "<p class='notification-error'>Unauthorized access.</p>";
    exit;
}

// Fetch approved borrowed books
$approved_sql = "
    SELECT bb.*, b.book_cover, b.book_title 
    FROM borrowed_books bb
    JOIN tbl_books b ON bb.book_id = b.book_id
    WHERE bb.student_no = ? AND bb.status = 'Approved'
    ORDER BY bb.borrow_id DESC
";
$approved_stmt = $conn->prepare($approved_sql);
$approved_stmt->bind_param("s", $student_no);
$approved_stmt->execute();
$approved_result = $approved_stmt->get_result();

// Fetch rejected requests
$rejected_sql = "
    SELECT rr.*, b.book_cover, b.book_title 
    FROM rejected_requests rr
    JOIN tbl_books b ON rr.book_id = b.book_id
    WHERE rr.student_no = ?
    ORDER BY rr.borrow_id DESC
";
$rejected_stmt = $conn->prepare($rejected_sql);
$rejected_stmt->bind_param("s", $student_no);
$rejected_stmt->execute();
$rejected_result = $rejected_stmt->get_result();
?>

<div class="notification-scroll">
    <h4>Notifications</h4>

    <?php while ($row = $approved_result->fetch_assoc()): ?>
    <div class="notification-item approved">
        <img src="<?= htmlspecialchars($row['book_cover']) ?>" class="notif-cover" />
        <div>
            <strong style="color:green;"> Approved </strong>
            <br> <br>
            <div class="notif-title"><strong><?= htmlspecialchars($row['book_title']) ?></strong></div>
            <small><?= date('M d, Y H:i', strtotime($row['due_date'] ?? 'now')) ?></small>
        </div>
    </div>
    <?php endwhile; ?>

    <?php while ($row = $rejected_result->fetch_assoc()): ?>
    <div class="notification-item rejected">
        <img src="<?= htmlspecialchars($row['book_cover']) ?>" class="notif-cover" />
        <div>
            <strong style="color: red;"> Rejected </strong>
            <br> <br>
            <div class="notif-title"><strong><?= htmlspecialchars($row['book_title']) ?></strong></div>
            <small>Librarian: "<?= htmlspecialchars($row['reason']) ?>"</small>
        </div>
    </div>
    <?php endwhile; ?>
</div>
