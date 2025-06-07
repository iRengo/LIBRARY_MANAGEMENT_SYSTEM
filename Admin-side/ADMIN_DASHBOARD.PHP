<?php
include '../homepage/db_connect.php';
session_start();

if (!isset($_SESSION['admin_no'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        window.onload = function() {
            Swal.fire({
                title: "You are not logged in!",
                text: "Please log in to access the page.",
                icon: "error",
                confirmButtonText: "OK",
                allowOutsideClick: false,
                allowEscapeKey: false,
                willClose: () => {
                    window.location.href = "../homepage/homepage.php";
                }
            });
        }
        </script>';
    exit();
}

$admin_id = $_SESSION['admin_no'];
$current_time = date('Y-m-d H:i:s');

// Update last_logged_in
$stmt = $conn->prepare("UPDATE admin_acc SET last_logged_in = ? WHERE admin_no = ?");
$stmt->bind_param("si", $current_time, $admin_id);
$stmt->execute();
$stmt->close();

// Get total librarians
$result = $conn->query("SELECT COUNT(*) as total FROM librarian_acc");
$total_librarians = $result->fetch_assoc()['total'] ?? 0;

// Get total students
$result = $conn->query("SELECT COUNT(*) as total FROM stud_acc");
$total_students = $result->fetch_assoc()['total'] ?? 0;

// Get total books
$result = $conn->query("SELECT COUNT(*) as total FROM tbl_books");
$total_books = $result->fetch_assoc()['total'] ?? 0;

$fines_query = "
SELECT 
    SUM(ft.price) AS total_fines,
    SUM(sf.overdue_amount) AS total_overdue_amount,
    (SUM(ft.price) + SUM(sf.overdue_amount)) AS total_collected
FROM student_fines sf
JOIN fines_table ft ON sf.fine_id = ft.fine_id
WHERE sf.status = 'Paid'
";

$fines_result = $conn->query($fines_query);

$fines_collected = 0;
$overdue_collected = 0;
$total_collected = 0;

if ($fines_result && $row = $fines_result->fetch_assoc()) {
    $fines_collected = (float) ($row['total_fines'] ?? 0);
    $overdue_collected = (float) ($row['total_overdue_amount'] ?? 0);
    $total_collected = (float) ($row['total_collected'] ?? 0);
}

// Fetch top users: student_no, first_name, last_name, borrow_count (only counting returned books)
$top_users_sql = "
    SELECT s.student_no, s.first_name, s.last_name, COUNT(b.borrow_id) as borrow_count
    FROM stud_acc s
    JOIN borrowed_books b ON s.student_no = b.student_no
    WHERE b.status = 'Returned'
    GROUP BY s.student_no, s.first_name, s.last_name
    ORDER BY borrow_count DESC
    LIMIT 10";

$top_users_result = $conn->query($top_users_sql);
$top_users = [];

if ($top_users_result) {
    while ($row = $top_users_result->fetch_assoc()) {
        $top_users[] = $row;
    }
}

// Fetch books data for book listing
$books = [];
$sql = "SELECT book_title, book_author, book_cover, book_stocks FROM tbl_books ORDER BY book_id DESC";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
} else {
    $books = [];
}


$category_labels = [];
$category_counts = [];

$sql = "SELECT book_category, COUNT(*) as count FROM tbl_books GROUP BY book_category ORDER BY count DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $category_labels[] = $row['book_category'];
        $category_counts[] = (int) $row['count'];
    }
} else {

    $category_labels = ['No Data'];
    $category_counts = [0];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="ADMIN_DASHBOARD.CSS" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP' ?>

    <div class="main-content">
        <!-- Shortcut buttons -->
        <div class="shortcut-buttons">
            <a href="admin_notifications.php" class="shortcut-btn view-log-btn">
                <i class="fas fa-file-alt"></i> View Log
            </a>
            <a href="admin_users.php" class="shortcut-btn add-librarian-btn">
                <i class="fas fa-user-plus"></i> Add Librarian
            </a>
        </div>
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <h4>Total Librarians</h4>
                <p><?php echo $total_librarians; ?></p>
            </div>
            <div class="dashboard-card">
                <h4>Total Students</h4>
                <p><?php echo $total_students; ?></p>
            </div>
            <div class="dashboard-card">
                <h4>Total Books</h4>
                <p><?php echo $total_books; ?></p>
            </div>
            <div class="dashboard-card">
                <h4>Fines Collected</h4>
                <p>₱<?php echo number_format($total_collected, 2); ?></p>
            </div>
        </div>

        <div class="graph-row">

            <div class="card-box pie-chart">
                <h3>Book Categories</h3>
                <canvas id="genreChart" width="100%" height="300"></canvas>
            </div>

            <div class="card-box top-users">

                <h3>Top Users</h3>
                <br>
                <table class="top-users-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Borrows</th>
                        </tr>
                    </thead>
                    <tbody id="topUsersTbody">
                        <?php foreach ($top_users as $index => $user): ?>
                            <tr data-index="<?php echo $index; ?>">
                                <!-- We'll fill rank numbers dynamically via JS -->
                                <td class="rank-cell"></td>
                                <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                                <td><?php echo $user['borrow_count']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <br>
                <div class="pagination-controls" style="margin-top: 10px;">
                    <button id="prevPageBtn" disabled>Previous</button>
                    <button id="nextPageBtn">Next</button>
                </div>

                <Br>
                <h3>Book Availability</h3>

                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="search" id="bookSearchInput" placeholder="Search Books..." class="book-search-input">
                </div>

                <div class="book-slider-container">
                    <button class="chevron-btn left" onclick="slideBooks(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <div class="book-listing" id="bookListing">
                        <?php if (count($books) > 0): ?>
                            <?php foreach ($books as $book): ?>
                                <div class="book-card">
                                    <?php if (!empty($book['book_cover'])): ?>
                                        <img src="<?php echo htmlspecialchars($book['book_cover']); ?>" alt="Cover of <?php echo htmlspecialchars($book['book_title']); ?>" class="book-cover" />
                                    <?php else: ?>
                                        <div class="book-cover-placeholder">No Cover</div>
                                    <?php endif; ?>
                                    <div class="book-info">
                                        <strong class="book-title"><?php echo htmlspecialchars($book['book_title']); ?></strong><br>
                                        <small class="book-author"><?php echo htmlspecialchars($book['book_author']); ?></small><br>

                                        <?php
                                        $stock = (int) $book['book_stocks']; // assuming this field holds the stock
                                        $stockClass = '';

                                        if ($stock <= 10) {
                                            $stockClass = 'low-stock';
                                        } elseif ($stock < 20) {
                                            $stockClass = 'medium-stock';
                                        } else {
                                            $stockClass = 'high-stock';
                                        }
                                        ?>
                                        <div class="book-stock <?php echo $stockClass; ?>">
                                            <?php echo $stock; ?> in stock
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No books found.</p>
                        <?php endif; ?>
                    </div>

                    <button class="chevron-btn right" onclick="slideBooks(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                </div>



            </div>

        </div>
    </div>

    <script>
        const ctx = document.getElementById('genreChart').getContext('2d');
        const genreChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($category_labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($category_counts); ?>,
                    backgroundColor: ['#3a0ca3', '#14213d', '#00b4d8', '#6c5b7b', '#9966FF'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });


        const searchInput = document.getElementById('bookSearchInput');
        const books = document.querySelectorAll('.book-card');

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();

            books.forEach(book => {
                const title = book.querySelector('.book-title').textContent.toLowerCase();
                const author = book.querySelector('.book-author').textContent.toLowerCase();
                const matches = title.includes(query) || author.includes(query);

                book.style.display = matches ? 'block' : 'none';
            });
        });

        function slideBooks(direction) {
            const container = document.getElementById('bookListing');
            const card = container.querySelector('.book-card');
            if (!card) return;

            const cardWidth = card.offsetWidth + 16;
            container.scrollBy({
                left: direction * cardWidth,
                behavior: 'smooth'
            });
        }

        const rowsPerPage = 5; // rows per page
        const tbody = document.getElementById('topUsersTbody');
        const rows = tbody.querySelectorAll('tr');
        const totalRows = rows.length;
        let currentPage = 1;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        const prevBtn = document.getElementById('prevPageBtn');
        const nextBtn = document.getElementById('nextPageBtn');

        function showPage(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                if (index >= start && index < end) {
                    row.style.display = '';
                    // Set rank number relative to total list, not just page
                    row.querySelector('.rank-cell').textContent = (index + 1);
                } else {
                    row.style.display = 'none';
                }
            });

            prevBtn.disabled = page === 1;
            nextBtn.disabled = page === totalPages;
        }

        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        });

        // Initialize on page load
        showPage(currentPage);
    </script>

</body>

</html>