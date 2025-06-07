<?php
session_start();
include '../Homepage/db_connect.php';

// Borrowed books query
$borrow_sql = "SELECT b.borrow_id, b.student_no, b.book_title, b.preferred_date, b.due_date, b.status, 
                      b.update_datetime, 
                      l.first_name AS librarian_fname, l.last_name AS librarian_lname
               FROM borrowed_books b
               LEFT JOIN librarian_acc l ON b.updated_by = l.librarian_no
               ORDER BY b.borrow_id DESC";
$borrow_result = mysqli_query($conn, $borrow_sql);

// Reserved books query
$reserve_sql = "SELECT reserve_id, student_no, first_name, last_name, email, contact, book_id, ISBN, book_title, preferred_date, due_date, reserve_date
                FROM reserved_books ORDER BY reserve_date DESC";
$reserve_result = mysqli_query($conn, $reserve_sql);

$fines_sql = "SELECT f.violation_id, f.student_no, f.book_id, f.fine_id, f.proof, f.date_issued, f.status, 
                     f.updated_by, l.first_name AS librarian_fname, l.last_name AS librarian_lname,
                     ft.price AS fine_price,
                     f.overdue_amount
              FROM student_fines f
              LEFT JOIN librarian_acc l ON f.updated_by = l.librarian_no
              LEFT JOIN fines_table ft ON f.fine_id = ft.fine_id
              ORDER BY f.date_issued DESC";
$fines_result = mysqli_query($conn, $fines_sql);

// Query to get total fine amount + total overdue amount combined
$total_fines_sql = "
    SELECT 
        SUM(ft.price) AS total_fine_amount,
        SUM(f.overdue_amount) AS total_overdue_amount,
        SUM(ft.price) + SUM(f.overdue_amount) AS grand_total
    FROM student_fines f
    LEFT JOIN fines_table ft ON f.fine_id = ft.fine_id
    WHERE f.status = 'Paid'
";
$total_fines_result = mysqli_query($conn, $total_fines_sql);

$total_fine_amount = 0;
$total_overdue_amount = 0;
$grand_total = 0;

if ($total_fines_result && $row = mysqli_fetch_assoc($total_fines_result)) {
    $total_fine_amount = (float) $row['total_fine_amount'];
    $total_overdue_amount = (float) $row['total_overdue_amount'];
    $grand_total = (float) $row['grand_total'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ADMIN NOTIFICATIONS</title>
    <link rel='stylesheet' href="ADMIN_NOTIFICATIONS.CSS" />
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>

    <div class="page-header">
        <div class="header-text">
            <h2>Admin Notifications</h2>
            <p class="page-subtitle">Logs and activities inside the system</p>
        </div>

        <select id="viewSelector" aria-label="Select notification type">
            <option value="borrowed" selected>Borrowed Books</option>
            <option value="reserved">Reserved Books</option>
            <option value="fines">Student Fines</option>
        </select>
    </div>
    <div class="notifications-container">
        <!-- Borrowed Books Table -->
        <div id="borrowed" class="tab-content active">
            <table>
                <thead>
                    <tr>
                        <th>Borrow ID</th>
                        <th>Student No</th>
                        <th>Book Title</th>
                        <th>Status</th>
                        <th>Action Date</th>
                        <th>Updated By (Librarian)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($borrow_result && mysqli_num_rows($borrow_result) > 0) {
                        while ($row = mysqli_fetch_assoc($borrow_result)) {
                            echo "<tr>
                                <td>{$row['borrow_id']}</td>
                                <td>{$row['student_no']}</td>
                                <td>{$row['book_title']}</td>
                                <td>{$row['status']}</td>
                                <td>{$row['update_datetime']}</td>
                                <td>{$row['librarian_fname']} {$row['librarian_lname']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align:center; font-style: italic;'>No borrowed books found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Reserved Books Table -->
        <div id="reserved" class="tab-content">
            <table>
                <thead>
                    <tr>
                        <th>Reserve ID</th>
                        <th>Student No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Book Title</th>
                        <th>Reserve Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($reserve_result && mysqli_num_rows($reserve_result) > 0) {
                        while ($row = mysqli_fetch_assoc($reserve_result)) {
                            $fullName = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
                            echo "<tr>
                                <td>{$row['reserve_id']}</td>
                                <td>{$row['student_no']}</td>
                                <td>{$fullName}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['book_title']}</td>
                                <td>{$row['reserve_date']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' style='text-align:center; font-style: italic;'>No reserved books found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Student Fines Table -->
<div id="fines" class="tab-content">
    <table>
        <thead>
            <tr>
                <th>Violation ID</th>
                <th>Student No</th>
                <th>Book ID</th>
                <th>Fine Amount</th>
                <th>Overdue Amount</th>
                <th>Total</th>  <!-- New total column -->
                <th>Date Issued</th>
                <th>Status</th>
                <th>Updated By</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($fines_result && mysqli_num_rows($fines_result) > 0) {
                while ($row = mysqli_fetch_assoc($fines_result)) {
                    $fine = (float) $row['fine_price'];
                    $overdue = (float) $row['overdue_amount'];
                    $total = $fine + $overdue;

                    echo "<tr>
                        <td>{$row['violation_id']}</td>
                        <td>{$row['student_no']}</td>
                        <td>{$row['book_id']}</td>
                        <td>₱" . number_format($fine, 2) . "</td>
                        <td>₱" . number_format($overdue, 2) . "</td>
                        <td>₱" . number_format($total, 2) . "</td>  <!-- Show total here -->
                        <td>{$row['date_issued']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['librarian_fname']} {$row['librarian_lname']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='9' style='text-align:center; font-style: italic;'>No fines found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


    <script>
        // JavaScript to switch tabs based on dropdown selection
        const selector = document.getElementById('viewSelector');
        const tabs = ['borrowed', 'reserved', 'fines'];

        selector.addEventListener('change', () => {
            const selected = selector.value;
            tabs.forEach(tab => {
                document.getElementById(tab).classList.toggle('active', tab === selected);
            });
        });
    </script>

</body>

</html>