<?php
// Include database connection
include '../homepage/db_connect.php';
session_start(); // Start session to access logged-in user data

// Check if the admin session exists
if (!isset($_SESSION['acc_no'])) {
    // If not, show a SweetAlert notification and then redirect
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    window.onload = function() {
        // Show SweetAlert notification
        Swal.fire({
            title: "You are not logged in!",
            text: "Please log in to access the page.",
            icon: "error",
            confirmButtonText: "OK",
            allowOutsideClick: false,
            allowEscapeKey: false,
            willClose: () => {
                // Redirect to homepage after the notification is closed
                window.location.href = "../homepage/homepage.php";
            }
        });
    }
    </script>';
    exit(); // Stop further execution after showing the notification and redirect script
}

$acc_no = $_SESSION['acc_no']; // Get logged-in user's acc_no

// Get the selected month (if any)
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : '';

$query = "SELECT cb.*, b.book_stocks, b.book_category, b.book_author 
          FROM collection_books cb 
          JOIN tbl_books b ON cb.book_id = b.book_id 
          WHERE cb.acc_no = ?";

// Add month filter if a month is selected
if ($selectedMonth) {
    $query .= " AND MONTH(cb.added_at) = ? AND YEAR(cb.added_at) = YEAR(CURDATE())";  // Filter by current year
}

// Order by newest first
$query .= " ORDER BY cb.added_at DESC";

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

// Fetch all books into array
$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

// Separate top book and recent books
if (count($books) > 0) {
    $topBook = $books[0];
    $recentBooks = array_slice($books, 1);
} else {
    $topBook = null;
    $recentBooks = [];
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../logosample1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <title>User Collection</title>
    <style>
        /* Add your styles here */
        .empty-collection-container {
            text-align: center;
            margin-top: 50px;
        }
        .browse-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #47423F;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .book-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            padding: 0 50px 30px;
        }
        .book-card {
            cursor: pointer;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: box-shadow 0.3s ease;
        }
        .book-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .book-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }
        .btn-reserve {
            background-color: #FFA500 !important; /* Yellow/Orange */
            color: white !important;
            padding: 10px 20px !important;
            border-radius: 5px !important;
            text-align: center !important;
            text-decoration: none !important;
            display: inline-block !important;
            font-weight: bold !important;
        }

        .btn-reserve:hover {
            background-color: #cc8400 !important; /* Darker yellow/orange */
        }

        .category-badge {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 5px;
            font-size: 15px;
            color: #fff;
            font-weight: bold;
            margin-top: 6px;
            text-transform: capitalize;
        }

        /* Sample category background colors */
        .category-badge.fiction {
            background-color: #FF9800;
        }

        .category-badge.action {
            background-color: #4CAF50;
        }

        .category-badge.historical {
            background-color: #FFC107;
        }

        .category-badge.scifi {
            background-color: #9C27B0;
        }

        .category-badge.poetry {
            background-color: #E91E63;
        }
    </style>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="USER_STYLE2.CSS">
    <link rel="stylesheet" href="User_css/ADMIN_MODAL.css">
    <link rel="stylesheet" href="USER_COLLECTION.CSS">
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
        <div class="col-md-6">
            <h2 id="top-title"><?= htmlspecialchars($topBook['book_title']) ?></h2>
            <p><strong>Description:</strong> <span id="top-description"><?= htmlspecialchars($topBook['description']) ?></span></p>
            <p>
                <span id="top-author"><?= htmlspecialchars($topBook['book_author']) ?></span> • 
                <span id="top-category"><?= htmlspecialchars($topBook['book_category']) ?></span> • 
                13 chp
            </p>

            <div class="btn-group" role="group">
                <?php if ($topBook['book_stocks'] > 0): ?>
                    <a id="top-borrow" href="BOOK-DETAILS.php?book_id=<?= $topBook['book_id'] ?>" class="btn btn-borrow">Borrow</a>
                <?php else: ?>
                    <a id="top-borrow" href="BOOK-DETAILS.php?book_id=<?= $topBook['book_id'] ?>" class="btn btn-reserve">Reserve</a>
                <?php endif; ?>
                
                <a id="top-remove" href="remove_book.php?collection_id=<?= $topBook['collection_id'] ?>" class="btn btn-sneakpeek">Remove</a>
            </div>


        </div>

        <div class="col-md-6">
            <img id="top-image" src="<?= htmlspecialchars(str_replace(' ', '%20', $topBook['image_path'])) ?>" class="img-fluid" alt="Book Cover">
        </div>
    </div>

    <br>

    <div class="container">
    <h1 style="margin-left: 50px;">RECENTLY ADDED</h1>
    <div class="book-grid">
        <?php foreach ($recentBooks as $row): ?>
            <div class="book-card"
                data-title="<?= htmlspecialchars($row['book_title']) ?>"
                data-description="<?= htmlspecialchars($row['description']) ?>"
                data-image="<?= htmlspecialchars(str_replace(' ', '%20', $row['image_path'])) ?>"
                data-remove-link="remove_book.php?collection_id=<?= $row['collection_id'] ?>"
                data-book-id="<?= $row['book_id'] ?>"
                data-book-stocks="<?= $row['book_stocks'] ?>"
                data-author="<?= htmlspecialchars($row['book_author']) ?>"
                data-category="<?= htmlspecialchars($row['book_category']) ?>"
                onclick="moveToTop(this)">

                <img src="<?= htmlspecialchars(str_replace(' ', '%20', $row['image_path'])) ?>" alt="<?= htmlspecialchars($row['book_title']) ?>">
                
                <div class="info">
                    <h3><?= htmlspecialchars($row['book_title']) ?></h3>
                    <p><?= htmlspecialchars($row['book_author']) ?></p>

                <div class="category-badge <?= strtolower($row['book_category']) ?>">
                    <?= htmlspecialchars($row['book_category']) ?>
                </div>


                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

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

    const bookId = clickedBook.getAttribute("data-book-id");
    const bookStocks = parseInt(clickedBook.getAttribute("data-book-stocks"));
    const bookAuthor = clickedBook.getAttribute("data-author");
    const bookCategory = clickedBook.getAttribute("data-category");

    // Update author and category dynamically
    document.getElementById("top-author").innerText = bookAuthor;
    document.getElementById("top-category").innerText = bookCategory;

    const topBorrowBtn = document.getElementById("top-borrow");
    topBorrowBtn.href = "BOOK-DETAILS.php?book_id=" + bookId;

    if (bookStocks > 0) {
        topBorrowBtn.textContent = "Borrow";
        topBorrowBtn.className = "btn btn-borrow";
    } else {
        topBorrowBtn.textContent = "Reserve";
        topBorrowBtn.className = "btn btn-reserve";
    }
}

</script>

    <!-- External JS -->
    <script src="User_css/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
