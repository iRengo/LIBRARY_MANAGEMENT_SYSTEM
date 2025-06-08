<?php
include '../homepage/db_connect.php'; 

$query = "SELECT * FROM lost_books ORDER BY date_reported DESC";
$result = mysqli_query($conn, $query);

$output = '
<div style="overflow-x:auto;">
    <table class="table table-bordered" style="width:100%; text-align:left;">
        <thead>
            <tr>
                <th>Book Title</th>
                <th>Student No</th>
                <th>Date Reported</th>
                <th>Fine Amount (₱)</th>
            </tr>
        </thead>
        <tbody>
';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '
        <tr>
            <td>' . htmlspecialchars($row['book_title']) . '</td>
            <td>' . htmlspecialchars($row['student_no']) . '</td>
            <td>' . htmlspecialchars($row['date_reported']) . '</td>
            <td>' . number_format($row['fine_amount'], 2) . '</td>
        </tr>';
    }
} else {
    $output .= '<tr><td colspan="4">No lost books found.</td></tr>';
}

$output .= '
        </tbody>
    </table>
</div>
';

echo $output;
?>
