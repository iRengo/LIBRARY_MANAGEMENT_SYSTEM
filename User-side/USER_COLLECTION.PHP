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


h1 {
    text-align: left;
    font-size: 24px;
    margin-bottom: 20px;
}

.book-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); /* Slightly increased */
    gap: 20px;
    margin-left: 15px;
}

.book-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    padding: 10px; /* Added slight padding */
}
.book-card:hover {
    transform: scale(1.05); /* Slight zoom */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3); /* More pronounced shadow */
}

.book-card img {
    width: 100%; /* Makes sure it scales with the card */
    height: 220px; /* Increased the height slightly */
    object-fit: cover; /* Keeps aspect ratio */
    display: block;
}

.book-card .info {
    padding: 15px;
}

.book-card .info h3 {
    font-size: 18px; /* Slightly bigger text */
    margin: 0;
    margin-bottom: 5px;
}

.book-card .info p {
    font-size: 14px;
    color: #555;
    margin: 0;
    margin-bottom: 10px;
}
.book-card .colors {
    display: flex;
    gap: 5px;
}

.color-box {
    width: 15px;
    height: 15px;
    border-radius: 3px;
}

.color-red {
    background-color: #d32f2f;
}

.color-purple {
    background-color: #7b1fa2;
}

.color-blue {
    background-color: #1976d2;
}
            .collection-card {
                position: relative;
                background: url('../Guest-side/Book/neuromancer.jpg') no-repeat center center/cover;
                height: 300px;
                width: 98%;
                margin: 0 auto;
                color: white;
                border-radius: 8px;
                overflow: hidden;
            }
            .collection-card::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: inherit; /* Use the same background image */
                filter: blur(8px); /* Blur effect */
                transform: scale(1.1); /* Slightly scale up to hide edges caused by blur */
                z-index: 1;
            }
            .collection-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.7);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                z-index: 2; /* Place overlay on top of the blur */
            }

            .lock-icon {
                font-size: 5rem; /* Increased icon size */
                margin-bottom: 1.5rem; /* Adjust spacing */
            }

            .collection-overlay button {
                font-size: 1.2rem; /* Larger font size for the button text */
                padding: 0.75rem 1.5rem; /* Increased padding */
                border-radius: 0.5rem; /* Slightly rounded corners */
                font-weight: bold; /* Make the text bold */
            }

            .collection-overlay button:hover {
                background-color: #004085; /* Darker shade for hover effect */
            }

            .samples-grid img {
                height: 200px;
                object-fit: cover;
                border-radius: 5px;
            }
        </style>
        <body>
            <!-- =============== Navigation ================ -->
            <div class="container">
                <div class="navigation">
                    <ul>
                        <li>
                            <div class="admin-gradient">
                                <a href="#">
                                    <span class="icon">
                                        <ion-icon name="person-circle" class="admin-icon"></ion-icon>
                                    </span>
                                    <span class="title1">USER</span>
                                </a>
                            </div>
                        </li>
                <li>
                        <a href="USER_DASHBOARD.PHP">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                <a href="USER_COLLECTION.PHP">
                        <span class="icon">
                            <ion-icon name="file-tray-stacked-outline"></ion-icon>

                        </span>
                        <span class="title">Collection</span>
                    </a>
                </li>

                <li>
                    <a href="USER_CATALOG.php">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Catalog</span>
                    </a>
                </li>

                <li>
                <a href="USER_HISTORY.PHP">
                        <span class="icon">
                            <i class='bx bx-history' style="font-size:35px;"></i>
                        </span>
                        <span class="title">History</span>
                    </a>
                </li>

                <li>
                    <a href="USER_HELP&SUPPORT.PHP">
                        <span class="icon">
                            <ion-icon name="layers-outline"></ion-icon>
                        </span>
                        <span class="title">Help & Support</span>
                    </a>
                </li>

                <li>
                    <a href="USER_NOTIFICATION.PHP">
                        <span class="icon">
                            <ion-icon name="notifications-outline"></ion-icon>
                        </span>
                        <span class="title">Notifications</span>
                    </a>
                </li>
                <li>
                    <a href="USER_TRENDING.php">
                        <span class="icon">
                            <ion-icon name="trending-up-outline"></ion-icon>
                        </span>
                        <span class="title">Trending</span>
                    </a>
                </li>
                <li>
                    <a href="USER_SETTINGS.php">
                        <span class="icon">
                            <ion-icon name="cog-outline"></ion-icon>
                        </span>
                        <span class="title">Settings</span>
                    </a>
                </li>
                        <div class="time-container" style="width: 150%;">
                            <p style="font-size: 10px; color:white;">
                                <?php echo date("l, F j, Y h:i:s"); // Full date and time format 
                                ?>
                            </p>
                        </div>
                    </ul>

                </div>


                <!-- ========================= Main ==================== -->
                <div class="main">
                    <div class="topbar">
                        <div class="toggle">
                            <ion-icon name="menu-outline"></ion-icon>
                        </div>
                        <div class="logo">
                            <img src="../logosample1.png" style="height: 60px; width:60px; padding:4px;">
                        </div>
                        <div style="float:left; margin-right:75%; display: flex; align-items: baseline;">
                            <p style="font-family: viga; margin: 0; padding-right:2px;">LIBRA</p>
                            <p style="font-family: zilla slab highlight; letter-spacing: 2px; margin: 0;">SPHERE</p>
                        </div>
                        <div class="logo" title="LOGOUT YOUR ACCOUNT" style="margin-right: 1%; display: flex; align-items: center;">
                            <a href="#" id="logoutIcon" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                                <p style="margin: 0; font-size: 18px; margin-right: 8px;">LOGOUT</p>
                                <i class='bx bx-log-in-circle' style="font-size:35px; color:#da1b1b;"></i>
                            </a>
                        </div>
                    </div>
                    <br>
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
<div class="row mt-5">
    <!-- Left Panel: Title, Description, Genre -->
    <div class="col-md-6">
        <?php if ($row = $result->fetch_assoc()): // Fetch the most recent book ?>
            <h2><?= $row['book_title'] ?></h2>
            <p><strong>Description:</strong> <?= $row['description'] ?></p>
            <p>2005 • 18+ • Romance • 13 chp</p>

            <div class="btn-group" role="group">
    <a href="BOOK_BORROW.php" class="btn btn-borrow">Borrow</a>
    <a href="remove_book.php?collection_id=<?= isset($row['collection_id']) ? $row['collection_id'] : '' ?>" 
       class="btn btn-sneakpeek">Remove</a>
</div>

    </div>

    <!-- Right Panel: Image -->
    <div class="col-md-6">
        <img src="<?= str_replace(' ', '%20', $row['image_path']) ?>" class="img-fluid" alt="Book Cover">
    </div>
</div>
<?php endif; ?>

<br>

<div class="container">
    <h1 style="margin-left: 50px;">RECENTLY ADDED</h1>
    <div class="book-grid">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="book-card">
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



                <!-- =========== Scripts =========  -->
                <script src="User_css/admin.js"></script>
                <script src="User_css/ADMIN_MODAL.js"></script>

                <!-- ====== ionicons ======= -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

                <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
                <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

        </body>

        </html>