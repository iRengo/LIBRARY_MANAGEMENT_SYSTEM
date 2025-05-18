<?php 
session_start();
include '../Homepage/db_connect.php';

$returned_sql = "SELECT rb.*, b.book_cover 
                 FROM returned_books rb
                 JOIN tbl_books b ON rb.book_id = b.book_id
                 ORDER BY rb.return_date DESC";

$returned_result = mysqli_query($conn, $returned_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> LIBRARIAN RESERVED REQUEST</title>
    <link rel='stylesheet' href="LIBRARIAN_NOTIFICATIONS.CSS">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>


    <div class="notifications-container">
        <h2>Librarian Returned Books</h2>

        <div id="returned">
            <table>
                <thead>
                    <tr>
                        <th>Book Cover</th>
                        <th>Return ID</th>
                        <th>Borrow ID</th>
                        <th>Student No</th>
                        <th>Book Title</th>
                        <th>Return Date</th>
                        <th>Book Condition</th>
                        <th>Handled By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($returned_result && mysqli_num_rows($returned_result) > 0) {
                        while ($row = mysqli_fetch_assoc($returned_result)) {
                            $imageURL = $row['book_cover'];

                            echo "<tr>
                        <td><img src='{$imageURL}' alt='Book Cover' style='width: 60px; height: auto; border-radius: 4px;'></td>
                        <td>{$row['return_id']}</td>
                        <td>{$row['borrow_id']}</td>
                        <td>{$row['student_no']}</td>
                        <td>{$row['book_title']}</td>
                        <td>{$row['return_date']}</td>
                        <td>{$row['book_condition']}</td>
                        <td>{$row['handled_by']}</td>
                    </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No returned books found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

</body>

</html>