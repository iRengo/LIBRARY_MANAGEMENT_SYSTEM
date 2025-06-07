<?php
session_start();
include '../homepage/db_connect.php';

// Overdue books (borrowed, due date has passed)
$overdue_query = "SELECT COUNT(*) AS total FROM borrowed_books WHERE status = 'Borrowed' AND DATEDIFF(CURRENT_DATE, due_date) > 0";
$overdue_result = $conn->query($overdue_query);
$overdue_count = $overdue_result->fetch_assoc()['total'] ?? 0;

// Reserved books
$reserved_query = "SELECT COUNT(*) AS total FROM reserved_books";
$reserved_result = $conn->query($reserved_query);
$reserved_count = $reserved_result->fetch_assoc()['total'] ?? 0;

// Returned books
$returned_query = "SELECT COUNT(*) AS total FROM returned_books";
$returned_result = $conn->query($returned_query);
$returned_count = $returned_result->fetch_assoc()['total'] ?? 0;

// Available books
$available_query = "SELECT COUNT(*) AS total FROM tbl_books WHERE status = 'Available'";
$available_result = $conn->query($available_query);
$available_count = $available_result->fetch_assoc()['total'] ?? 0;


$books_query = "SELECT book_title, book_author, book_genre, book_stocks FROM tbl_books";
$books_result = $conn->query($books_query);

// Borrowed Requests (status = 'Pending')
$borrowed_requests_query = "SELECT COUNT(*) AS total FROM borrowed_books WHERE status = 'Pending'";
$borrowed_requests_result = $conn->query($borrowed_requests_query);
$borrowed_requests_count = $borrowed_requests_result->fetch_assoc()['total'] ?? 0;

// Ready to Pickup (status = 'Approved')
$ready_to_pickup_query = "SELECT COUNT(*) AS total FROM borrowed_books WHERE status = 'Approved'";
$ready_to_pickup_result = $conn->query($ready_to_pickup_query);
$ready_to_pickup_count = $ready_to_pickup_result->fetch_assoc()['total'] ?? 0;

// Unpaid Fines 
$unpaid_fines_query = "SELECT COUNT(*) AS total FROM student_fines where status = 'unpaid' ";
$unpaid_fines_result = $conn->query($unpaid_fines_query);
$unpaid_fines_count = $unpaid_fines_result->fetch_assoc()['total'] ?? 0;

// Upcoming Books (status = 'Upcoming')
$borrowed_books_query = "SELECT COUNT(*) AS total FROM borrowed_books WHERE status = 'borrowed'";
$borrowed_books_result = $conn->query($borrowed_books_query);
$borrowed_books_count = $borrowed_books_result->fetch_assoc()['total'] ?? 0;


$fines_query = "
SELECT 
    DATE_FORMAT(sf.date_issued, '%b') AS month_short,
    SUM(ft.price) AS total_fines,
    SUM(sf.overdue_amount) AS total_overdue_amount,
    SUM(ft.price) + SUM(sf.overdue_amount) AS total_combined
FROM student_fines sf
JOIN fines_table ft ON sf.fine_id = ft.fine_id
WHERE sf.status = 'Paid'
GROUP BY month_short
ORDER BY MONTH(sf.date_issued)
";

$fines_result = $conn->query($fines_query);

$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

$fines_data_assoc = [];
while ($row = $fines_result->fetch_assoc()) {
    // Store the combined total (base fine + overdue amount) per month
    $fines_data_assoc[$row['month_short']] = (float)$row['total_combined'];
}

$fines_data = [];
foreach ($months as $month) {
    // Fill with 0 if no data for that month
    $fines_data[] = $fines_data_assoc[$month] ?? 0;
}

$top_books_query = "
    SELECT 
        b.book_id, 
        b.book_cover, 
        b.book_title, 
        COUNT(bb.book_id) AS total_borrowed 
    FROM borrowed_books bb
    JOIN tbl_books b ON bb.book_id = b.book_id
    GROUP BY bb.book_id 
    ORDER BY total_borrowed DESC 
    LIMIT 5
