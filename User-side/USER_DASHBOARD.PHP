<?php
session_start();
include '../homepage/db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['acc_no'])) {
    die("Access Denied. Please log in.");
}

$acc_no = $_SESSION['acc_no']; // Get logged-in user's account number
$login_time = date("Y-m-d H:i:s");

// Update the last_login column
$stmt = $conn->prepare("UPDATE stud_acc SET last_logged_in = ? WHERE acc_no = ?");
$stmt->bind_param("si", $login_time, $acc_no);
$stmt->execute();

// Fetch Borrowed Count (Including both Pending and Borrowed statuses)
$stmt = $conn->prepare("SELECT COUNT(*) FROM borrowed_books WHERE acc_no = ? AND (status = 'borrowed' OR status = 'Pending')");
$stmt->bind_param("i", $acc_no);
$stmt->execute();
$stmt->bind_result($borrowed_count);
$stmt->fetch();
$stmt->close();

// Fetch Reserved Count
$stmt = $conn->prepare("SELECT COUNT(*) FROM reserved_books WHERE acc_no = ? AND status = 'reserved'");
$stmt->bind_param("i", $acc_no);
$stmt->execute();
$stmt->bind_result($reserved_count);
$stmt->fetch();
$stmt->close();

// Fetch Overdue Count
$stmt = $conn->prepare("SELECT COUNT(*) FROM borrowed_books WHERE acc_no = ? AND due_date < NOW() AND status = 'borrowed'");
$stmt->bind_param("i", $acc_no);
$stmt->execute();
$stmt->bind_result($overdue_count);
$stmt->fetch();
$stmt->close();

// Fetch Due Books Count
$stmt = $conn->prepare("SELECT COUNT(*) FROM borrowed_books WHERE acc_no = ? AND due_date = CURDATE() AND status = 'borrowed'");
$stmt->bind_param("i", $acc_no);
$stmt->execute();
$stmt->bind_result($due_count);
$stmt->fetch();
$stmt->close();

// Fetch Top Books Ranking (Most Liked & Borrowed This Week)
$query = "
   SELECT b.book_id, b.book_title, b.book_author, 
       ( 
           COUNT(CASE WHEN l.action = 'like' THEN 1 END) + 
           COUNT(rb.book_id) 
       ) AS total_count
   FROM tbl_books b
   LEFT JOIN book_likes_dislikes l ON b.book_id = l.book_id
   LEFT JOIN reserved_books rb ON b.book_id = rb.book_id
   GROUP BY b.book_id, b.book_author
   HAVING total_count > 0
   ORDER BY total_count DESC
   LIMIT 10";
$result = $conn->query($query);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <title> Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="USER_STYLE2.CSS">
    <link rel="stylesheet" href="User_css/ADMIN_MODAL.css">
    <link rel="stylesheet" href="USER_DASHBOARD.css">



    <!-- ======= Scripts ====== -->


    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        /* Basic modal styling */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    padding-top: 50px;
}

