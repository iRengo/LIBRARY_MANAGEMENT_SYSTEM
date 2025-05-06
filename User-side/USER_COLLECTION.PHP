<?php
// Include database connection
include '../homepage/db_connect.php';
session_start(); // Start session to access logged-in user data

// Ensure user is logged in
if (!isset($_SESSION['acc_no'])) {
    die("Access Denied. Please log in.");
}

$acc_no = $_SESSION['acc_no']; // Get logged-in user's acc_no

// Fetch books from collection_books table for the logged-in user, ordered by newest first
$query = "SELECT * FROM collection_books WHERE acc_no = ? ORDER BY added_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $acc_no);
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
            <title> USER COLLECTION</title>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
            <!-- ======= Styles ====== -->
            <link rel="stylesheet" href="USER_STYLE2.CSS">
            <link rel="stylesheet" href="User_css/ADMIN_MODAL.css">
            <link rel="stylesheet" href="USER_COLLECTION.CSS">

            <!-- ======= Scripts ====== -->


            <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
            <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        </head>
        <style>



        </style>
        <body>
           <?php include 'HEADER-NAVBAR.PHP' ?>
                    <br><br><br><br><br><br><br><br>
                        <div class="container mt-4">
                <!-- My Collections Section -->
                <h1 class="mb-4" style="margin-left: 50px;">My Collections</h1>
                    <div style="position: absolute; top: 15px; right: 200px; display: flex; align-items: center;">
                        <label for="searchBy" style="margin-right: 8px; font-weight: bold;">Search By:</label>
                        <select id="searchBy" class="form-select" style="width: 150px;" aria-label="Select Options">
                            <option selected>Select Date</option>
                            <option value="1">September</option>
                            <option value="2">October</option>
                            <option value="3">December</option>
                        </select>
                    </div>
                <br>
              <!-- Left and Right Panel Section -->
<?php if ($topBook): ?>
<div class="row mt-5" id="top-book">
    <!-- Left Panel: Title, Description, Genre -->
    <div class="col-md-6">
        <h2 id="top-title"><?= $topBook['book_title'] ?></h2>
        <p><strong>Description:</strong> <span id="top-description"><?= $topBook['description'] ?></span></p>
        <p>2005 • 18+ • Romance • 13 chp</p>

        <div class="btn-group" role="group">
            <a href="BOOK_BORROW.php" class="btn btn-borrow">Borrow</a>
            <a id="top-remove" href="remove_book.php?collection_id=<?= $topBook['collection_id'] ?>" 
               class="btn btn-sneakpeek">Remove</a>
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



                <!-- ========================= Main END ==================== -->
                <script>
function moveToTop(clickedBook) {
    document.getElementById("top-title").innerText = clickedBook.getAttribute("data-title");
    document.getElementById("top-description").innerText = clickedBook.getAttribute("data-description");
    document.getElementById("top-image").src = clickedBook.getAttribute("data-image");
    document.getElementById("top-remove").href = clickedBook.getAttribute("data-remove-link"); // ✅ Update Remove link
}
</script>
            

                <!-- =========== Scripts =========  -->
                <script src="User_css/admin.js"></script>
                <script src="User_css/ADMIN_MODAL.js"></script>

                <!-- ====== ionicons ======= -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

                <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
                <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

        </body>

        </html>