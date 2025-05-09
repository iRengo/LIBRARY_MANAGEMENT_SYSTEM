<?php
// Include database connection
include '../homepage/db_connect.php';
session_start(); // Start session to access logged-in user data

// Ensure user is logged in
if (!isset($_SESSION['acc_no'])) {
    die("Access Denied. Please log in.");
}

$acc_no = $_SESSION['acc_no']; // Get logged-in user's acc_no

// Get the selected month (if any)
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : '';

// Initialize query
$query = "SELECT * FROM collection_books WHERE acc_no = ?";

// Add month filter if a month is selected
if ($selectedMonth) {
    $query .= " AND MONTH(added_at) = ? AND YEAR(added_at) = YEAR(CURDATE())";  // Filter by current year
}

// Order by newest first
$query .= " ORDER BY added_at DESC";

// Prepare the query
$stmt = $conn->prepare($query);

// Bind the parameters
if ($selectedMonth) {
    $stmt->bind_param("ii", $acc_no, $selectedMonth);
} else {
    $stmt->bind_param("i", $acc_no);
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch the first book separately
$topBook = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <title>USER COLLECTION</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="USER_STYLE2.CSS">
    <link rel="stylesheet" href="User_css/ADMIN_MODAL.css">
    <link rel="stylesheet" href="USER_COLLECTION2.CSS">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<?php include 'HEADER-NAVBAR.PHP' ?>
<br><br>
  <div class="row align-items-center mb-2">
    <div class="col-md-6 col-12">
      <h1 class="collection-header">My Collections</h1>
    </div>

    <div class="col-md-6 col-12 text-md-end">
    <form method="GET" action="" class="d-inline-flex align-items-center">
        <label for="searchBy" class="me-3 fw-bold text-light">Search By:</label>
        <select name="month" id="searchBy" class="form-select w-auto custom-select" onchange="this.form.submit()">
            <option value="">Select Month</option>
            <option value="1" <?= isset($_GET['month']) && $_GET['month'] == 1 ? 'selected' : ''; ?>>January</option>
            <option value="2" <?= isset($_GET['month']) && $_GET['month'] == 2 ? 'selected' : ''; ?>>February</option>
            <option value="3" <?= isset($_GET['month']) && $_GET['month'] == 3 ? 'selected' : ''; ?>>March</option>
            <option value="4" <?= isset($_GET['month']) && $_GET['month'] == 4 ? 'selected' : ''; ?>>April</option>
            <option value="5" <?= isset($_GET['month']) && $_GET['month'] == 5 ? 'selected' : ''; ?>>May</option>
            <option value="6" <?= isset($_GET['month']) && $_GET['month'] == 6 ? 'selected' : ''; ?>>June</option>
            <option value="7" <?= isset($_GET['month']) && $_GET['month'] == 7 ? 'selected' : ''; ?>>July</option>
            <option value="8" <?= isset($_GET['month']) && $_GET['month'] == 8 ? 'selected' : ''; ?>>August</option>
            <option value="9" <?= isset($_GET['month']) && $_GET['month'] == 9 ? 'selected' : ''; ?>>September</option>
            <option value="10" <?= isset($_GET['month']) && $_GET['month'] == 10 ? 'selected' : ''; ?>>October</option>
            <option value="11" <?= isset($_GET['month']) && $_GET['month'] == 11 ? 'selected' : ''; ?>>November</option>
            <option value="12" <?= isset($_GET['month']) && $_GET['month'] == 12 ? 'selected' : ''; ?>>December</option>
        </select>
    </form>
</div>

</div>


    <br>

    <!-- Left and Right Panel Section -->
    <?php if (!$topBook): ?>
    <div class="empty-collection-container">
        <img src="https://i.pinimg.com/474x/3d/0c/26/3d0c261faadf525bcc4a738899b07bb8.jpg" alt="No Books">
        <h3>Your collection is empty</h3>
        <p>You haven’t added any books to your collection yet. Start exploring and add your favorites here!</p>
        <a href="USER_CATALOG.php" class="browse-button">Browse Books</a>
    </div>
    <?php else: ?>
    <div class="row mt-5" id="top-book">
        <!-- Left Panel: Title, Description, Genre -->
        <div class="col-md-6">
            <h2 id="top-title"><?= $topBook['book_title'] ?></h2>
            <p><strong>Description:</strong> <span id="top-description"><?= $topBook['description'] ?></span></p>
            <p>2005 • 18+ • Romance • 13 chp</p>

            <div class="btn-group" role="group">
                <a href="BOOK_BORROW.php" class="btn btn-borrow">Borrow</a>
                <a id="top-remove" href="remove_book.php?collection_id=<?= $topBook['collection_id'] ?>" class="btn btn-sneakpeek">Remove</a>
            </div>
        </div>

        <!-- Right Panel: Image -->
        <div class="col-md-6">
            <img id="top-image" src="<?= str_replace(' ', '%20', $topBook['image_path']) ?>" class="img-fluid" alt="Book Cover">
        </div>
    </div>
    <?php endif; ?>

    <br>

    <!-- Recently Added Section -->
    <div class="container">
        <h1 style="margin-left: 50px;">RECENTLY ADDED</h1>
        <div class="book-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="book-card"
                 data-title="<?= $row['book_title'] ?>"
                 data-description="<?= $row['description'] ?>"
                 data-image="<?= str_replace(' ', '%20', $row['image_path']) ?>"
                 data-remove-link="remove_book.php?collection_id=<?= $row['collection_id'] ?>"
                 onclick="moveToTop(this)">
                <img src="<?= str_replace(' ', '%20', $row['image_path']) ?>" alt="<?= $row['book_title'] ?>">
                <div class="info">
                    <h3><?= $row['book_title'] ?></h3>
                    <p><?= $row['author'] ?></p>
                    <div class="colors">
                        <div class="color-box color-purple"></div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php
    // Close the database connection
    $conn->close();
    ?>

    <!-- Logout Modal -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Confirm Logout</h2>
            <p>Are you sure you want to logout?</p>
            <div class="modal-actions">
                <a href="../Homepage/HOMEPAGE.PHP" class="btn-action btn-yes">Yes</a>
                <button class="btn-action btn-no" id="cancelLogout">No</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function moveToTop(clickedBook) {
            document.getElementById("top-title").innerText = clickedBook.getAttribute("data-title");
            document.getElementById("top-description").innerText = clickedBook.getAttribute("data-description");
            document.getElementById("top-image").src = clickedBook.getAttribute("data-image");
            document.getElementById("top-remove").href = clickedBook.getAttribute("data-remove-link");
        }
    </script>

    <!-- External JS -->
    <script src="User_css/admin.js"></script>
    <script src="User_css/ADMIN_MODAL.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
