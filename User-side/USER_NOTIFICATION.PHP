<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <title> Notifications </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="User_css/ADMIN_STYLES2.CSS">
    <link rel="stylesheet" href="User_css/ADMIN_MODAL.css">
    <link rel="stylesheet" href="User_css/Userr.css">
    <link rel="stylesheet" href="USER_NOTIFICATION2.CSS">


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
                <div class="logo" title="LOGOUT YOUR ACCOUNT" style="margin-right: 1%;">
                    <a href="#" id="logoutIcon">
                        <i class='bx bx-log-in-circle' style="font-size:35px;color:#da1b1b"></i>
                    </a>
                </div>
            </div>

            <!-- Modal Structure -->
            <div id="logoutModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Confirm Logout</h2>
                    <p>Are you sure you want to logout?</p>
                    <div class="modal-actions">
                        <a href="#" class="btn-action btn-yes">Yes</a>
                        <button class="btn-action btn-no" id="cancelLogout">No</button>
                    </div>
                </div>
            </div>

            <!-- Content HERE -->

            <div class="secondmain">
                <div class="col-sm-12">
    <div class="secondmain-container">
        <div class="notif">
            <h4>Notifications</h4>
            <div class="description">
                <h6>Manage, renew, and review your books</h6>
            </div>
        </div>
        <div class="notifications-list">
            <!-- Notification 1 -->
                    <div class="notification-card success">
            <div class="card-header">
                <button class="close-btn">&times;</button>
            </div>
            <div class="card-content">
                <div class="book-image-placeholder">
                    <img src="https://tse1.mm.bing.net/th?id=OIP.m3dSB_jJIuTfk5obG-eQggHaL0&pid=Api&P=0&h=220" alt="Book Cover" style="height: 90px; width: 75px;">
                </div>
                <div class="notification-text">
                    <h5>"The book" was Available</h5>
                    <p>Borrow it now?</p>
                    <div class="action-buttons">
                        <button class="btn btn-primary">Borrow</button>
                    </div>
                </div>
            </div>
            <span class="timestamp">A day ago</span>
        </div>

        <div class="notification-card1 error">
            <div class="card-header">
                <button class="close-btn1">&times;</button>
            </div>
            <div class="card-content">
            <div class="book-image-placeholder">
                    <img src="https://miblart.com/wp-content/uploads/2020/06/photo_2020-06-16_17-55-07.jpg" alt="Book Cover" style="height: 90px; width: 75px;">
                </div>
                <div class="notification-text">
                    <h5>Your Borrow Request was Rejected</h5>
                    <p>Submit form again?</p>
                    <div class="action-buttons">
                        <button class="btn btn-primary">Borrow</button>
                    </div>
                </div>
            </div>
            <span class="timestamp">11/25/2024 11:55 PM</span>
        </div>

        <div class="notification-card2 warning">
            <div class="card-header">
                <button class="close-btn2">&times;</button>
            </div>
            <div class="card-content">
            <div class="book-image-placeholder">
                    <img src="https://miblart.com/wp-content/uploads/2020/10/eYTiC-I4-scaled.jpeg" alt="Book Cover" style="height: 90px; width: 75px;">
                </div>
                <div class="notification-text">
                    <h5>You only have 1 day before your due date on this book</h5>
                    <p>Renew your book?</p>
                    <div class="action-buttons">
                        <button class="btn btn-primary">Renew</button>
                    </div>
                </div>
            </div>
            <span class="timestamp">A day ago</span>
        </div>

        </div>
    </div>
</div>

            </div>
            </div>


         

</div>
        <!-- ========================= Main END ==================== -->
           


<!-- =========== Scripts =========  -->
<script src="User_css/admin.js"></script>
<script src="User_css/ADMIN_MODAL.js"></script>


<!-- ====== ionicons ======= -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</body>

</html>