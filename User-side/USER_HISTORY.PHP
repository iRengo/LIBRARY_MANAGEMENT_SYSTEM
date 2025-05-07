<?php 
include '../Homepage/db_connect.php';
session_start();

$student_no = $_SESSION['student_no'];

$borrowed_query = $conn->prepare("SELECT borrow_id, ISBN, book_title, preferred_date, due_date, status FROM borrowed_books WHERE student_no = ?");
$borrowed_query->bind_param("s", $student_no);
$borrowed_query->execute();
$borrowed_result = $borrowed_query->get_result();

$reserved_query = $conn->prepare("SELECT reserved_id, ISBN, book_title, author, reserved_date FROM reserved_books WHERE student_no = ?");
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
    <div class="account-history">
        <h2 style="text-align: left; color: var(--blue); margin-bottom: 20px;">Account History</h2>
        <div class="tabs">
            <div class="tab active" onclick="showTab('borrowing')">Borrowing</div>
            <div class="tab" onclick="showTab('reservation')">Reservation</div>
            <div class="tab">Book Renewal</div>
        </div>

        <!-- Borrowing Table -->
        <div class="tab-content" id="borrowing" style="display: block;">
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
                            <td><?= htmlspecialchars($row['status']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Reservation Table -->
        <div class="tab-content" id="reservation" style="display: none;">
            <table>
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Reservation Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $reserved_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['reserved_id']) ?></td>
                            <td><?= htmlspecialchars($row['ISBN']) ?></td>
                            <td><?= htmlspecialchars($row['book_title']) ?></td>
                            <td><?= htmlspecialchars($row['author']) ?></td>
                            <td><?= htmlspecialchars($row['reserved_date']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

<script>
function showTab(tabName) {
    document.querySelectorAll(".tab-content").forEach(el => el.style.display = "none");
    document.getElementById(tabName).style.display = "block";
    document.querySelectorAll(".tab").forEach(el => el.classList.remove("active"));
    event.target.classList.add("active");
}
</script>
</body>
</html>