.modal-content {
    background-color: white;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 25px;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
    </style>

</head>

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
                    <a href="USER_CATALOG.PHP">
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
                <div class="logo" title="LOGOUT YOUR ACCOUNT" style="margin-right:1%; display: flex; align-items: center;">
                    <a href="#" id="logoutIcon" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                        <p style="margin: 0; font-size: 18px; margin-right: 8px;">LOGOUT</p>
                        <i class='bx bx-log-in-circle' style="font-size:35px; color:#da1b1b;"></i>
                    </a>
                </div>
            </div>

          <!-- Content Grid with Clickable Function -->
<div class="content-grid">
    <div class="content-item" data-status="due" onclick="showBooks('due')">
        <ion-icon name="calendar-outline" style="font-size: 50px; color: #4CAF50;"></ion-icon>
        <div class="content-text">
            <p>DUE DATE</p>
            <h1><?= $due_count ?></h1>
        </div>
    </div>

    <div class="content-item" data-status="borrowed" onclick="showBooks('borrowed')">
        <ion-icon name="book-outline" style="font-size: 50px; color: #2196F3;"></ion-icon>
        <div class="content-text">
            <p>Borrowed</p>
            <h1><?= $borrowed_count ?></h1>
        </div>
    </div>

    <div class="content-item" data-status="overdue" onclick="showBooks('overdue')">
        <ion-icon name="alert-circle-outline" style="font-size: 50px; color: #FF5722;"></ion-icon>
        <div class="content-text">
            <p>Overdue</p>
            <h1><?= $overdue_count ?></h1>
        </div>
    </div>

    <div class="content-item" data-status="reserved" onclick="showBooks('reserved')">
        <ion-icon name="bookmark-outline" style="font-size: 50px; color: #FFC107;"></ion-icon>
        <div class="content-text">
            <p>Reserved</p>
            <h1><?= $reserved_count ?></h1>
        </div>
    </div>
</div>

       <!-- Modal for Showing Book Details -->
<div class="modal" id="bookModal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 class="modal-title">📚 Book Details</h2>
        <div id="bookDetails">
            <!-- Book details will be dynamically inserted here -->
        </div>
    </div>
</div>






            <!-- Table Section -->
            <div class="table-container">
                <!-- Table Header -->
                <h2 class="table-header">TOP BOOKS RANKING</h2>

                <!-- Table -->
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo "<div class='alert alert-info'>" . $_SESSION['message'] . "</div>";
                            unset($_SESSION['message']); // Clear message after displaying
                        }
                        ?>


                        <?php
                        if ($result->num_rows > 0) {
                            $rank = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>{$rank}</td>
                                <td>{$row['book_title']}</td>
                                <td>{$row['book_author']}</td>
                                <td class='action-column'>
                                    <a href='BOOK-DETAILS.PHP?book_id=" . $row['book_id'] . "' class='btn view-btn'
                                        style='background-color: #007BFF; color: #fff; border: none; padding: 6px 12px; 
                                        font-size: 14px; font-weight: bold; border-radius: 5px; cursor: pointer; 
                                        transition: all 0.3s ease-in-out; text-decoration: none;'
                                        onmouseover=\"this.style.backgroundColor='#0056b3'; this.style.transform='scale(1.05)';\"
                                        onmouseout=\"this.style.backgroundColor='#007BFF'; this.style.transform='scale(1)';\">
                                        View
                                    </a>
                        
                                    <form method='post' action='add_to_collection.php' style='display:inline;'>
                                        <input type='hidden' name='book_id' value='" . $row['book_id'] . "'>
                                        <button type='submit' class='btn btn-collection' 
                                            style='background-color:rgb(95, 183, 95); color: #fff; border: none; padding: 6px 12px; 
                                                font-size: 14px; font-weight: bold; border-radius: 5px; cursor: pointer; 
                                                transition: all 0.3s ease-in-out;'
                                            onmouseover=\"this.style.backgroundColor='#4DA04D'; this.style.transform='scale(1.05)';\"
                                            onmouseout=\"this.style.backgroundColor='rgb(95, 183, 95)'; this.style.transform='scale(1)';\">
                                            Add to Collection
                                        </button>
                                    </form>
                                </td>
                              </tr>";
                        

                                $rank++;
                            }
                        } else {
                            echo "<tr><td colspan='4'>No data available this week.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Book Container Section -->
            <div class="book-header">Upcoming Books </div> <!-- Moved outside book-container -->
            <div class="book-container" id="upcomingBooksContainer">


                <!-- Book 1 -->
                <div class="book">
                    <img src="book-covers/gatsby.jpg" alt="Book Cover" class="book-cover">
                    <div class="book-info">
                        <h3 class="book-title">The Great Gatsby</h3>
                        <p class="book-author">by F. Scott Fitzgerald</p>
                        <div class="genre-btn action">Action</div>
                        <div class="genre-btn fiction">Fiction</div>
                    </div>
                </div>

                <!-- Book 2 -->
                <div class="book">
                    <img src="book-covers/mockingbird.jpg" alt="Book Cover" class="book-cover">
                    <div class="book-info">
                        <h3 class="book-title">To Kill a Mockingbird</h3>
                        <p class="book-author">by Harper Lee</p>
                        <div class="genre-btn drama">Drama</div>
                        <div class="genre-btn historical">Historical</div>
                    </div>
                </div>

                <!-- Book 3 -->
                <div class="book">
                    <img src="book-covers/1984.jpg" alt="Book Cover" class="book-cover">
                    <div class="book-info">
                        <h3 class="book-title">1984</h3>
                        <p class="book-author">by George Orwell</p>
                        <div class="genre-btn dystopia">Dystopia</div>
                    </div>
                </div>

                <!-- Book 4 -->
                <div class="book">
                    <img src="book-covers/pride.jpg" alt="Book Cover" class="book-cover">
                    <div class="book-info">
                        <h3 class="book-title">Pride and Prejudice</h3>
                        <p class="book-author">by Jane Austen</p>
                        <div class="genre-btn romance">Romance</div>
                    </div>
                </div>

                <!-- Book 5 -->
                <div class="book">
                    <img src="book-covers/moby.jpg" alt="Book Cover" class="book-cover">
                    <div class="book-info">
                        <h3 class="book-title">Moby-Dick</h3>
                        <p class="book-author">by Herman Melville</p>
                        <div class="genre-btn adventure">Adventure</div>
                    </div>
                </div>

                <!-- Book 6 -->
                <div class="book">
                    <img src="book-covers/war.jpg" alt="Book Cover" class="book-cover">
                    <div class="book-info">
                        <h3 class="book-title">War and Peace</h3>
                        <p class="book-author">by Leo Tolstoy</p>
                        <div class="genre-btn historical">Historical</div>
                    </div>
                </div>
            </div>

            <!-- Recommended Books-->
            <Div class="recommended-header">
                <h2> Recommended Books </h2>
            </Div>

            <div class="recommended-books-container" id="recommendedBooksContainer">
                <div class="recommended-books">
                    <div class="recommended-book">
                        <img src="book-covers/gatsby.jpg" alt="Book Cover" class="recommended-book-cover">
                        <div class="recommended-book-info">
                            <h3 class="recommended-book-title">The Great Gatsby</h3>
                            <p class="recommended-book-author">by F. Scott Fitzgerald</p>
                            <p class="recommended-book-genre action">Action</p>
                        </div>
                    </div>
                    <div class="recommended-book">
                        <img src="book-covers/mockingbird.jpg" alt="Book Cover" class="recommended-book-cover">
                        <div class="recommended-book-info">
                            <h3 class="recommended-book-title">To Kill a Mockingbird</h3>
                            <p class="recommended-book-author">by Harper Lee</p>
                            <p class="recommended-book-genre action">Action</p>
                        </div>
                    </div>
                    <div class="recommended-book">
                        <img src="book-covers/1984.jpg" alt="Book Cover" class="recommended-book-cover">
                        <div class="recommended-book-info">
                            <h3 class="recommended-book-title">1984</h3>
                            <p class="recommended-book-author">by George Orwell</p>
                            <p class="recommended-book-genre dystopia">Action</p>
                        </div>
                    </div>
                    <div class="recommended-book">
                        <img src="book-covers/gatsby.jpg" alt="Book Cover" class="recommended-book-cover">
                        <div class="recommended-book-info">
                            <h3 class="recommended-book-title">The Great Gatsby</h3>
                            <p class="recommended-book-author">by F. Scott Fitzgerald</p>
                            <p class="recommended-book-genre historical">Action</p>
                        </div>
                    </div>
                    <div class="recommended-book">
                        <img src="book-covers/mockingbird.jpg" alt="Book Cover" class="recommended-book-cover">
                        <div class="recommended-book-info">
                            <h3 class="recommended-book-title">To Kill a Mockingbird</h3>
                            <p class="recommended-book-author">by Harper Lee</p>
                            <p class="recommended-book-genre drama">Action</p>
                        </div>
                    </div>
                    <div class="recommended-book">
                        <img src="book-covers/1984.jpg" alt="Book Cover" class="recommended-book-cover">
                        <div class="recommended-book-info">
                            <h3 class="recommended-book-title">1984</h3>
                            <p class="recommended-book-author">by George Orwell</p>
                            <p class="recommended-book-genre adventure">Action</p>
                        </div>
                    </div>
                    <div class="recommended-book">
                        <img src="book-covers/gatsby.jpg" alt="Book Cover" class="recommended-book-cover">
                        <div class="recommended-book-info">
                            <h3 class="recommended-book-title">The Great Gatsby</h3>
                            <p class="recommended-book-author">by F. Scott Fitzgerald</p>
                            <p class="recommended-book-genre action">Action</p>
                        </div>
                    </div>
                    <div class="recommended-book">
                        <img src="book-covers/mockingbird.jpg" alt="Book Cover" class="recommended-book-cover">
                        <div class="recommended-book-info">
                            <h3 class="recommended-book-title">To Kill a Mockingbird</h3>
                            <p class="recommended-book-author">by Harper Lee</p>
                            <p class="recommended-book-genre action">Action</p>
                        </div>
                    </div>
                    <div class="recommended-book">
                        <img src="book-covers/1984.jpg" alt="Book Cover" class="recommended-book-cover">
                        <div class="recommended-book-info">
                            <h3 class="recommended-book-title">1984</h3>
                            <p class="recommended-book-author">by George Orwell</p>
                            <p class="recommended-book-genre action">Action</p>
                        </div>
                    </div>

                    <!-- Add more recommended books here -->
                </div>
            </div>

            <div id="bookModal" style="display:none; position:fixed; top:20%; left:50%; transform:translate(-50%, 0); background:white; padding:20px; box-shadow:0px 4px 6px rgba(0,0,0,0.1);">
                <h2 id="modal-title"></h2>
                <div id="modal-content"></div>
                <button onclick="document.getElementById('bookModal').style.display='none'">Close</button>
            </div>














            <!-- ========================= Main END ==================== -->

            <div id="logoutModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Confirm Logout</h2>
                    <p>Are you sure you want to logout?</p>
                    <div class="modal-actions">
                        <a href="../Homepage/signin.php" class="btn-action btn-yes">Yes</a>
                        <button class="btn-action btn-no" id="cancelLogout">No</button>
                    </div>
                </div>
            </div>

                            
    <script>
       function showBooks(status) {
    // Example of sending an AJAX request to fetch book details
    let url = "fetch_books.php"; // PHP file that fetches the data
    let data = { status: status };

    // Send an AJAX request to get books data based on status
    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        // Populate the modal with the book details
        let bookDetailsContainer = document.getElementById('bookDetails');
        bookDetailsContainer.innerHTML = ''; // Clear previous details

        if (data.length > 0) {
            data.forEach(book => {
                let bookDetail = document.createElement('div');
                bookDetail.classList.add('book-detail');
                bookDetail.innerHTML = `
                    <h3>${book.book_title}</h3>
                    <p><strong>Author:</strong> ${book.author}</p>
                    <p><strong>Status:</strong> ${book.status}</p>
                    <p><strong>Borrow Date:</strong> ${book.borrow_date || 'N/A'}</p>
                    
                `;
                bookDetailsContainer.appendChild(bookDetail);
            });
        } else {
            bookDetailsContainer.innerHTML = '<p>No books found.</p>';
        }

        // Show the modal
        document.getElementById('bookModal').style.display = 'block';
    })
    .catch(error => {
        console.error('Error fetching book data:', error);
    });
}

function closeModal() {
    // Close the modal when the close button is clicked
    document.getElementById('bookModal').style.display = 'none';
}
    </script>
                          


            <!-- =========== Scripts =========  -->
            <script src="User_css/admin.js"></script>
            <script src="User_css/ADMIN_MODAL.js"></script>


            <!-- ====== ionicons ======= -->
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
            <!-- Bootstrap CSS -->

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>