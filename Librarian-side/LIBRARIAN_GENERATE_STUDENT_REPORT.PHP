<?php
require_once __DIR__ . '/../dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

session_start();
include '../homepage/db_connect.php';

if (!isset($_POST['student_no'])) {
    echo "No student selected.";
    exit;
}

$selectedStudent = $_POST['student_no'];

$student_info_sql = "SELECT first_name, last_name, email FROM tbl_students WHERE student_number = '$selectedStudent' LIMIT 1";
$student_info_result = mysqli_query($conn, $student_info_sql);
$student_info = mysqli_fetch_assoc($student_info_result);

// Start output buffering
ob_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Report - <?= htmlspecialchars($selectedStudent) ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2, h3 { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 12px; }
        .section { margin-top: 20px; }
        .header { text-align: center; }
    </style>
</head>
<body>

<div class="header">
    <h2>Student Library Activity Report</h2>
    <p><strong>Student Number:</strong> <?= htmlspecialchars($selectedStudent) ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($student_info['first_name'] ?? 'N/A') ?> <?= htmlspecialchars($student_info['last_name'] ?? '') ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($student_info['email'] ?? 'N/A') ?></p>
</div>

<div class="section">
    <h3>Borrowed Books</h3>
    <table>
        <thead>
            <tr>
                <th>Book Title</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Date Borrowed</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $borrowed_sql = "
                SELECT b.book_title, bb.status, bb.due_date, bb.preferred_date
                FROM borrowed_books bb
                LEFT JOIN tbl_books b ON bb.book_id = b.book_id
                WHERE bb.student_no = '$selectedStudent'
                ORDER BY bb.preferred_date DESC
            ";
            $borrowed_result = mysqli_query($conn, $borrowed_sql);
            if (mysqli_num_rows($borrowed_result) > 0) {
                while ($row = mysqli_fetch_assoc($borrowed_result)) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['book_title']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                        <td>" . htmlspecialchars($row['due_date']) . "</td>
                        <td>" . htmlspecialchars($row['preferred_date']) . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No borrowed books found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div class="section">
    <h3>Returned Books</h3>
    <table>
        <thead>
            <tr>
                <th>Book Title</th>
                <th>Date Borrowed</th>
                <th>Date Returned</th>
                <th>Condition</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $returned_sql = "
                SELECT rb.book_title, bb.preferred_date AS date_borrowed, rb.return_date, rb.book_condition
                FROM returned_books rb
                LEFT JOIN borrowed_books bb ON rb.borrow_id = bb.borrow_id
                WHERE rb.student_no = '$selectedStudent'
                ORDER BY rb.return_date DESC
            ";
            $returned_result = mysqli_query($conn, $returned_sql);
            if (mysqli_num_rows($returned_result) > 0) {
                while ($row = mysqli_fetch_assoc($returned_result)) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['book_title']) . "</td>
                        <td>" . htmlspecialchars($row['date_borrowed']) . "</td>
                        <td>" . htmlspecialchars($row['return_date']) . "</td>
                        <td>" . htmlspecialchars($row['book_condition']) . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No returned books found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div class="section">
    <h3>Reserved Books</h3>
    <table>
        <thead>
            <tr>
                <th>Book Title</th>
                <th>Date Reserved</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $reserved_sql = "
                SELECT b.book_title, r.reserve_date
                FROM reserved_books r
                LEFT JOIN tbl_books b ON r.book_id = b.book_id
                WHERE r.student_no = '$selectedStudent'
                ORDER BY r.reserve_date DESC
            ";
            $reserved_result = mysqli_query($conn, $reserved_sql);
            if (mysqli_num_rows($reserved_result) > 0) {
                while ($row = mysqli_fetch_assoc($reserved_result)) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['book_title']) . "</td>
                        <td>" . htmlspecialchars($row['reserve_date']) . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No reserved books found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div class="section">
    <h3>Fines Issued</h3>
    <table>
        <thead>
            <tr>
                <th>Fine Type</th>
                <th>Fine Amount</th>
                <th>Overdue Amount</th>
                <th>Total</th>
                <th>Date Issued</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalFineAmount = 0;
            $totalOverdueAmount = 0;
            $totalOverall = 0;

            $fines_sql = "
                SELECT f.fine_name, f.price, sf.overdue_amount, sf.date_issued, sf.status
                FROM student_fines sf
                LEFT JOIN fines_table f ON sf.fine_id = f.fine_id
                WHERE sf.student_no = '$selectedStudent'
                ORDER BY sf.date_issued DESC
            ";
            $fines_result = mysqli_query($conn, $fines_sql);

            if (mysqli_num_rows($fines_result) > 0) {
                while ($row = mysqli_fetch_assoc($fines_result)) {
                    $fineAmount = (float)$row['price'];
                    $overdueAmount = (float)$row['overdue_amount'];
                    $rowTotal = $fineAmount + $overdueAmount;

                    $totalFineAmount += $fineAmount;
                    $totalOverdueAmount += $overdueAmount;
                    $totalOverall += $rowTotal;

                    echo "<tr>
                        <td>" . htmlspecialchars($row['fine_name']) . "</td>
                        <td>₱" . number_format($fineAmount, 2) . "</td>
                        <td>₱" . number_format($overdueAmount, 2) . "</td>
                        <td>₱" . number_format($rowTotal, 2) . "</td>
                        <td>" . htmlspecialchars($row['date_issued']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                    </tr>";
                }
                // Total row
                echo "<tr style='font-weight:bold; background:#f0f0f0;'>
                    <td>Total</td>
                    <td>₱" . number_format($totalFineAmount, 2) . "</td>
                    <td>₱" . number_format($totalOverdueAmount, 2) . "</td>
                    <td>₱" . number_format($totalOverall, 2) . "</td>
                    <td colspan='2'></td>
                </tr>";
            } else {
                echo "<tr><td colspan='6'>No fines found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


</body>
</html>

<?php
$html = ob_get_clean();

// Setup Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Stream the PDF to browser (force download or view)
$filename = "Student_Report_" . $selectedStudent . ".pdf";
$dompdf->stream($filename, ["Attachment" => 0]); // 0 for inline view, 1 for force download
