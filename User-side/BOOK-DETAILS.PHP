<?php
session_start();
include '../homepage/db_connect.php';

$user_id = $_SESSION['acc_no'];
$book_id = $_GET['book_id'];

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

$borrow_blocked = false;
$today = date('Y-m-d' , strtotime('-1 day'));

//dipa ayos to 
// Check if the user has any overdue books
$overdue = "SELECT * FROM borrowed_books 
            WHERE student_no = ? 
            AND status = 'Borrowed' 
            AND due_date > ?";
$check_overdue = $conn->prepare($overdue);
$check_overdue->bind_param("ss", $student_no, $today);
$check_overdue->execute();
$check_overdue_result = $check_overdue->get_result();

if ($check_overdue_result->num_rows > 0) {
    $borrow_blocked = true; // Set to true if there are overdue books
}

$check_overdue->close();



// Check the latest borrow status for the specific book
$borrow_status = null;
$borrow_check_query = "SELECT status FROM borrowed_books 
                       WHERE student_no = ? AND book_id = ? 
                       ORDER BY borrow_id DESC LIMIT 1";
$borrow_check_stmt = $conn->prepare($borrow_check_query);
$borrow_check_stmt->bind_param("ii", $student_no, $book_id);
$borrow_check_stmt->execute();
$borrow_check_result = $borrow_check_stmt->get_result();

if ($borrow_check_row = $borrow_check_result->fetch_assoc()) {
    $borrow_status = $borrow_check_row['status'];
}
$borrow_check_stmt->close();

// Check if the book is already reserved
$book_reserved = false;
$sql_check = "SELECT * FROM reserved_books WHERE book_id = ? AND student_no = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $book['book_id'], $student_no);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
if ($result_check->num_rows > 0) {
    $book_reserved = true;
}
$stmt_check->close();

// Flags for UI logic
$already_borrowed = ($borrow_status === 'Borrowed');
$borrow_pending = ($borrow_status === 'Pending');
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['book_title']); ?> - Book Details</title>
    <link rel="stylesheet" href="book-details.css">

