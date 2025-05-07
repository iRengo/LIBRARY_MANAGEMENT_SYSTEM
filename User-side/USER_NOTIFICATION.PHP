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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="USER_NOTIFICATION.css">

    <!-- ======= Scripts ====== -->
     
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


</head>

<body>
    <!-- =============== Navigation ================ -->
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
                    <a href="USER_NOTIFICATION.PHP">
                        <span class="icon">
                            <ion-icon name="notifications-outline"></ion-icon>
                        </span>
                        <span class="title">Notifications</span>
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
                        <?php echo date("l, F j, Y h:i:s"); // Full date and time format ?>
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

            <!-- Notifications Section -->
            <div class="notifications-section">
                <h3>Your Notifications</h3>
                <p class="text-muted">Manage, renew and review your books</p>

                <!-- Notification 1 -->
                <div class="notification-box clearfix">
                    <div class="avatar">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/user.png" alt="user">
                    </div>
                    <div class="notification-time">1 min ago</div>
                    <div class="notification-content">
                        <strong>Librarian1</strong>
                        <div>Hi, your book is due soon!</div>
                        <span class="resubmit">Resubmit</span>
                    </div>
                </div>

                <!-- Rejected -->
                <div class="notification-box red clearfix">
                    <div class="avatar">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/user.png" alt="user">
                    </div>
                    <div class="notification-time text-danger"><strong>1 min ago</strong></div>
                    <div class="notification-content">
                        <span class="status">Rejected</span>
                        <div>Hi, I would like to as if you are a real nigga ?</div>
                        <span class="resubmit">Resubmit</span>
                    </div>
                </div>

                <!-- Approved -->
                <div class="notification-box green clearfix">
                    <div class="avatar">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/user.png" alt="user">
                    </div>
                    <div class="notification-time text-success"><strong>1 min ago</strong></div>
                    <div class="notification-content">
                        <span class="status">Approved</span>
                        <div>Hi, I would like to as if you are a real nigga ?</div>
                        <span class="resubmit">Resubmit</span>
                    </div>
                </div>

                <!-- Book Available -->
                <div class="notification-box clearfix">
                    <div class="book-cover">
                        <img src="https://covers.openlibrary.org/b/id/8369256-L.jpg" alt="Book Cover">
                    </div>
                    <div class="notification-time">1 min ago</div>
                    <div class="notification-content">
                        <strong>Book Title is Available !</strong>
                        <div>Hi, I would like to as if you are a real nigga ?</div>
                        <span class="resubmit">Resubmit</span>
                    </div>
                </div>

                <!-- View All -->
                <div class="view-all">
                    <a href="#">View All</a>
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
                        window.location.href = 'logout.php';
                    }
                });
            });
        </script>

        <!-- =========== Scripts =========  -->
        <script src="HEADER-NAVBAR.js"></script>

        <!-- ====== ionicons ======= -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>