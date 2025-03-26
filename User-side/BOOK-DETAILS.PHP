<?php
session_start();
include '../homepage/db_connect.php';

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

// Retrieve the admin_no from session
$user_id = $_SESSION['acc_no'];

// Check if book_id is provided
if (!isset($_GET['book_id']) || empty($_GET['book_id'])) {
    echo '<script>
        alert("No book selected.");
        window.location.href = "user_catalog.php";
    </script>';
    exit();
}

$book_id = intval($_GET['book_id']); // Sanitize input

// Fetch book details from the database
$query = "SELECT * FROM tbl_books WHERE book_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $book_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if book exists
if (mysqli_num_rows($result) == 0) {
    echo '<script>
        alert("Book not found.");
        window.location.href = "user_catalog.php";
    </script>';
    exit();
}

$book = mysqli_fetch_assoc($result);

// Fetch related books based on genre, author, and publication year & month
$related_query = "
    SELECT * 
    FROM tbl_books 
    WHERE book_id != ? 
    AND (
        book_genre = ? 
        OR book_author = ? 
        OR (YEAR(publication_date) = ? AND MONTH(publication_date) = ?)
    )
    ORDER BY 
        (book_genre = ?) DESC,       
        (book_author = ?) DESC,      
        publication_date DESC        
    LIMIT 4";

$publication_year = date('Y', strtotime($book['publication_date']));
$publication_month = date('m', strtotime($book['publication_date']));

$related_stmt = mysqli_prepare($conn, $related_query);
mysqli_stmt_bind_param(
    $related_stmt,
    "issiiis",
    $book_id,
    $book['book_genre'],
    $book['book_author'],
    $publication_year,
    $publication_month,
    $book['book_genre'],
    $book['book_author']
);
mysqli_stmt_execute($related_stmt);
$related_result = mysqli_stmt_get_result($related_stmt);

// Fetch like/dislike counts
$likes_query = "SELECT COUNT(*) as likes FROM book_likes_dislikes WHERE book_id = ? AND action = 'like'";
$dislikes_query = "SELECT COUNT(*) as dislikes FROM book_likes_dislikes WHERE book_id = ? AND action = 'dislike'";

$likes_stmt = mysqli_prepare($conn, $likes_query);
mysqli_stmt_bind_param($likes_stmt, "i", $book_id);
mysqli_stmt_execute($likes_stmt);
$likes_result = mysqli_stmt_get_result($likes_stmt);
$likes = mysqli_fetch_assoc($likes_result)['likes'];

$dislikes_stmt = mysqli_prepare($conn, $dislikes_query);
mysqli_stmt_bind_param($dislikes_stmt, "i", $book_id);
mysqli_stmt_execute($dislikes_stmt);
$dislikes_result = mysqli_stmt_get_result($dislikes_stmt);
$dislikes = mysqli_fetch_assoc($dislikes_result)['dislikes'];

