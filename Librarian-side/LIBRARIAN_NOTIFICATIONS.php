<?php 
session_start();
include '../Homepage/db_connect.php'; // adjust path if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Librarian Notifications</title>
    <link rel="stylesheet" href="LIBRARIAN_NOTIFICATIONS.css">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>

    <div class="notifications-container">
    <h2>Librarian Notifications</h2>

    <div class="tabs">
        <button class="tab-button active" onclick="showTab('borrow')">Borrow Requests</button>
        <button class="tab-button" onclick="showTab('reserve')">Reserved Books</button>
    </div>

    <div id="borrow" class="tab-content active-tab">
        <table>
            <thead>
                <tr>
                    <th>Borrow ID</th>
                    <th>Student No</th>
                    <th>Book Title</th>
                    <th>Preferred Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $borrow_sql = "SELECT * FROM borrowed_books WHERE status = 'Pending' ORDER BY borrow_id DESC";
                $borrow_result = mysqli_query($conn, $borrow_sql);

                if ($borrow_result && mysqli_num_rows($borrow_result) > 0) {
                    while ($row = mysqli_fetch_assoc($borrow_result)) {
                        echo "<tr>
                                <td>{$row['borrow_id']}</td>
                                <td>{$row['student_no']}</td>
                                <td>{$row['book_title']}</td>
                                <td>{$row['preferred_date']}</td>
                                <td>{$row['status']}</td>
                                <td class='action-icons'>
                                    <i class='accept' onclick='acceptRequest({$row['borrow_id']})'>&#10003;</i>
                                    <i class='decline' onclick='declineRequest(" .
                                        json_encode($row['borrow_id']) . "," .
                                        json_encode($row['student_no']) . "," .
                                        json_encode($row['email']) . "," .
                                        json_encode($row['book_title']) . "," .
                                        json_encode($row['contact']) . "," .
                                        json_encode($row['preferred_date']) . 
                                    ")'>&#10005;</i>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No borrow requests found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id="reserve" class="tab-content">
        <table>
            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>Student No</th>
                    <th>Book Title</th>
                    <th>Reserved Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $reserve_sql = "SELECT reserved_id, student_no, book_title, reserved_date FROM reserved_books ORDER BY reserved_id DESC";
                $reserve_result = mysqli_query($conn, $reserve_sql);

                if ($reserve_result && mysqli_num_rows($reserve_result) > 0) {
                    while ($row = mysqli_fetch_assoc($reserve_result)) {
                        echo "<tr>
                                <td>{$row['reserved_id']}</td>
                                <td>{$row['student_no']}</td>
                                <td>{$row['book_title']}</td>
                                <td>{$row['reserved_date']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No reserved books found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function showTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active-tab'));
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    document.getElementById(tabId).classList.add('active-tab');
    event.target.classList.add('active');
}

function acceptRequest(borrowId) {
    fetch('LIBRARIAN_BORROW_ACTION.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=accept&borrow_id=' + borrowId
    })
    .then(res => res.text())
    .then(data => {
        Swal.fire('Accepted!', 'Borrow request accepted.', 'success').then(() => location.reload());
    });
}

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
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                Swal.fire('Declined', 'Request declined and logged.', 'info').then(() => location.reload());
            });
        }
    });
}
</script>
</body>
</html>