<?php
session_start();
include '../homepage/db_connect.php';

$loggedInUser = $_SESSION['librarian_no'];


$rejected_sql = "
    SELECT * FROM rejected_requests 
    WHERE updated_by = '$loggedInUser' 
    ORDER BY update_datetime DESC
";

$rejected_result = mysqli_query($conn, $rejected_sql);


$approved_sql = "
    SELECT bb.*, b.book_title 
    FROM borrowed_books bb
    LEFT JOIN tbl_books b ON bb.book_id = b.book_id
    WHERE bb.status = 'Approved' AND bb.updated_by = '$loggedInUser'
    ORDER BY bb.update_datetime DESC
";
$approved_result = mysqli_query($conn, $approved_sql);



$fines_sql = "
    SELECT sf.student_no, sf.book_id, sf.fine_id, sf.date_issued, sf.status, 
           b.book_title, f.fine_name, f.price
    FROM student_fines sf
    LEFT JOIN tbl_books b ON sf.book_id = b.book_id
    LEFT JOIN fines_table f ON sf.fine_id = f.fine_id
    WHERE sf.updated_by = '$loggedInUser'
    ORDER BY sf.date_issued DESC
";
$fines_result = mysqli_query($conn, $fines_sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Librarian History</title>
    <link rel="stylesheet" href="librarian_history.css">
    <link rel="icon" type="image/png" href="../logosample1.png">
</head>

<body>
    <!-- Header (Navbar) -->
    <?php include 'HEADER-NAVBAR.PHP' ?>

    <!-- Main Container -->
    <div class="librarian-history-container">
        <!-- Header Section -->
        <div class="librarian-history-header">
            <h2>Librarian Action History</h2>
            <div class="librarian-history-tabs">
                <button class="tab active" onclick="showTab('approved')">Approved</button>
                <button class="tab" onclick="showTab('rejected')">Rejected</button>
                <button class="tab" onclick="showTab('fines')">Fines</button>
            </div>
        </div>

        <!-- Tabs Content -->
        <div class="librarian-history-section active" id="approved">
            <h3 class="sub-heading" style="color: green;">Approved Borrow Requests</h3>
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Book</th>
                        <th>Date Approved</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($approved_result && mysqli_num_rows($approved_result) > 0) {
                        while ($row = mysqli_fetch_assoc($approved_result)) {
                            echo "<tr>
                <td>{$row['student_no']}</td>
                <td>{$row['book_title']}</td>
                <td>{$row['update_datetime']}</td>
            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No approved borrow requests found.</td></tr>";
                    }
                    ?>
                </tbody>

            </table>
        </div>

        <div class="librarian-history-section" id="rejected">
            <h3 class="sub-heading" style="color: red;">Rejected Requests</h3>
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Book</th>
                        <th>Reason </th>
                        <th>Rejection Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($rejected_result && mysqli_num_rows($rejected_result) > 0) {
                        while ($row = mysqli_fetch_assoc($rejected_result)) {
                            echo "<tr>
    <td>{$row['student_no']}</td>
    <td>{$row['book_title']}</td>
    <td>{$row['reason']}</td>
    <td>{$row['update_datetime']}</td>
</tr>
";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No rejected requests found.</td></tr>";
                    }
                    ?>
                </tbody>

            </table>
        </div>

        <div class="librarian-history-section" id="fines">
            <h3 class="sub-heading">Fines Issued</h3>
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Book</th>
                        <th>Fine Type</th>
                        <th>Amount</th>
                        <th>Date Issued</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($fines_result && mysqli_num_rows($fines_result) > 0) {
                        while ($row = mysqli_fetch_assoc($fines_result)) {
                            $status = ucfirst($row['status']);
                            $statusColor = $status === 'Paid' ? 'green' : 'red';
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['student_no']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['book_title']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['fine_name']) . "</td>";
                            echo "<td>₱" . number_format($row['price'], 2) . "</td>";
                            echo "<td>" . date("F j, Y g:i A", strtotime($row['date_issued'])) . "</td>";
                            echo "<td style='color: {$statusColor}; font-weight: bold;'>{$status}</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No fines issued yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            const tabs = document.querySelectorAll('.librarian-history-section');
            const buttons = document.querySelectorAll('.tab');

            tabs.forEach(tab => tab.classList.remove('active'));
            buttons.forEach(btn => btn.classList.remove('active'));

            document.getElementById(tabId).classList.add('active');
            event.target.classList.add('active');
        }
    </script>
</body>

</html>