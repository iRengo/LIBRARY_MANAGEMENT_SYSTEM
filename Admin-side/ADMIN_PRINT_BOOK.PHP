<?php
require_once __DIR__ . '/../dompdf/vendor/autoload.php';
require '../Homepage/db_connect.php'; 

use Dompdf\Dompdf;
use Dompdf\Options;


$sql = "SELECT ISBN, book_title, book_author, book_stocks, book_category, publisher
        FROM tbl_books";
$result = mysqli_query($conn, $sql);

$html = "<h2 style='text-align: center;'>Library Inventory Report</h2>";
$html .= "<p style='text-align: center;'>Total books as of " . date('F Y') . "</p>";
$html .= "<table border='1' cellpadding ='5' cellspacing='0' width='100%'>
            <thead>
                <tr>
                    <th>ISBN</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Stock</th>  
                    <th>Genre</th>
                    <th>Publisher</th>
                </tr>
            </thead>
            <tbody>";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "<tr>
                    <td>{$row['ISBN']}</td>
                    <td>{$row['book_title']}</td>
                    <td>{$row['book_author']}</td>
                    <td>{$row['book_stocks']}</td>
                    <td>{$row['book_category']}</td>
                    <td>{$row['publisher']}</td>
                  </tr>";
    }
} else {
    $html .= "<tr><td colspan='6' style='text-align: center;'>No books added this month.</td></tr>";
}

$html .= "</tbody></table>";

// Generate PDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("library_inventory_report.pdf", ["Attachment" => false]);
exit;
