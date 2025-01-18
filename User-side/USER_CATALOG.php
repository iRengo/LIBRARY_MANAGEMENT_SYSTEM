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
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="USER_STYLE2.CSS">
    <link rel="stylesheet" href="User_css/ADMIN_MODAL.css">
    <link rel="stylesheet" href="USER_CATALOG.CSS">

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

            <!-- Content HERE -->

            <div class="titles-container">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="titles">
                <div class="available">Available Books</div>
                 <div class="col-md-4">
            <div class="search-bar">
                <input type="text" class="form-control" placeholder="Search books...">
            </div>
        </div>
            </div>
        </div>
        
    </div>
</div>
            <div class="row">
                <div class="col-sm-2">
                    <div class="categ">
                        <div class="texts">Fantasy</div>
                    <div class="pics" id="books">
                    <img src="https://www.creativindiecovers.com/wp-content/uploads/2012/02/9780718155209.jpg"> 
                    <img src="https://thebookcoverdesigner.com/wp-content/uploads/2020/01/TH00102.jpg"> 
                    <img src="https://www.creativindiecovers.com/wp-content/uploads/2012/02/9780718155209.jpg"> 
                    <img src="https://www.creativindiecovers.com/wp-content/uploads/2012/02/9780718155209.jpg"> 
                    <img src="https://www.creativindiecovers.com/wp-content/uploads/2012/02/9780718155209.jpg"> 
                    <img src="https://www.creativindiecovers.com/wp-content/uploads/2012/02/9780718155209.jpg">      
                    </div>
                    <div class="categ">
                    <div class="texts">Fantasy</div>
                    <div class="pics" id="books">
                    <img src="https://www.dochipo.com/wp-content/uploads/2022/08/Book-Cover-_-Romance-scaled.jpg"> 
                    <img src="https://www.dochipo.com/wp-content/uploads/2022/08/Book-Cover-_-Romance-scaled.jpg"> 
                    <img src="https://www.dochipo.com/wp-content/uploads/2022/08/Book-Cover-_-Romance-scaled.jpg"> 
                    <img src="https://www.dochipo.com/wp-content/uploads/2022/08/Book-Cover-_-Romance-scaled.jpg">     
                    <img src="https://www.dochipo.com/wp-content/uploads/2022/08/Book-Cover-_-Romance-scaled.jpg"> 
                    <img src="https://www.dochipo.com/wp-content/uploads/2022/08/Book-Cover-_-Romance-scaled.jpg"> 
                    </div>
                    </div>
                    </div>
                </div>
            </div>



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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>