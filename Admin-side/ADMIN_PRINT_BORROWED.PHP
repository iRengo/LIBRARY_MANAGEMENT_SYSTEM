<?php
require_once __DIR__ . '/../dompdf/vendor/autoload.php';
require '../Homepage/db_connect.php'; 

use Dompdf\Dompdf;
use Dompdf\Options;

$html = "<h2 style='text-align:center;'>Circulation Books Report</h2>";
$html .= "<p style='text-align:center;'>Date Generated: " . date("F j, Y") . "</p>";

$html .= "<table border='1' cellspacing='0' cellpadding='5' width='100%'>
    <thead>
        <tr>
            <th>BOOK TITLE</th>
            <th>USERNAME</th>
            <th>BORROWED DATE</th>
            <th>DUE DATE</th>
            <th>STATUS</th>
            <th>LAST UPDATED</th>
        </tr>
    </thead><tbody>";

$sql = "SELECT * FROM borrowed_books";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $username = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
    $html .= "<tr>
        <td>" . htmlspecialchars($row['book_title']) . "</td>
        <td>{$username}</td>
        <td>" . htmlspecialchars($row['preferred_date']) . "</td>
        <td>" . htmlspecialchars($row['due_date']) . "</td>
        <td>" . htmlspecialchars($row['status']) . "</td>
        <td>" . htmlspecialchars($row['update_datetime']) . "</td>
    </tr>";
}

$html .= "</tbody></table>";

// Generate PDF with Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Output the PDF to browser
$dompdf->stream("borrowed_books_report.pdf", ["Attachment" => false]);
exit;
?>