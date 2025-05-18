<?php
session_start();
include '../homepage/db_connect.php';

require_once __DIR__ . '/../dompdf/vendor/autoload.php';


use Dompdf\Dompdf;

$monthFilter = $_POST['month_filter'] ?? 'this_month';
$selectedStudent = $_POST['student_no'] ?? null;

// Determine date range
if ($monthFilter === 'previous_month') {
    $startDate = date("Y-m-01", strtotime("first day of previous month"));
    $endDate = date("Y-m-t", strtotime("last day of previous month"));
    $monthName = date("F", strtotime("first day of previous month"));
} else {
    $startDate = date("Y-m-01");
    $endDate = date("Y-m-t");
    $monthName = date("F");
}

// Fetch summary data with date filters
$sql_borrowed = "SELECT COUNT(*) AS count FROM borrowed_books WHERE status = 'Borrowed' AND preferred_date BETWEEN '$startDate' AND '$endDate'";
$result = mysqli_query($conn, $sql_borrowed);
$row = mysqli_fetch_assoc($result);
$borrowedCount = $row['count'];

$sql_reserved = "SELECT COUNT(*) AS count FROM reserved_books WHERE reserved_date BETWEEN '$startDate' AND '$endDate'";
$result = mysqli_query($conn, $sql_reserved);
$row = mysqli_fetch_assoc($result);
$reservedCount = $row['count'];

$sql_returned = "SELECT COUNT(*) AS count FROM returned_books WHERE return_date BETWEEN '$startDate' AND '$endDate'";
$result = mysqli_query($conn, $sql_returned);
$row = mysqli_fetch_assoc($result);
$returnedCount = $row['count'];

$sql_fines_count = "SELECT COUNT(*) AS count FROM student_fines WHERE date_issued BETWEEN '$startDate' AND '$endDate'";
$result = mysqli_query($conn, $sql_fines_count);
$row = mysqli_fetch_assoc($result);
$finesIssuedCount = $row['count'];

$sql_total_fines = "SELECT IFNULL(SUM(f.price), 0) AS total FROM student_fines sf LEFT JOIN fines_table f ON sf.fine_id = f.fine_id WHERE sf.date_issued BETWEEN '$startDate' AND '$endDate'";
$result = mysqli_query($conn, $sql_total_fines);
$row = mysqli_fetch_assoc($result);
$totalFines = number_format($row['total'], 2);


// Generate HTML for PDF
$css = file_get_contents('LIBRARIAN_GENERATE_REPORTS.CSS');

$html = "
    <style>{$css}</style>

    <h1>Librarian Report Summary for {$monthName}</h1>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Count/Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Borrowed Books</td><td>{$borrowedCount}</td></tr>
            <tr><td>Reserved Books</td><td>{$reservedCount}</td></tr>
            <tr><td>Returned Books</td><td>{$returnedCount}</td></tr>
            <tr><td>Fines Issued</td><td>{$finesIssuedCount}</td></tr>
            <tr><td>Total Fines</td><td>₱ {$totalFines}</td></tr>
        </tbody>
    </table>
";


$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Set paper size and orientation
$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

// Output the PDF to browser and force download
$dompdf->stream("librarian_report_summary_{$monthName}.pdf", ["Attachment" => true]);
exit;
