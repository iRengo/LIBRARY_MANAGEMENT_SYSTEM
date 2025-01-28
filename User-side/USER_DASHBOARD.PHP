<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <a href="#">
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

            <!-- content here -->
            <div class="content-grid">
                <!-- Due Date -->
                <div class="content-item">
                    <ion-icon name="calendar-outline" style="font-size: 50px; color: #4CAF50;"></ion-icon>
                    <div class="content-text">
                        <p>DUE DATE</p>
                        <h1>12</h1>
                    </div>
                </div>

                <!-- Borrowed -->
                <div class="content-item">
                    <ion-icon name="book-outline" style="font-size: 50px; color: #2196F3;"></ion-icon>
                    <div class="content-text">
                        <p>Borrowed</p>
                        <h1>23</h1>
                    </div>
                </div>

                <!-- Overdue -->
                <div class="content-item">
                    <ion-icon name="alert-circle-outline" style="font-size: 50px; color: #FF5722;"></ion-icon>
                    <div class="content-text">
                        <p>Overdue</p>
                        <h1>2</h1>
                    </div>
                </div>

                <!-- Reserved -->
                <div class="content-item">
                    <ion-icon name="bookmark-outline" style="font-size: 50px; color: #FFC107;"></ion-icon>
                    <div class="content-text">
                        <p>Reserved</p>
                        <h1>7</h1>
                    </div>
                </div>
            </div>
            <!-- content here END -->

            <!-- Table Section -->
            <div class="table-container">
                <!-- Table Header -->
                <h2 class="table-header">TOP BOOKS RANKING (THIS WEEK)</h2>

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
                        <!-- Example Rows -->
                        <tr>
                            <td>1</td>
                            <td>The Great Gatsby</td>
                            <td>F. Scott Fitzgerald</td>
                            <td class="action-column">
                                <button class="btn view-btn">View</button>
                                <button class="btn add-btn">Add</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>To Kill a Mockingbird</td>
                            <td>Harper Lee</td>
                            <td class="action-column">
                                <button class="btn view-btn">View</button>
                                <button class="btn add-btn">Add</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>1984</td>
                            <td>George Orwell</td>
                            <td class="action-column">
                                <button class="btn view-btn">View</button>
                                <button class="btn add-btn">Add</button>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Pride and Prejudice</td>
                            <td>Jane Austen</td>
                            <td class="action-column">
                                <button class="btn view-btn">View</button>
                                <button class="btn add-btn">Add</button>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>The Catcher in the Rye</td>
                            <td>J.D. Salinger</td>
                            <td class="action-column">
                                <button class="btn view-btn">View</button>
                                <button class="btn add-btn">Add</button>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Moby-Dick</td>
                            <td>Herman Melville</td>
                            <td class="action-column">
                                <button class="btn view-btn">View</button>
                                <button class="btn add-btn">Add</button>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>War and Peace</td>
                            <td>Leo Tolstoy</td>
                            <td class="action-column">
                                <button class="btn view-btn">View</button>
                                <button class="btn add-btn">Add</button>
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Crime and Punishment</td>
                            <td>Fyodor Dostoevsky</td>
                            <td class="action-column">
                                <button class="btn view-btn">View</button>
                                <button class="btn add-btn">Add</button>
                            </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Brave New World</td>
                            <td>Aldous Huxley</td>
                            <td class="action-column">
                                <button class="btn view-btn">View</button>
                                <button class="btn add-btn">Add</button>
                            </td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>The Odyssey</td>
                            <td>Homer</td>
                            <td class="action-column">
                                <button class="btn view-btn">View</button>
                                <button class="btn add-btn">Add</button>
                            </td>
                        </tr>
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


            <!-- =========== Scripts =========  -->
            <script src="User_css/admin.js"></script>
            <script src="User_css/ADMIN_MODAL.js"></script>


            <!-- ====== ionicons ======= -->
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>