";
$top_books_result = $conn->query($top_books_query);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Librarian Catalog </title>
    <link rel="stylesheet" href="LIBRARIAN_DASHBOARD.CSS">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP' ?>

    <div class="dashboard">
        <div class="top-cards">
            <div class="card overdue">
                <i class="fas fa-clock"></i>
                <div>
                    <h3>Borrow Request</h3>
                    <p><?= $borrowed_requests_count ?></p>
                </div>
            </div>
            <div class="card reserved">
                <i class="fas fa-box-open"></i>
                <div>
                    <h3>Ready to Pickup</h3>
                    <p><?= $ready_to_pickup_count ?></p>
                </div>
            </div>
            <div class="card returned">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <h3>Unpaid Fines</h3>
                    <p><?= $unpaid_fines_count ?></p>
                </div>
            </div>
            <div class="card available">
               <i class="fas fa-book-open"></i>
                <div>
                    <h3>Borrowed Books</h3>
                    <p><?= $borrowed_books_count ?></p>
                </div>
            </div>
        </div>


        <div class="middle-section">
            <div class="chart">

                <canvas id="bookAvailabilityChart" style="width: 50px; height: 50px;"></canvas>
            </div>
            <div class="trend">
                <h4>Total Fines Collected Per Month</h4>
                <canvas id="monthlyTrendsChart" style="width: 50%;"></canvas>

                <h4>Top Borrowed Books</h4>
                <div class="top-borrowed-list">
                    <?php while ($row = $top_books_result->fetch_assoc()): ?>
                        <div class="top-book-item">
                            <img src="<?= $row['book_cover'] ?>" alt="<?= $row['book_title'] ?>" />
                            <div>
                                <p class="title"><?= $row['book_title'] ?></p>
                                <p class="count">Borrowed <?= $row['total_borrowed'] ?> times</p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>


            </div>
        </div>

        <!-- Bottom Section -->
        <div class="bottom-section">
            <div class="managed-books">
                <h4>Managed Books</h4>
                <input type="text" id="searchInput" placeholder="Search by title, author, or genre" onkeyup="filterTable()" style="width: 80%; margin-bottom:3%;">
                <button>Search</button>

                <div class="table-scroll">
                    <table id="booksTable">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Title</th>
                                <th>Authors</th>
                                <th>Genre</th>
                                <th>Stocks</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if ($books_result->num_rows > 0): ?>
                                <?php while ($book = $books_result->fetch_assoc()): ?>
                                    <?php
                                    $stocks = (int)$book['book_stocks'];
                                    if ($stocks <= 10) {
                                        $circleColor = 'red';
                                    } elseif ($stocks <= 20) {
                                        $circleColor = 'yellow';
                                    } else {
                                        $circleColor = 'green';
                                    }
                                    ?>
                                    <tr>
                                        <td><span class="status-circle" style="background-color: <?= $circleColor ?>;"></span></td>
                                        <td><?= htmlspecialchars($book['book_title']) ?></td>
                                        <td><?= htmlspecialchars($book['book_author']) ?></td>
                                        <td><?= htmlspecialchars($book['book_genre']) ?></td>
                                        <td><?= $stocks ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No books found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>


            </table>
        </div>



        <script>
            const totalAvailable = <?= $available_count ?>;
            const totalReserved = <?= $reserved_count ?>;
            const totalOverdue = <?= $overdue_count ?>;
            const totalReturned = <?= $returned_count ?>;
            // Book Availability Chart
            const bookAvailabilityCtx = document.getElementById('bookAvailabilityChart').getContext('2d');
            new Chart(bookAvailabilityCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Available', 'Reserved', 'Overdue', 'Returned'],
                    datasets: [{
                        data: [totalAvailable, totalReserved, totalOverdue, totalReturned],
                        backgroundColor: ['#3a0ca3', '#14213d', '#00b4d8', '#6c5b7b']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Library Book Distribution',
                            font: {
                                size: 16
                            }
                        },
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#333',
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.label}: ${context.raw}`;
                                }
                            }
                        }
                    }
                }
            });


            const monthlyTrendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
            new Chart(monthlyTrendsCtx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($months) ?>,
                    datasets: [{
                        label: 'Fines Collected',
                        data: <?= json_encode($fines_data) ?>,
                        backgroundColor: '#dc3545' // red for fines
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Months'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total Fines Collected (₱)'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });


            // Live Search Functionality
            function filterTable() {
                const input = document.getElementById('searchInput');
                const filter = input.value.toLowerCase();
                const table = document.getElementById('booksTable');
                const rows = table.getElementsByTagName('tr');

                for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
                    const cells = rows[i].getElementsByTagName('td');
                    let match = false;

                    for (let j = 0; j < cells.length; j++) {
                        if (cells[j].textContent.toLowerCase().includes(filter)) {
                            match = true;
                            break;
                        }
                    }

                    rows[i].style.display = match ? '' : 'none';
                }
            }
        </script>

</body>

</html>