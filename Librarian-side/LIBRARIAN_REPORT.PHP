<?php
session_start();
include '../homepage/db_connect.php';
$loggedInUser = $_SESSION['librarian_no'];


$summary_overall = [];


$sql_borrowed = "
    SELECT COUNT(*) AS count 
    FROM borrowed_books 
    WHERE status = 'Borrowed'
";

$result = mysqli_query($conn, $sql_borrowed);
$row = mysqli_fetch_assoc($result);
$summary_overall['Borrowed Books'] = $row['count'] ?? 0;


$sql_reserved = "
    SELECT COUNT(*) AS count 
    FROM reserved_books
";

$result = mysqli_query($conn, $sql_reserved);
$row = mysqli_fetch_assoc($result);
$summary_overall['Reserved Books'] = $row['count'] ?? 0;


$sql_returned = "
    SELECT COUNT(*) AS count 
    FROM returned_books
";

$result = mysqli_query($conn, $sql_returned);
$row = mysqli_fetch_assoc($result);
$summary_overall['Returned Books'] = $row['count'] ?? 0;


$sql_fines_count = "
    SELECT COUNT(*) AS count 
    FROM student_fines
";
$result = mysqli_query($conn, $sql_fines_count);
$row = mysqli_fetch_assoc($result);
$summary_overall['Fines Issued'] = $row['count'] ?? 0;


$sql_total_fines = "
    SELECT IFNULL(SUM(f.price), 0) AS total 
    FROM student_fines sf 
    LEFT JOIN fines_table f ON sf.fine_id = f.fine_id
";
$result = mysqli_query($conn, $sql_total_fines);
$row = mysqli_fetch_assoc($result);
$summary_overall['Total Fines'] = number_format($row['total'] ?? 0, 2);