</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP' ?>


    <div class="container1" style="margin-top: 2%;">
        <!-- Left Section (Book Cover) -->
        <div class="book-cover-section">
            <a href="user_catalog.php" style="position: absolute; top: 10px; left: 10px; text-decoration: none; color: inherit; margin-top:8%;margin-left:1.5%;">
                <ion-icon name="arrow-back-outline" style="font-size: 32px;"></ion-icon>
            </a>
            <img src="<?php echo htmlspecialchars($book['book_cover']); ?>" alt="Book Cover" class="book-cover">
            <p class="enlarge-text">Tap to enlarge</p>

            <br> <br>

            <?php if ($borrow_status === 'Approved'): ?>
                <button class="borrow-button borrowed" disabled>
                    Approved, Ready for Pickup
                </button>
            <?php elseif ($already_borrowed): ?>
                <button class="borrow-button blocked" disabled>
                    Already Borrowed
                </button>
            <?php elseif ($borrow_blocked): ?>
                <button class="borrow-button blocked" disabled>
                    Borrow Blocked (Overdue Book Detected)
                </button>
            <?php elseif ($borrow_pending): ?>
                <button class="borrow-button pending" disabled>
                    Borrowing in Process
                </button>
            <?php elseif ($borrow_status === null && $book['book_stocks'] > 0): ?>
                <button class="borrow-button available" id="borrow-btn">
                    Borrow This
                </button>

            <?php elseif ($borrow_status === null && $book['book_stocks'] == 0): ?>
                <?php if (!$book_reserved): ?>
                    <form method="POST" action="book_reserve.php">
                        <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['book_id']); ?>">
                        <input type="hidden" name="book_title" value="<?= htmlspecialchars($book['book_title']); ?>">
                        <input type="hidden" name="author" value="<?= htmlspecialchars($book['book_author']); ?>">
                        <input type="hidden" name="ISBN" value="<?= htmlspecialchars($book['ISBN']); ?>">
                        <input type="hidden" name="acc_no" value="<?= htmlspecialchars($_SESSION['acc_no']); ?>">
                        <input type="hidden" name="student_no" value="<?= htmlspecialchars($student_no); ?>">
                        <input type="hidden" name="first_name" value="<?= htmlspecialchars($first_name); ?>">
                        <input type="hidden" name="last_name" value="<?= htmlspecialchars($last_name); ?>">
                        <input type="hidden" name="email" value="<?= htmlspecialchars($email); ?>">

                        <button type="submit" class="borrow-button reserve">
                            Reserve This
                        </button>
                    </form>
                <?php else: ?>
                    <button class="borrow-button reserved" disabled>
                        Already Reserved
                    </button>
                <?php endif; ?>
            <?php endif; ?>


            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <script>
                    // Show the SweetAlert
                    Swal.fire({
                        title: 'Successfully Reserved!',
                        text: 'We will send you an email once the book is available!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                    // Remove the success=1 from the URL without reloading the page
                    if (window.history.replaceState) {
                        const url = new URL(window.location);
                        url.searchParams.delete('success');
                        window.history.replaceState({}, document.title, url);
                    }
                </script>
            <?php endif; ?>
            <?php if (isset($_GET['cancelled']) && $_GET['cancelled'] == 1): ?>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    Swal.fire({
                        title: "Cancelled",
                        text: "Your borrow request has been cancelled.",
                        icon: "success",
                        confirmButtonText: "OK"
                    });

                    // Remove the cancelled=1 from the URL without reloading
                    if (window.history.replaceState) {
                        const url = new URL(window.location);
                        url.searchParams.delete('cancelled');
                        window.history.replaceState({}, document.title, url);
                    }
                </script>
            <?php endif; ?>

            <br><br>
            <!-- Cancel Borrow Request (only if borrow is pending) -->
            <?php if ($borrow_pending): ?>
                <form method="post" action="cancel_borrow.php" style="display: inline-block; margin-right: 10px;">
                    <input type="hidden" name="student_no" value="<?= htmlspecialchars($student_no) ?>">
                    <input type="hidden" name="book_id" value="<?= htmlspecialchars($book_id) ?>">
                    <button type="submit" class="borrow-button cancel">
                        Cancel Borrow Request
                    </button>
                </form>
            <?php endif; ?>


            <!-- Add to Collection (always visible) -->
            <form method="POST" action="" style="display: inline-block;">
                <input type="hidden" name="book_id" value="<?= $book_id; ?>">
                <button type="submit" name="add_to_collection" class="collection-button">
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

            <div class="borrow-form-section" id="borrow-form">
                <h1 class="book-title"><?= htmlspecialchars($book['book_title']); ?></h1>
                <p class="author">by <strong><?= htmlspecialchars($book['book_author']); ?></strong></p>
                <br>
                <b>BORROWING FORM</b>
                <br> <br>
                <p>Please ensure that all details are correct</p>

                <form method="POST" action="borrow_book.php">
                    <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['book_id']); ?>">
                    <input type="hidden" name="book_title" value="<?= htmlspecialchars($book['book_title']); ?>">

                    <div class="form-group">
                        <div class="input-container">
                            <label>ISBN:</label>
                            <input type="text" name="isbn" value="<?= htmlspecialchars($ISBN); ?>" readonly required>
                        </div>
                        <div class="input-container">
                            <label>Student Number:</label>
                            <input type="text" name="student_no" value="<?= htmlspecialchars($student_no); ?>" readonly required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-container">
                            <label>First Name:</label>
                            <input type="text" name="first_name" value="<?= htmlspecialchars($first_name); ?>" readonly required>
                        </div>
                        <div class="input-container">
                            <label>Last Name:</label>
                            <input type="text" name="last_name" value="<?= htmlspecialchars($last_name); ?>" readonly required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-container">
                            <label>Email:</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($email ?? ''); ?>" readonly required>
                        </div>
                        <div class="input-container">
                            <label>Contact:</label>
                            <input type="text" name="contact" value="<?= htmlspecialchars($contact ?? ''); ?>" readonly required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-container">
                            <label for="preferred_date">Preferred Date</label>
                            <input type="date" id="preferred_date" name="preferred_date" required>
                        </div>
                        <div class="input-container">
                            <label>Borrowing Request ID:</label>
                            <input type="text" name="borrow_id" value="<?= htmlspecialchars($borrow_id ?? 'N/A'); ?>" readonly>
                        </div>
                        <div class="input-container">
                            <label for="due_date">Estimated Due Date</label>
                            <input type="date" id="due_date" name="due_date" readonly required>
                        </div>
                    </div>

                    <div class="button-row">
                        <button type="button" id="cancel-borrow">Cancel</button>
                        <button type="submit" class="submit-button">Submit Request</button>
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
    <script>
        document.getElementById('preferred_date').addEventListener('change', function() {
            let preferredDate = new Date(this.value); // Get the selected date

            // Check if the selected date is a weekend (Saturday or Sunday)
            if (preferredDate.getDay() === 6 || preferredDate.getDay() === 0) {
                Swal.fire({
                    title: 'Weekend Not Allowed!',
                    text: 'The library is closed on weekends. Please select a weekday (Monday to Friday).',
                    icon: 'warning',
                    confirmButtonText: 'Okay'
                });
                this.value = ''; // Clear the selected date
                return;
            }

            let dueDate = new Date(preferredDate); // Make a copy of the selected date
            dueDate.setDate(preferredDate.getDate() + 3); // Add 3 days to the preferred date

            // Ensure the due date is not a weekend (Saturday or Sunday)
            if (dueDate.getDay() === 6) {
                dueDate.setDate(dueDate.getDate() + 2); // If due date falls on Saturday, set to Monday
            } else if (dueDate.getDay() === 0) {
                dueDate.setDate(dueDate.getDate() + 1); // If due date falls on Sunday, set to Monday
            }

            // Format the due date in YYYY-MM-DD format
            let year = dueDate.getFullYear();
            let month = (dueDate.getMonth() + 1).toString().padStart(2, '0');
            let day = dueDate.getDate().toString().padStart(2, '0');

            // Set the due date value
            document.getElementById('due_date').value = `${year}-${month}-${day}`;
        });




        // Function to refresh book details and status every 2 seconds
        function refreshBookDetails() {
            $.ajax({
                url: 'check_borrow_status.php', // PHP file that fetches the updated data
                type: 'GET',
                data: {
                    book_id: <?php echo $book['book_id']; ?>
                }, // Pass the book ID to check the status
                success: function(response) {
                    // Update the book status, buttons, or any other HTML based on the response
                    $('#borrow-form').html(response); // For example, update the borrow-form section
                },
                error: function() {
                    console.log('Error in AJAX request');
                }
            });
        }

        // Call the refresh function every 2 seconds
        setInterval(refreshBookDetails, 2000);
    </script>



</body>

</html>