// Handle like/dislike actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reaction'])) {
    $reaction = $_POST['reaction'] == 'like' ? 'like' : 'dislike';

    // Check if user already reacted
    $check_query = "SELECT * FROM book_likes_dislikes WHERE acc_no = ? AND book_id = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "ii", $user_id, $book_id);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($check_result) > 0) {
        // Update reaction if already exists
        $update_query = "UPDATE book_likes_dislikes SET action = ?, created_at = NOW() WHERE acc_no = ? AND book_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($update_stmt, "sii", $reaction, $user_id, $book_id);
        mysqli_stmt_execute($update_stmt);
    } else {
        // Insert new reaction
        $insert_query = "INSERT INTO book_likes_dislikes (acc_no, book_id, action, created_at) VALUES (?, ?, ?, NOW())";
        $insert_stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($insert_stmt, "iis", $user_id, $book_id, $reaction);
        mysqli_stmt_execute($insert_stmt);
    }
    header("Location: book-details.php?book_id=$book_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['book_title']); ?> - Book Details</title>
    <link rel="stylesheet" href="book-details.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
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
                <a href="#">
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


        <div class="container1" style="margin-top: 2%;">
            <!-- Left Section (Book Cover) -->
            <div class="book-cover-section">
                <a href="user_catalog.php" style="position: absolute; top: 10px; left: 10px; text-decoration: none; color: inherit; margin-top:8%;margin-left:1.5%;">
                    <ion-icon name="arrow-back-outline" style="font-size: 32px;"></ion-icon>
                </a>
                <img src="<?php echo htmlspecialchars($book['book_cover']); ?>" alt="Book Cover" class="book-cover">
                <p class="enlarge-text">Tap to enlarge</p>
                <!-- Borrow This Button -->
                <button class="btn btn-success mt-3" style="width: 100%;">Borrow This</button>
            </div>

            <!-- Middle Section (Book Info) -->
            <div class="book-info-section">
                <h1 class="book-title"><?php echo htmlspecialchars($book['book_title']); ?> </h1>
                <p class="author">by <strong><?php echo htmlspecialchars($book['book_author']); ?></strong></p>

                <!-- Like and Dislike Buttons -->
                <form method="POST" action="">
                    <div class="reaction-buttons">
                        <!-- Like Button -->
                        <button type="submit" name="reaction" value="like" class="like-btn">
                            <ion-icon name="thumbs-up"></ion-icon> Like
                            <span id="like-count"><?php echo $likes; ?></span>
                        </button>

                        <!-- Dislike Button -->
                        <button type="submit" name="reaction" value="dislike" class="dislike-btn">
                            <ion-icon name="thumbs-down"></ion-icon> Dislike
                            <span id="dislike-count"><?php echo $dislikes; ?></span>
                        </button>
                    </div>
                </form>

                <p class="description">
                    <?php echo nl2br(htmlspecialchars($book['book_description'])); ?>
                    <a href="#" class="read-more">Read More</a>
                </p>

                <table class="book-details-table">
                    <tr>
                        <td><strong>Original Title:</strong></td>
                        <td><?php echo htmlspecialchars($book['book_title']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>ISBN:</strong></td>
                        <td><?php echo htmlspecialchars($book['ISBN']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Edition Language:</strong></td>
                        <td>English</td>
                    </tr>
                    <tr>
                        <td><strong>Publisher:</strong></td>
                        <td><?php echo htmlspecialchars($book['publisher']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Publication Date:</strong></td>
                        <td><?php echo htmlspecialchars($book['publication_date']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Available Stocks:</strong></td>
                        <td><?php echo htmlspecialchars($book['book_stocks']); ?></td>
                    </tr>
                </table>




            </div>

            <!-- Right Section (Related Books) -->
            <div class="related-books-section">
                <h3 style="padding: 10%;">Related Books</h3>
                <div class="related-books-container">
                    <?php while ($related_book = mysqli_fetch_assoc($related_result)) : ?>
                        <div class="related-book" onclick="redirectToBook(<?php echo $related_book['book_id']; ?>)">
                            <img src="<?php echo htmlspecialchars($related_book['book_cover']); ?>" alt="Book Cover">
                            <p>
                                <?php echo htmlspecialchars($related_book['book_title']); ?><br>
                                <em><?php echo htmlspecialchars($related_book['book_author']); ?></em>
                            </p>
                        </div>
                    <?php endwhile; ?>
                </div>

            </div>


        </div>
        <script>
            document.getElementById('logoutIcon').addEventListener('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will be logged out of your account.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, logout!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'LOGOUT.php';
                    }
                });
            });
        </script>
        <script>
            // Redirect function to open new book details
            function redirectToBook(bookId) {
                window.location.href = 'book-details.php?book_id=' + bookId;
            }
        </script>


        <!-- ====== ionicons ======= -->
        <script src="HEADER-NAVBAR.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>