<?php
date_default_timezone_set('Asia/Manila'); // or your actual timezone
session_start();
include '../Homepage/db_connect.php';

$student_no = $_SESSION['student_no'] ?? null;

if (!$student_no) {
    echo "<p class='notification-error'>Unauthorized access.</p>";
    exit;
}

// Fetch approved borrowed books
$approved_sql = "
    SELECT bb.*, b.book_cover, b.book_title, bb.update_datetime
    FROM borrowed_books bb
    JOIN tbl_books b ON bb.book_id = b.book_id
    WHERE bb.student_no = ? AND bb.status = 'Approved'
    ORDER BY bb.update_datetime DESC
";
$approved_stmt = $conn->prepare($approved_sql);
$approved_stmt->bind_param("s", $student_no);
$approved_stmt->execute();
$approved_result = $approved_stmt->get_result();

// Fetch rejected requests
$rejected_sql = "
    SELECT rr.*, b.book_cover, b.book_title, rr.update_datetime
    FROM rejected_requests rr
    JOIN tbl_books b ON rr.book_id = b.book_id
    WHERE rr.student_no = ?
    ORDER BY rr.update_datetime DESC
";
$rejected_stmt = $conn->prepare($rejected_sql);
$rejected_stmt->bind_param("s", $student_no);
$rejected_stmt->execute();
$rejected_result = $rejected_stmt->get_result();
?>

<div class="notification-scroll">
    <h4>Notifications</h4>
    <br>

    <?php
    function time_ago($datetime)
    {
        $timestamp = strtotime($datetime);
        $diff = time() - $timestamp;

        if ($diff < 60)
            return 'Just now';
        elseif ($diff < 3600)
            return floor($diff / 60) . ' minutes ago';
        elseif ($diff < 86400)
            return floor($diff / 3600) . ' hours ago';
        elseif ($diff < 604800)
            return floor($diff / 86400) . ' days ago';
        elseif ($diff < 2629440)
            return floor($diff / 604800) . ' weeks ago';
        elseif ($diff < 31553280)
            return floor($diff / 2629440) . ' months ago';
        else
            return floor($diff / 31553280) . ' years ago';
    }

    ?>

    <?php while ($row = $approved_result->fetch_assoc()): ?>
        <div class="notification-item approved">
            <img src="<?= htmlspecialchars($row['book_cover']) ?>" class="notif-cover" />
            <div>
                <strong style="color:green;"> Approved </strong>
                <br><br>
                <div class="notif-title"><strong><?= htmlspecialchars($row['book_title']) ?></strong></div>
                <small> ✅ Ready for Pickup</small>
                <br><br>
                <small
                    class="view-more"
                    style="color: blue; cursor: pointer;"
                    data-title="<?= htmlspecialchars($row['book_title']) ?>"
                    data-status="<?= htmlspecialchars($row['status']) ?>"
                    data-contact="<?= htmlspecialchars($row['contact']) ?>"
                    data-date="<?= htmlspecialchars($row['preferred_date']) ?>"
                    data-updated="<?= htmlspecialchars($row['update_datetime']) ?>">
                    View More
                </small>

                <br>
                <small style="color: gray;"><?= time_ago($row['update_datetime']) ?></small>

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
                <small>Note: "<?= htmlspecialchars($row['reason']) ?>"</small>
                <br>
                <a href="BOOK-DETAILS.php?book_id=<?= urlencode($row['book_id']) ?>" class="resubmit-btn">Resubmit</a> <Br>
                <small style="color: gray;"><?= time_ago($row['update_datetime']) ?></small>
            </div>
        </div>
    <?php endwhile; ?>

</div>