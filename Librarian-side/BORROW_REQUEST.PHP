<?php 
session_start();
include '../Homepage/db_connect.php';

$borrow_sql = "SELECT bb.*, b.book_cover 
    FROM borrowed_books bb
    JOIN tbl_books b ON bb.book_id = b.book_id
    WHERE bb.status = 'Pending'
    ORDER BY bb.borrow_id DESC";

$borrow_result = mysqli_query($conn, $borrow_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> LIBRARIAN BORROW REQUEST</title>
    <link rel='stylesheet' href="LIBRARIAN_NOTIFICATIONS.CSS">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>


    <div class="notifications-container">
        <h2>Librarian Borrow requests</h2>

        <div id="borrow" class="tab-content active-tab">
            <table>
                <thead>
                    <tr>
                        <th>Cover</th>
                        <th>Borrow ID</th>
                        <th>Student No</th>
                        <th>Book Title</th>
                        <th>Preferred Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $borrow_sql = "SELECT bb.*, b.book_cover 
                FROM borrowed_books bb
                JOIN tbl_books b ON bb.book_id = b.book_id
                WHERE bb.status = 'Pending'
                ORDER BY bb.borrow_id DESC";


                    $borrow_result = mysqli_query($conn, $borrow_sql);

                    if ($borrow_result && mysqli_num_rows($borrow_result) > 0) {
                        while ($row = mysqli_fetch_assoc($borrow_result)) {
                            $imageURL = $row['book_cover'];

                            echo "<tr>
                                <td><img src='{$imageURL}' alt='Book Cover' style='width: 60px; height: auto; border-radius: 4px;'></td>
                                <td>{$row['borrow_id']}</td>
                                <td>{$row['student_no']}</td>
                                <td>{$row['book_title']}</td>
                                <td>{$row['preferred_date']}</td>
                                <td>{$row['status']}</td>
                               <td class='action-icons'>
                                    <i class='accept' onclick='acceptRequest({$row['borrow_id']})'>&#10003;</i>
                                    <i class='decline' onclick='declineRequest(
    " . json_encode($row['borrow_id']) . ", 
    " . json_encode($row['student_no']) . ", 
    " . json_encode($row['email']) . ", 
    " . json_encode($row['book_title']) . ", 
    " . json_encode($row['contact']) . ", 
    " . json_encode($row['preferred_date']) . "
)'>&#10006;</i>

                                </td>
                              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No borrow requests found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>



    <script>
        function declineRequest(borrow_id, student_no, email, title, contact, preferred_date) {
            Swal.fire({
                title: 'Reason for Decline',
                input: 'text',
                inputLabel: 'Enter reason',
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) return 'You must provide a reason!';
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const reason = result.value;
                    const formData = new URLSearchParams();
                    formData.append('action', 'decline');
                    formData.append('borrow_id', borrow_id);
                    formData.append('student_no', student_no);
                    formData.append('email', email);
                    formData.append('title', title);
                    formData.append('contact', contact);
                    formData.append('preferred_date', preferred_date);
                    formData.append('status', 'Declined');
                    formData.append('reason', reason);

                    fetch('LIBRARIAN_BORROW_ACTION.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: formData
                        })
                        .then(res => res.text())
                        .then(data => {
                            Swal.fire('Declined', 'Request declined and logged.', 'info').then(() => location.reload());
                        });
                }
            });
        }

        function acceptRequest(borrowId) {
            fetch('LIBRARIAN_BORROW_ACTION.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'action=accept&borrow_id=' + borrowId
                })
                .then(res => res.text())
                .then(data => {
                    Swal.fire('Accepted!', 'Borrow request accepted.', 'success').then(() => location.reload());
                });
        }
    </script>

</body>

</html>