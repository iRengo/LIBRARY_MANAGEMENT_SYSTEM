<?php
session_start();
include '../homepage/db_connect.php';
require_once __DIR__ . '/../dompdf/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Fetch summary data (without date filters)
function getCount($conn, $query) {
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] ?? 0;
}

$borrowedCount = getCount($conn, "SELECT COUNT(*) AS count FROM borrowed_books WHERE status = 'Borrowed'");
$reservedCount = getCount($conn, "SELECT COUNT(*) AS count FROM reserved_books");
$returnedCount = getCount($conn, "SELECT COUNT(*) AS count FROM returned_books");
$finesIssuedCount = getCount($conn, "SELECT COUNT(*) AS count FROM student_fines");

$sql_total_fines = "
    SELECT 
        IFNULL(SUM(f.price), 0) AS total_fines,
        IFNULL(SUM(sf.overdue_amount), 0) AS total_overdue
    FROM student_fines sf
    LEFT JOIN fines_table f ON sf.fine_id = f.fine_id
    WHERE sf.status = 'Paid'
";

$result = mysqli_query($conn, $sql_total_fines);
$row = mysqli_fetch_assoc($result);

$totalFines = number_format($row['total_fines'], 2);
$totalOverdue = number_format($row['total_overdue'], 2);

// Optionally, total combined amount
$totalCombined = number_format($row['total_fines'] + $row['total_overdue'], 2);


// HTML content
$html = "<h2 style='text-align:center;'>Librarian Summary Report</h2>";
$html .= "<p style='text-align:center;'>Date Generated: " . date("F j, Y") . "</p>";

$html .= "<table border='1' cellspacing='0' cellpadding='5' width='100%' style='margin-top:10px;'>
    <thead>
        <tr>
            <th>Category</th>
            <th>Count / Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>Borrowed Books</td><td>{$borrowedCount}</td></tr>
        <tr><td>Reserved Books</td><td>{$reservedCount}</td></tr>
        <tr><td>Returned Books</td><td>{$returnedCount}</td></tr>
        <tr><td>Fines Issued</td><td>{$finesIssuedCount}</td></tr>
        <tr><td>Total Fines</td><td>{$totalCombined}</td></tr>
    </tbody>
</table>";

// Generate PDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("librarian_summary_report.pdf", ["Attachment" => false]);
exit;
?>
