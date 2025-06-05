<?php
session_start();
include '../Homepage/db_connect.php';


$student_no = $_SESSION['student_no'];

$borrowed_query = $conn->prepare("SELECT borrow_id, ISBN, book_title, preferred_date, due_date, status FROM borrowed_books WHERE student_no = ? order by update_datetime desc");
$borrowed_query->bind_param("s", $student_no);
$borrowed_query->execute();
$borrowed_result = $borrowed_query->get_result();

$reserved_query = $conn->prepare("SELECT reserve_id, ISBN, book_title, reserve_date, preferred_date FROM reserved_books WHERE student_no = ? order by reserve_id desc");
$reserved_query->bind_param("s", $student_no);
$reserved_query->execute();
$reserved_result = $reserved_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title> USER HISTORY </title>
    <link rel="stylesheet" href="USER_HISTORY.css">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP' ?>

    <div class="user-history-container">
        <!-- Header Section -->
        <div class="user-history-header">
            <h2>User Account History</h2>
            <div class="user-history-tabs">
                <button class="tab active" onclick="showTab('borrowing')">Borrowing</button>
                <button class="tab" onclick="showTab('reservation')">Reservation</button>
            </div>
        </div>

        <!-- Borrowing Section -->
        <div class="user-history-section active" id="borrowing">
            <h3 class="sub-heading" style="color: #234078;">Borrowing History</h3>
            <table>
                <thead>
                    <tr>
                        <th>Borrow ID</th>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $borrowed_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['borrow_id']) ?></td>
                            <td><?= htmlspecialchars($row['ISBN']) ?></td>
                            <td><?= htmlspecialchars($row['book_title']) ?></td>
                            <td><?= htmlspecialchars($row['preferred_date']) ?></td>
                            <td><?= htmlspecialchars($row['due_date']) ?></td>
                            <?php
                            $status = htmlspecialchars($row['status']);
                            $class = '';
                            switch (strtolower($status)) {
                                case 'returned':
                                    $class = 'status-returned';
                                    break;
                                case 'borrowed':
                                    $class = 'status-borrowed';
                                    break;
                                case 'approved':
                                    $class = 'status-approved';
                                    break;
                                case 'pending':
                                    $class = 'status-pending';
                                    break;
                            }
                            ?>
                            <td class="<?= $class ?>"><?= $status ?></td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Reservation Section -->
        <div class="user-history-section" id="reservation">
            <h3 class="sub-heading" style="color: #234078;">Reservation History</h3>
            <table>
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Preferred Date</th>
                        <th>Reservation Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $reserved_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['reserve_id']) ?></td>
                            <td><?= htmlspecialchars($row['ISBN']) ?></td>
                            <td><?= htmlspecialchars($row['book_title']) ?></td>
                            <td><?= htmlspecialchars($row['preferred_date']) ?></td>
                            <td><?= htmlspecialchars($row['reserve_date']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            document.querySelectorAll(".user-history-section").forEach(el => el.classList.remove("active"));
            document.querySelectorAll(".tab").forEach(el => el.classList.remove("active"));
            document.getElementById(tabId).classList.add("active");
            event.target.classList.add("active");
        }
    </script>
</body>

</html>