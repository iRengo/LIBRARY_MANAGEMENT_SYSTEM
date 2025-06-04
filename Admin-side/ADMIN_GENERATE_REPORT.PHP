<?php
require_once __DIR__ . '/../dompdf/vendor/autoload.php';
require '../Homepage/db_connect.php'; 

use Dompdf\Dompdf;
use Dompdf\Options;

$reportType = $_POST['report_type'] ?? 'ALL';

$html = "<h2 style='text-align: center;'>Library Report</h2>";
$html .= "<p style='text-align: center;'>Date Generated: " . date("F j, Y") . "</p>";

// RESERVED BOOKS
if ($reportType === 'RESERVATION' || $reportType === 'ALL') {
    $html .= "<h3>Reserved Books</h3>";
    $html .= "<table border='1' cellspacing='0' cellpadding='5' width='100%'>
    <thead><tr>
        <th>Reserve ID</th><th>Student No</th><th>Email</th><th>Book Title</th><th>Reserve Date</th>
    </tr></thead><tbody>";
    
    $sql = "SELECT reserve_id, student_no, email, book_title, reserve_date FROM reserved_books";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "<tr>
            <td>{$row['reserve_id']}</td>
            <td>{$row['student_no']}</td>
            <td>{$row['email']}</td>
            <td>{$row['book_title']}</td>
            <td>{$row['reserve_date']}</td>
        </tr>";
    }
    $html .= "</tbody></table><br><br>";
}

// BORROWED BOOKS
if ($reportType === 'BORROWED' || $reportType === 'ALL') {
    $html .= "<h3>Borrowed Books</h3>";
    $html .= "<table border='1' cellspacing='0' cellpadding='5' width='100%'>
    <thead><tr>
        <th>Borrow ID</th><th>Student No</th><th>Email</th><th>Book Title</th>
        <th>Borrow Date</th><th>Due Date</th><th>Status</th>
    </tr></thead><tbody>";

    $sql = "SELECT borrow_id, student_no, email, book_title, preferred_date, due_date, status FROM borrowed_books";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "<tr>
            <td>{$row['borrow_id']}</td>
            <td>{$row['student_no']}</td>
            <td>{$row['email']}</td>
            <td>{$row['book_title']}</td>
            <td>{$row['preferred_date']}</td>
            <td>{$row['due_date']}</td>
            <td>{$row['status']}</td>
        </tr>";
    }
    $html .= "</tbody></table><br><br>";
}

// STUDENT FINES
if ($reportType === 'FINES' || $reportType === 'ALL') {
    $html .= "<h3>Student Fines</h3>";
    $html .= "<table border='1' cellspacing='0' cellpadding='5' width='100%'>
    <thead><tr>
        <th>Student No</th><th>Book Title</th><th>Author</th>
        <th>Fine Name</th><th>Amount</th><th>Status</th>
    </tr></thead><tbody>";

    $sql = "SELECT 
                sf.student_no, b.book_title, b.book_author,
                f.fine_name, f.price AS fine_amount, sf.status
            FROM student_fines sf
            LEFT JOIN tbl_books b ON sf.book_id = b.book_id
            LEFT JOIN fines_table f ON sf.fine_id = f.fine_id
            WHERE sf.status = 'unpaid'
            ORDER BY sf.fine_id DESC";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "<tr>
            <td>{$row['student_no']}</td>
            <td>{$row['book_title']}</td>
            <td>{$row['book_author']}</td>
            <td>{$row['fine_name']}</td>
            <td>" . number_format($row['fine_amount'], 2) . "</td>
            <td>{$row['status']}</td>
        </tr>";
    }
    $html .= "</tbody></table><br><br>";
}

// Render the PDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Stream the PDF
$dompdf->stream("library_report.pdf", ["Attachment" => false]);
exit;