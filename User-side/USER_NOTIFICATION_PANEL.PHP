<?php
date_default_timezone_set('Asia/Manila');
session_start();
include '../Homepage/db_connect.php';

$student_no = $_SESSION['student_no'] ?? null;
if (!$student_no) {
    echo "<p class='notification-error'>Unauthorized access.</p>";
    exit;
}

$sql = "
   SELECT n.*, b.book_cover, b.book_title,
       f.fine_name,
       f.price,
       sf.proof
FROM tbl_user_notifications n
LEFT JOIN tbl_books b ON n.book_id = b.book_id
LEFT JOIN student_fines sf ON n.book_id = sf.book_id AND n.student_no = sf.student_no
LEFT JOIN fines_table f ON sf.fine_id = f.fine_id
WHERE n.student_no = ?
GROUP BY n.notif_id
ORDER BY n.created_at DESC
";



$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_no);
$stmt->execute();
$result = $stmt->get_result();

function time_ago($datetime)
{
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;

    if ($diff < 60) return 'Just now';
    elseif ($diff < 3600) return floor($diff / 60) . ' minutes ago';
    elseif ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    elseif ($diff < 604800) return floor($diff / 86400) . ' days ago';
    elseif ($diff < 2629440) return floor($diff / 604800) . ' weeks ago';
    elseif ($diff < 31553280) return floor($diff / 2629440) . ' months ago';
    else return floor($diff / 31553280) . ' years ago';
}

// Get total and unread notifications
$notif_query = $conn->prepare("SELECT 
    COUNT(*) as total, 
    SUM(CASE WHEN is_read = 0 THEN 1 ELSE 0 END) as unread 
    FROM tbl_user_notifications 
    WHERE student_no = ?");
$notif_query->bind_param("s", $student_no);
$notif_query->execute();
$notif_result = $notif_query->get_result()->fetch_assoc();

$total = $notif_result['total'];
$unread = $notif_result['unread'];
?>

<div class="notification-scroll">
    
    <h4>Notifications</h4><br>

    <div style="font-size: 12px; margin-bottom: 10px; color: #555;">
        <strong>Total Notifications:</strong> <?= $total ?> &nbsp;|&nbsp; 
        <strong>Unread:</strong> <?= $unread ?>
    </div>

    <?php while ($row = $result->fetch_assoc()): ?>
        <?php
        // Determine classes
        $statusClass = 'other-type';
        if ($row['type'] === 'approved') $statusClass = 'approved';
        else if ($row['type'] === 'rejected') $statusClass = 'rejected';
        else if ($row['type'] === 'due_today') $statusClass = 'due-today';
        else if ($row['type'] === 'overdue') $statusClass = 'overdue';
        else if ($row['type'] === 'pending_fine') $statusClass = 'pending-fine';

        $readClass = $row['is_read'] ? 'read' : 'unread';
        ?>

        
        <div
            class="notification-item <?= $statusClass . ' ' . $readClass ?>"
            style="cursor:pointer;"
            
            data-notif-id="<?= $row['notif_id'] ?>"
            data-book-title="<?= htmlspecialchars($row['book_title']) ?>"
            data-message="<?= htmlspecialchars($row['message']) ?>"
            data-created-at="<?= htmlspecialchars($row['created_at']) ?>"
            data-book-id="<?= htmlspecialchars($row['book_id']) ?>"
            data-type="<?= htmlspecialchars($row['type']) ?>"
            data-book-cover="<?= !empty($row['book_cover']) ? htmlspecialchars($row['book_cover']) : '' ?>"
            data-due-date="<?= !empty($row['due_date']) ? htmlspecialchars($row['due_date']) : 'N/A' ?>"
            data-proof="<?= !empty($row['proof']) ? '../public/proofs/' . htmlspecialchars($row['proof']) : '' ?>"
            data-fine-id="<?= !empty($row['fine_id']) ? htmlspecialchars($row['fine_id']) : '' ?>"
            data-fine-price="<?= !empty($row['price']) ? htmlspecialchars($row['price']) : '' ?>"
            data-fine-name="<?= !empty($row['fine_name']) ? htmlspecialchars($row['fine_name']) : '' ?>">
            
            <?php if (!empty($row['book_cover'])): ?>
                <img src="<?= htmlspecialchars($row['book_cover']) ?>" class="notif-cover" />
            <?php endif; ?>
            

            <div class="notif-text">
                <?php
                $typeClass = 'status-other';
                if ($row['type'] === 'approved') $typeClass = 'status-approved';
                else if ($row['type'] === 'rejected') $typeClass = 'status-rejected';
                else if ($row['type'] === 'due_today') $typeClass = 'status-due';
                else if ($row['type'] === 'overdue') $typeClass = 'status-overdue';
                else if ($row['type'] === 'fine_issued') $typeClass = 'status-fine_issued';
                else if ($row['type'] === 'pending_fine') $typeClass = 'status-pending-fine';
                ?>
                <div class="notif-status <?= $typeClass ?>">
                    <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $row['type']))) ?>
                </div>
                <div class="notif-title"><?= htmlspecialchars($row['book_title']) ?></div>
                <div class="notif-message"><?= htmlspecialchars($row['message']) ?></div>
                <br>
                <small class="notif-time"><?= time_ago($row['created_at']) ?></small>
            </div>
            
        </div>
    <?php endwhile; ?>
</div>
