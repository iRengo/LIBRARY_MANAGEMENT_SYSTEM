<?php 
session_start();
include '../Homepage/db_connect.php';
$pickup_sql = "SELECT bb.*, b.book_cover 
                FROM borrowed_books bb
                JOIN tbl_books b ON bb.book_id = b.book_id
                WHERE bb.status = 'Approved'
                ORDER BY bb.borrow_id DESC";

$pickup_result = mysqli_query($conn, $pickup_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> LIBRARIAN Ready To Pickup</title>
    <link rel='stylesheet' href="LIBRARIAN_NOTIFICATIONS.CSS">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>


    <div class="notifications-container">
        <h2>Librarian Ready To Pickup</h2>

        <div id="pickup" class="tab-content">

            <table>
                <thead>
                    <tr>
                        <th>Book Cover</th>
                        <th>Borrow ID</th>
                        <th>Student No</th>
                        <th>Book Title</th>
                        <th>Preferred Date</th>
                        <th>Pickup Deadline</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($pickup_result && mysqli_num_rows($pickup_result) > 0) {
                        while ($row = mysqli_fetch_assoc($pickup_result)) {
                            $imageURL = $row['book_cover'];

                            echo "<tr>
                        <td><img src='{$imageURL}' alt='Book Cover' style='width: 60px; height: auto; border-radius: 4px;'></td>
                        <td>{$row['borrow_id']}</td>
                        <td>{$row['student_no']}</td>
                        <td>{$row['book_title']}</td>
                        <td>{$row['preferred_date']}</td>
                        <td>Within 24 hours</td>
                        <td>{$row['status']}</td>
                        <td>
    <button onclick='markAsPickedUp({$row['borrow_id']})' style='padding: 6px 12px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;'>Picked Up</button>
</td>
                    </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No ready-to-pickup books found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <script>
            function markAsPickedUp(borrowId) {
                fetch('LIBRARIAN_BORROW_ACTION.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'action=mark_borrowed&borrow_id=' + borrowId
                    })
                    .then(res => res.text())
                    .then(data => {
                        Swal.fire('Success', 'Book Successfully Borrowed.', 'success').then(() => location.reload());
                    });
            }
        </script>
</body>

</html>