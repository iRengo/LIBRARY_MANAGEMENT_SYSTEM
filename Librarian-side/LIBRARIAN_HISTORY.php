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
    <link rel="stylesheet" href="LIBRARIAN_HISTORY.css">

  

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
                            <span class="title1">LIBRARIAN</span>
                        </a>
                    </div>
                </li>

                <li>
                    <a href="LIBRARIAN_DASHBOARD.PHP">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
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
                    <a href="LIBRARIAN_HISTORY.php">
                        <span class="icon">
                            <i class='bx bx-history' style="font-size:35px;"></i>
                        </span>
                        <span class="title">History</span>
                    </a>
                </li>

                <li>
                    <a href="LIBRARIAN_RESERVATION.PHP">
                        <span class="icon">
                            <ion-icon name="person-add-outline" style="font-size: 30px;"></ion-icon>
                        </span>
                        <span class="title">Reservations</span>
                    </a>
                </li>

                <li>
                    <a href="LIBRARIAN_NOTIFICATION.PHP">
                        <span class="icon">
                            <ion-icon name="notifications-outline"></ion-icon>
                        </span>
                        <span class="title">Notifications</span>
                    </a>
                </li>

                <li>
                    <a href="USER_NOTIFICATION.PHP">
                        <span class="icon">
                            <ion-icon name="file-tray-stacked-outline"></ion-icon>
                        </span>
                        <span class="title">User Management</span>
                    </a>
                </li>
                <li>
                    <a href="LIBRARIAN_REPORTS.php">
                        <span class="icon">
                            <ion-icon name="trending-up-outline"></ion-icon>
                        </span>
                        <span class="title">Reports</span>
                    </a>
                </li>
                <li>
                    <a href="LIBRARIAN_SETTINGS.PHP">
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
            <a href="" id="logoutIcon" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                <p style="margin: 0; font-size: 18px; margin-right: 8px;">LOGOUT</p>
                <i class='bx bx-log-in-circle' style="font-size:35px; color:#da1b1b;"></i>
            </a>
        </div>
    </div>

            <!-- Content Section -->
            <div class="content-container">
                <h2>MY ACTIVITIES</h2>
                <div class="button-container">
                    <a href="#approved-content" class="action-button">Approved</a>
                    <a href="#rejected-content" class="action-button">Rejected</a>
                    <a href="#actions-content" class="action-button">Actions</a>
                </div>

                <!-- Content for Each Button -->
            <div id="approved-content" class="content-box">
                <h2>APPROVED NOTIFICATIONS</h2>
                <!-- Notifications under the heading but separate -->
                <div class="notif-margins">
                    <div class="notification gray-background">
                        <p>YOU APPROVED USER ID : 213021320 BORROW FORM</p>
                        <span class="notification-time">11/24/2024 11:55 PM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>LIBRARIAN 1 APPROVED USER ID APPLICATION</p>
                        <span class="notification-time">11/23/2024 10:45 AM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>YOU APPROVED USER ID : 765432189 BOOK RETURN</p>
                        <span class="notification-time">11/22/2024 9:30 PM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>LIBRARIAN 2 APPROVED USER ID : 908765431 BORROW REQUEST</p>
                        <span class="notification-time">11/21/2024 2:15 PM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>YOU APPROVED USER ID : 112233445 RESERVATION REQUEST</p>
                        <span class="notification-time">11/20/2024 1:00 PM</span>
                    </div>
                </div>
            </div>

            <div id="rejected-content" class="content-box">
                <h2>REJECTED NOTIFICATIONS</h2>
                <div class="notif-margins">
                    <div class="notification gray-background">
                        <p>YOU REJECTED USER ID : 213021320 BORROW FORM</p>
                        <span class="notification-time">11/19/2024 3:40 PM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>YOU REJECTED USER ID : 213021320 BORROW FORM</p>
                        <span class="notification-time">11/18/2024 11:25 AM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>YOU REJECTED USER ID : 192837465 BORROW FORM</p>
                        <span class="notification-time">11/17/2024 5:15 PM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>YOU REJECTED USER ID : 564738291 BORROW FORM</p>
                        <span class="notification-time">11/16/2024 9:00 AM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>YOU REJECTED USER ID : 987654321 BORROW FORM</p>
                        <span class="notification-time">11/15/2024 7:30 PM</span>
                    </div>
                </div>
            </div>

            <div id="actions-content" class="content-box">
                <h2>ACTIONS NOTIFICATIONS</h2>
                <div class="notif-margins">
                    <div class="notification gray-background">
                        <p>USER : 2132131231 FINE HAS BEEN PAID</p>
                        <span class="notification-time">11/14/2024 4:45 PM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>USER : 2321032121 FINE HAS BEEN PAID</p>
                        <span class="notification-time">11/13/2024 6:25 AM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>USER : 3423524232 FINE HAS BEEN PAID</p>
                        <span class="notification-time">11/12/2024 3:15 PM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>USER : 4235435362 FINE HAS BEEN PAID</p>
                        <span class="notification-time">11/11/2024 10:30 AM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>USER : 5346546473 FINE HAS BEEN PAID</p>
                        <span class="notification-time">11/10/2024 8:10 PM</span>
                    </div>
                </div>
            </div>


        

            <!-- Content HERE -->

        </div>


        <!-- ========================= Main END ==================== -->



        <!-- =========== Scripts =========  -->
        <script src="/User-side/USER.JS"></script>
        <script>
            // Add event listener to all action buttons
document.querySelectorAll('.action-button').forEach(button => {
    button.addEventListener('click', function() {
        // Remove the 'active' class from all buttons
        document.querySelectorAll('.action-button').forEach(btn => btn.classList.remove('active'));
        
        // Add the 'active' class to the clicked button
        this.classList.add('active');
    });
});
        </script>




        <!-- ====== ionicons ======= -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>