function selectedIf($value, $selectedValue)
{
    return $value === $selectedValue ? 'selected' : '';
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Librarian Reports - Student File</title>
    <link rel="stylesheet" href="LIBRARIAN_REPORT.CSS">

</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>


    <div class="receipt-container">
        <Br> <Br>

        <div class="summary-overall">

            <?php foreach ($summary_overall as $label => $value): ?>
                <div class="summary-card">
                    <h3><?= htmlspecialchars($label) ?></h3>
                    <p><?= is_numeric($value) && $label === 'Total Fines' ? '₱' . $value : $value ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <form method="POST" action="LIBRARIAN_GENERATE_REPORTS.PHP" target="_blank" id="pdfForm" style="align-self: flex-start;">
            <input type="hidden" name="month_filter" value="<?= htmlspecialchars($monthFilter) ?>">
            <input type="hidden" name="student_no" value="<?= htmlspecialchars($selectedStudent ?? '') ?>">
            <button type="submit" id="generatePdfBtn" class="btn-generate-pdf">Generate PDF</button>
        </form>

        <form method="POST" class="student-select-form" id="studentForm">
            <label for="student_no" style="font-weight: 600;">Select Student:</label>
            <select name="student_no" id="student_no" required onchange="document.getElementById('studentForm').submit()">
                <option value="" aria-required="true">-- Choose Student --</option>
                <?php
                $students_sql = "SELECT DISTINCT student_no FROM borrowed_books ORDER BY student_no ASC";
                $students_result = mysqli_query($conn, $students_sql);
                $selectedStudent = $_POST['student_no'] ?? null;
                while ($student = mysqli_fetch_assoc($students_result)) {
                    $selected = ($selectedStudent == $student['student_no']) ? 'selected' : '';
                    echo "<option value='{$student['student_no']}' $selected>{$student['student_no']}</option>";
                }
                ?>
            </select>
            <button type="button" id="clearBtn">Clear</button>

            <!-- Keep the selected month filter in POST when selecting student -->
            <input type="hidden" name="month_filter" value="<?= htmlspecialchars($monthFilter) ?>">
        </form>



        <?php if ($selectedStudent): ?>
            <div class="student-file">

                <h3>Student File: <?= htmlspecialchars($selectedStudent) ?></h3>

                <?php
                $student_info_sql = "SELECT first_name, last_name , email FROM tbl_students WHERE student_number = '$selectedStudent' LIMIT 1";
                $student_info_result = mysqli_query($conn, $student_info_sql);
                $student_info = mysqli_fetch_assoc($student_info_result);
                ?>

                <div class="info-section">
                    <dl>
                        <dt>Student Number:</dt>
                        <dd><?= htmlspecialchars($selectedStudent) ?></dd>
                        <dt>Name:</dt>
                        <dd><?= htmlspecialchars($student_info['first_name'] ?? 'N/A') ?></dd>
                        <dd><?= htmlspecialchars($student_info['last_name'] ?? 'N/A') ?></dd>

                        <dt>Email:</dt>
                        <dd><?= htmlspecialchars($student_info['email'] ?? 'N/A') ?></dd>
                    </dl>
                </div>

                <br> <br>
                <div class="section-title">Returned Books</div>
                <table>
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Date Borrowed</th>
                            <th>Date Returned</th>
                            <th>Condition
                            <th>
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
            <td>" . htmlspecialchars($row['book_condition'] ?? 'N/A') . "</td>
        </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' style='text-align:center;'>No returned books found.</td></tr>";
                        }
                        ?>

                    </tbody>
                </table>


                <!-- Borrowed Books -->
                <div class="borrowed-books">
                    <div class="section-title">Borrowed Books</div>
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
                                echo "<tr><td colspan='4' style='text-align:center;'>No borrowed books found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Reserved Books -->
                <div class="reserved-books">
                    <div class="section-title">Reserved Books</div>
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
                                echo "<tr><td colspan='2' style='text-align:center;'>No reserved books found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Fines Issued -->
                <div class="fines-issued">
                    <div class="section-title">Fines Issued</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Fine Type</th>
                                <th>Amount</th>
                                <th>Date Issued</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalFines = 0;
                            $fines_sql = "
            SELECT f.fine_name, f.price, sf.date_issued, sf.status
            FROM student_fines sf
            LEFT JOIN fines_table f ON sf.fine_id = f.fine_id
            WHERE sf.student_no = '$selectedStudent'
            ORDER BY sf.date_issued DESC
            ";
                            $fines_result = mysqli_query($conn, $fines_sql);
                            if (mysqli_num_rows($fines_result) > 0) {
                                while ($row = mysqli_fetch_assoc($fines_result)) {
                                    $statusColor = strtolower($row['status']) === 'paid' ? '#28a745' : '#dc3545';
                                    $amount = (float)$row['price'];
                                    $totalFines += $amount;
                                    echo "<tr>
                        <td>" . htmlspecialchars($row['fine_name']) . "</td>
                        <td>₱" . number_format($amount, 2) . "</td>
                        <td>" . htmlspecialchars($row['date_issued']) . "</td>
                        <td style='color: $statusColor; font-weight: bold;'>" . htmlspecialchars($row['status']) . "</td>
                    </tr>";
                                }
                                // Print total row
                                echo "<tr style='font-weight:bold; background:#f0f0f0;'>
                    <td>Total</td>
                    <td>₱" . number_format($totalFines, 2) . "</td>
                    <td colspan='2'></td>
                </tr>";
                            } else {
                                echo "<tr><td colspan='4' style='text-align:center;'>No fines issued.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>


                <!-- Rejected Requests -->
                <div class="rejected-requests">
                    <div class="section-title">Rejected Requests</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Date Requested</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rejected_sql = "
                    SELECT b.book_title, rr.preferred_date, rr.reason
                    FROM rejected_requests rr
                    LEFT JOIN tbl_books b ON rr.book_id = b.book_id
                    WHERE rr.student_no = '$selectedStudent'
                    ORDER BY rr.preferred_date DESC
                    ";
                            $rejected_result = mysqli_query($conn, $rejected_sql);
                            if (mysqli_num_rows($rejected_result) > 0) {
                                while ($row = mysqli_fetch_assoc($rejected_result)) {
                                    echo "<tr>
                                <td>" . htmlspecialchars($row['book_title']) . "</td>
                                <td>" . htmlspecialchars($row['preferred_date']) . "</td>
                                <td>" . htmlspecialchars($row['reason']) . "</td>
                            </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3' style='text-align:center;'>No rejected requests.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>


        <form method="POST" action="LIBRARIAN_GENERATE_STUDENT_REPORT.PHP" target="_blank" style="align-self: flex-end;">
            <input type="hidden" name="student_no" value="<?= htmlspecialchars($selectedStudent) ?>">
            <button type="submit" style="padding: 8px 16px;">Print Student Report</button>
        </form>




    </div>

    <script>
        document.getElementById('student_no').addEventListener('change', function() {
            if (this.value !== '') {
                document.getElementById('studentForm').submit();
            }
        });

        document.getElementById('clearBtn').addEventListener('click', function() {
            document.getElementById('student_no').value = '';
            document.getElementById('studentForm').submit();
        });
    </script>

</body>

</html>