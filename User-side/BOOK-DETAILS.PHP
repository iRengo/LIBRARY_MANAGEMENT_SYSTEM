<?php
session_start();
include '../homepage/db_connect.php';

// Ensure student is logged in
if (!isset($_SESSION['acc_no'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        window.onload = function() {
            Swal.fire({
                title: "You are not logged in!",
                text: "Please log in to continue.",
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

$user_id = $_SESSION['acc_no'];

if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']); // Clear the message after displaying
}

// Initialize variables to avoid undefined warnings
$first_name = $last_name = $student_no = $book_title = $book_author = $ISBN = "";
$borrow_date = date("Y-m-d"); // Set borrow date to today
$due_date = date("Y-m-d", strtotime("+3 day")); // Set due date to tomorrow

// Get student details based on logged-in user
if (isset($_SESSION['acc_no'])) {
    $acc_no = $_SESSION['acc_no'];
    $student_query = "SELECT first_name, last_name, student_no, email, contact FROM stud_acc WHERE acc_no = ?";
    $student_stmt = $conn->prepare($student_query);
    $student_stmt->bind_param("s", $acc_no);
    $student_stmt->execute();
    $student_result = $student_stmt->get_result();

    if ($student = $student_result->fetch_assoc()) {
        $first_name = $student['first_name'];
        $last_name = $student['last_name'];
        $student_no = $student['student_no'];
        $email = $student['email'];
        $contact = $student['contact'];
    }
}

// Get book details based on selected book
if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    $book_query = "SELECT book_title, book_author, ISBN FROM tbl_books WHERE book_id = ?";
    $book_stmt = $conn->prepare($book_query);
    $book_stmt->bind_param("i", $book_id);
    $book_stmt->execute();
    $book_result = $book_stmt->get_result();

    if ($book = $book_result->fetch_assoc()) {
        $book_title = $book['book_title'];
        $book_author = $book['book_author'];
        $ISBN = $book['ISBN'];
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_collection'])) {
    $book_id = $_POST['book_id'];
    $user_id = $_SESSION['acc_no']; // Ensure user is logged in

    // Check if already in collection
    $check_query = "SELECT * FROM collection_books WHERE acc_no = ? AND book_id = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $book_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Book already in your collection!');</script>";
    } else {
        // Fetch book details
        $book_query = "SELECT book_title, book_author, book_cover, book_description FROM tbl_books WHERE book_id = ?";
        $stmt = mysqli_prepare($conn, $book_query);
        mysqli_stmt_bind_param($stmt, "i", $book_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($book = mysqli_fetch_assoc($result)) {
            $book_title = $book['book_title'];
            $author = $book['book_author'];
            $image_path = $book['book_cover'];
            $description = $book['book_description'];

            // Insert into collection
            $insert_query = "INSERT INTO collection_books (acc_no, book_id, book_title, author, image_path, added_at, description) 
                             VALUES (?, ?, ?, ?, ?, NOW(), ?)";
            $stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($stmt, "iissss", $user_id, $book_id, $book_title, $author, $image_path, $description);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Book added successfully!');</script>";
            } else {
                echo "<script>alert('Error adding book: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Book not found!');</script>";
        }
    }
}

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

$liked_query = "SELECT action FROM book_likes_dislikes WHERE acc_no = ? AND book_id = ?";
$liked_stmt = mysqli_prepare($conn, $liked_query);
mysqli_stmt_bind_param($liked_stmt, "ii", $user_id, $book_id);
mysqli_stmt_execute($liked_stmt);
$liked_result = mysqli_stmt_get_result($liked_stmt);
$user_reaction = mysqli_fetch_assoc($liked_result)['action'] ?? null; // Fetch user reaction

$like_class = ($user_reaction === 'like') ? 'liked' : ''; // Add class if liked
$like_text = ($user_reaction === 'like') ? 'Liked' : 'Like'; // Change text if liked
// Handle like/dislike actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reaction'])) {
    $reaction = 'like'; // We only handle 'like' in this case

    // Check if user already liked the book
    $check_query = "SELECT action FROM book_likes_dislikes WHERE acc_no = ? AND book_id = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "ii", $user_id, $book_id);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    $existing_reaction = mysqli_fetch_assoc($check_result)['action'] ?? null;

    if ($existing_reaction === 'like') {
        // Unlike (Remove from table)
        $delete_query = "DELETE FROM book_likes_dislikes WHERE acc_no = ? AND book_id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($delete_stmt, "ii", $user_id, $book_id);
        mysqli_stmt_execute($delete_stmt);
    } else {
        // Insert new like
        $insert_query = "INSERT INTO book_likes_dislikes (acc_no, book_id, action, created_at) VALUES (?, ?, ?, NOW())";
        $insert_stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($insert_stmt, "iis", $user_id, $book_id, $reaction);
        mysqli_stmt_execute($insert_stmt);
    }

    header("Location: book-details.php?book_id=$book_id");
    exit();
}
// Initialize $borrow_status to avoid undefined warnings
$borrow_status = null;

// Check if the user has borrowed the book before
$borrow_check_query = "SELECT status FROM borrowed_books WHERE student_no = ? AND book_id = ? LIMIT 1";
$borrow_check_stmt = mysqli_prepare($conn, $borrow_check_query);
mysqli_stmt_bind_param($borrow_check_stmt, "si", $student_no, $book_id);
mysqli_stmt_execute($borrow_check_stmt);
$borrow_check_result = mysqli_stmt_get_result($borrow_check_stmt);

if ($borrow_check_row = mysqli_fetch_assoc($borrow_check_result)) {
    $borrow_status = $borrow_check_row['status']; // Assign status if found
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

    <!-- Custom Modal Styling -->
    <style>
        /* Light-Themed Modal */
        .custom-modal {
            background: #ffffff;
            /* Light background */
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.4s ease-in-out;
            padding: 20px;
        }

        /* Modal Header */
        .modal-header {
            border-bottom: none;
            text-align: center;
            position: relative;
        }

        /* Borrow Button */
        .borrow-btn {
            background: linear-gradient(45deg, #ffafbd, #ffc3a0);
            border: none;
            color: white;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 30px;
            transition: all 0.3s ease-in-out;
        }

        .borrow-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(255, 172, 193, 0.8);
        }

        /* Custom Submit Button */
        .btn-custom {
            background: linear-gradient(45deg, rgba(5, 93, 165, 0.45), rgb(5, 93, 165));
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            border-radius: 25px;
            transition: all 0.3s ease-in-out;
        }

        .btn-custom:hover {
            background: linear-gradient(45deg, rgb(30, 159, 223), rgb(5, 113, 255));
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(132, 250, 176, 0.8);
        }

        /* Modal Fade In Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Input Field Styling */
        .form-control {
            background: #f8f9fa;
            border: 1px solid #ced4da;
            color: #495057;
        }

        .form-control:focus {
            background: #ffffff;
            border-color: #80bdff;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
            color: rgb(22, 22, 22);
        }

        /* Labels */
        .form-label {
            font-weight: 600;
            color: #333;
        }
    </style>
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



                <?php if ($borrow_status === 'Accepted'): ?>
                    <button class="btn btn-secondary mt-3" style="width: 100%; background-color:#E6E6E6;color:black;border:none;" disabled>
                        Already Borrowed
                    </button>
                <?php elseif ($borrow_status === 'Pending'): ?>
                    <button class="btn btn-info mt-3" style="width: 100%;" disabled>
                        Borrowing on Process
                    </button>
                <?php elseif ($borrow_status === null && $book['book_stocks'] > 0): ?>
                    <button class="btn btn-success mt-3" style="width: 100%;background-color:#5897EE;border:none;" id="borrow-btn">
                        Borrow This
                    </button>
                <?php elseif ($borrow_status === null && $book['book_stocks'] == 0): ?>
                    <button class="btn btn-warning mt-3" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#reserveModal">
                        Reserve This
                    </button>
                <?php endif; ?>



                <!-- Add to Collection Button -->
                <form method="POST" action="">
                    <input type="hidden" name="book_id" value="<?= $book_id; ?>">
                    <button type="submit" name="add_to_collection" class="btn mt-3" style="width: 100%; background-color:rgb(66, 75, 136); color: white;">
                        <i class="fas fa-bookmark"></i> Add to Collection
                    </button>
                </form>
            </div>


            <!-- Book Info and Borrow Form Wrapper -->
            <div id="content-wrapper">
                <!-- Middle Section (Book Info) -->
                <div class="book-info-section" id="book-info">
                    <h1 class="book-title"><?php echo htmlspecialchars($book['book_title']); ?> </h1>
                    <p class="author">by <strong><?php echo htmlspecialchars($book['book_author']); ?></strong></p>

                    <form method="POST" action="">
                        <div class="reaction-buttons">
                            <!-- Like Button -->
                            <button type="submit" name="reaction" value="like" class="like-btn <?php echo $like_class; ?>">
                                <ion-icon name="thumbs-up"></ion-icon>
                                <span id="like-text"><?php echo $like_text; ?></span>
                                <span id="like-count"><?php echo $likes; ?></span>
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

                <!-- Borrow Form (Initially Hidden) -->
                <div class="borrow-form-section" id="borrow-form" style="display: none;">
                    <h1 class="book-title"><?php echo htmlspecialchars($book['book_title']); ?> </h1>
                    <p class="author">by <strong><?php echo htmlspecialchars($book['book_author']); ?></strong></p>

                    <br><br>
                    <b style="background-color: black;color:white;padding:10px; font-size:20px;"> BORROWING FORM </b> <Br>
                    <Br>
                    <p style="color: gray;"> Please ensure that all details are correct </p>

                    <form method="POST" action="borrow_book.php">
                        <br>
                        <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['book_id']); ?>">
                        <input type="hidden" name="book_title" value="<?= htmlspecialchars($book['book_title']); ?>">

                        <div class="form-group">
                            <div class="input-container">
                                <label>ISBN:</label>
                                <input type="text" name="isbn" class="form-control underline-input" value="<?php echo htmlspecialchars($ISBN); ?>" readonly required>
                                <input type="hidden" name="isbn" value="<?php echo htmlspecialchars($ISBN); ?>">
                            </div>
                            <div class="input-container">
                                <label>Student Number:</label>
                                <input type="text" name="student_no" class="form-control underline-input" value="<?php echo htmlspecialchars($student_no); ?>" readonly required>
                                <input type="hidden" name="student_no" value="<?php echo htmlspecialchars($student_no); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-container">
                                <label>First Name:</label>
                                <input type="text" name="first_name" class="form-control underline-input" value="<?php echo htmlspecialchars($first_name); ?>" readonly required>
                                <input type="hidden" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>">
                            </div>
                            <div class="input-container">
                                <label>Last Name:</label>
                                <input type="text" name="last_name" class="form-control underline-input" value="<?php echo htmlspecialchars($last_name); ?>" readonly required>
                                <input type="hidden" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-container">
                                <label>Email:</label>
                                <input type="email" name="email" class="form-control underline-input" value="<?php echo htmlspecialchars($email ?? ''); ?>" readonly required>
                                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>">
                            </div>
                            <div class="input-container">
                                <label>Contact:</label>
                                <input type="text" name="contact" class="form-control underline-input" value="<?php echo htmlspecialchars($contact ?? ''); ?>" readonly required>
                                <input type="hidden" name="contact" value="<?php echo htmlspecialchars($contact ?? ''); ?>">
                            </div>
                        </div>
                        <Br><BR>
                        <div class="form-group" style="justify-content: center;">
                            <div class="input-container" style="width: 200px;">
                                <label>Preferred Pickup Date:</label>
                                <input type="date" name="preferred_date" class="form-control underline-input" required>
                            </div>
                            <div class="input-container" style="width: 200px;">
                                <label>Borrowing Request ID:</label>
                                <input type="text" name="borrow_id" class="form-control underline-input" value="<?php echo htmlspecialchars($borrow_id ?? 'N/A'); ?>" readonly>
                                <input type="hidden" name="borrow_id" value="<?php echo htmlspecialchars($borrow_id ?? ''); ?>">
                            </div>
                        </div>

                        <br><br>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="button" class="btn btn-secondary px-4" id="cancel-borrow">Cancel</button>
                            <button type="submit" class="btn btn-primary px-4">Submit Request</button>
                        </div>
                    </form>



                </div>




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
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".btn-borrow").forEach(button => {
                    button.addEventListener("click", function() {
                        let bookTitle = document.getElementById("top-title").innerText;
                        let bookAuthor = ""; // Set author dynamically if available
                        let bookISBN = ""; // Set ISBN dynamically if available

                        document.getElementById("bookTitle").value = bookTitle;
                        document.getElementById("author").value = bookAuthor;
                        document.getElementById("isbn").value = bookISBN;
                    });
                });
            });
        </script>
        <script>
            // Redirect function to open new book details
            function redirectToBook(bookId) {
                window.location.href = 'book-details.php?book_id=' + bookId;
            }
        </script>

        <script>
            document.getElementById("borrow-btn").addEventListener("click", function() {
                document.getElementById("book-info").style.display = "none";
                document.getElementById("borrow-form").style.display = "block";
            });

            document.getElementById("cancel-borrow").addEventListener("click", function() {
                document.getElementById("borrow-form").style.display = "none";
                document.getElementById("book-info").style.display = "block";
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const borrowBtn = document.getElementById("borrow-btn"); // "Borrow This" button
                const reserveBtn = document.querySelector("[data-bs-target='#reserveModal']"); // "Reserve This" button
                const addToCollectionBtn = document.querySelector("button[name='add_to_collection']"); // "Add to Collection" button
                const borrowForm = document.getElementById("borrow-form"); // Borrow form section
                const cancelBtn = document.getElementById("cancel-borrow"); // Cancel button in borrow form

                if (borrowBtn) {
                    borrowBtn.addEventListener("click", function() {
                        // Hide the buttons
                        borrowBtn.style.display = "none";
                        if (reserveBtn) reserveBtn.style.display = "none";
                        if (addToCollectionBtn) addToCollectionBtn.style.display = "none";

                        // Show the borrow form
                        borrowForm.style.display = "block";
                    });
                }

                if (cancelBtn) {
                    cancelBtn.addEventListener("click", function() {
                        // Show the buttons again
                        borrowBtn.style.display = "block";
                        if (reserveBtn) reserveBtn.style.display = "block";
                        if (addToCollectionBtn) addToCollectionBtn.style.display = "block";

                        // Hide the borrow form
                        borrowForm.style.display = "none";
                    });
                }
            });
        </script>


        <!-- ====== ionicons ======= -->
        <script src="HEADER-NAVBAR.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>