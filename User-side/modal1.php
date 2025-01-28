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
    <link rel="stylesheet" href="modal.css">

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
                    <a href="#!">
                        <span class="icon">
                            <ion-icon name="file-tray-stacked-outline"></ion-icon>
                        </span>
                        <span class="title">Collection</span>
                    </a>
                </li>

                <li>
                    <a href="#!">
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
                        <?php echo date("l, F j, Y h:i:s"); ?>
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
            </div>
            <!-- Back Button -->
            <div class="back">
                <a href="javascript:history.back()" class="btn btn-back">
                    <ion-icon name="arrow-back-outline" class="me-2"></ion-icon>
                    Back
                </a>
            </div>
            

            <!-- Left and Right Panel Section -->
            <div class="row mt-5">
                <!-- Left Panel: Title, Description, Genre -->
                <div class="col-md-6">
                    <h2>My Last Kiss</h2>
                    <p><strong>Description:</strong> Every moment tells a story, and every story has a heartbeat. This space captures the essence of shared dreams, cherished memories, and the beauty of a journey woven together with love, laughter, and endless possibilities.</p>
                         <!-- New Text Added Below Description -->
                    <p>2018 • 18+ • Romance • 8 chp</p>

                    <div class="btn-group" role="group">
                        <a href="#borrow" class="btn btn-borrow">Borrow</a>
                        <a href="#sneakpeek" class="btn btn-sneakpeek">Sneak Peek</a>
                    </div>

                </div>

                <!-- Right Panel: Image -->
                <div class="col-md-6">
                    <img src="https://ph.bbwbooks.com/cdn/shop/products/9780374351281_1_347413de-9f1c-468a-89b3-f0b2c0e408e0_600x.jpg?v=1625489251" class="img-fluid" alt="Book Cover">
                </div>
            </div>
            <!-- ========================= Suggested Books ==================== -->
<div class="suggested-books mt-5">
    <h3>Suggested Books</h3>
    <div class="row">
        < class="col-md-2">
            <img src=https://www.creativindiecovers.com/wp-content/uploads/2012/02/9780718155209.jpg" class="img-fluid" alt="Suggested Book 1">
        </div>
        <div class="col-md-2">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRU--MXPOfwwWTvR9vCB2UkzeiBeX9ZkGayag&s" class="img-fluid" alt="Suggested Book 2">
        </div>
        <div class="col-md-2">
            <img src=https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKYmrUbkRM3aWolsdDNGGUz9mgkcWlYTZyMY6yRBCbNknziBqxaeyCTBsmgYa1p86AHxg&usqp=CAU" class="img-fluid" alt="Suggested Book 3">
        </div>
        <div class="col-md-2">
            <img src="https://lbabooks.com/assets/books/_small/411NFkiBKwL-1.jpg" class="img-fluid" alt="Suggested Book 4">
        </div>
        <div class="col-md-2">
            <img src="https://lbabooks.com/assets/books/_small/Before-We-Say-Goodbye-cover.jpg" class="img-fluid" alt="Suggested Book 5">
        </div>
        <div class="col-md-2">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRU--MXPOfwwWTvR9vCB2UkzeiBeX9ZkGayag&s" class="img-fluid" alt="Suggested Book 5">
        </div>
    </div>
</div>
        </div>
    </div>

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
