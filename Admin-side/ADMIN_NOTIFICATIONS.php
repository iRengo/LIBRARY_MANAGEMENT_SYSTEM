<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <title> Admin Notifications</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="ADMIN_NOTIFICATIONS.css">


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
                        <span class="title1">ANGELO MHYR</span>
                    </a>
                    </div>
                </li>

                <li>
                    <a href="#">
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
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Users</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Staff Tools</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="notifications-outline"></ion-icon>
                        </span>
                        <span class="title">Notifications</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
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
             <!-- Notification Section -->
             <h2 style="margin-left: 50px; margin-top: 80px; font-family: Arial, sans-serif; color:rgb(32, 32, 32);">Notifications</h2>

                    <!-- Notification 1 -->
                    <div style="background-color:rgb(97, 104, 112); border-radius: 10px; box-shadow: 0px 10px 5px rgba(0, 0, 0, 0.15); padding:20px; margin-bottom:30px; margin-left:70px; margin-right:70px; margin-top: 30px; display: flex; align-items: center; position: relative; font-family: Arial, sans-serif;">
                        <img src="the return.jpg" alt="Notification Image" style="width: 100px; height: 140px; border-radius: 5px; margin-right: 15px;">
                        <div style="margin-bottom: 50px;">
                            <h3 style="font-size: 20px;">New Book Added</h3>
                            <p style="font-size: 16px;">A new book titled "The Return of the king, The Lord of the Rings" has been added to the catalog.</p>
                        </div>
                        <!-- Close button -->
                        <button style="position: absolute; top: 0px; right: 10px; background-color: transparent; border: none; color: white; font-size: 30px; cursor: pointer;" onclick="this.parentElement.style.display='none';">×</button>
                    </div>

                    <!-- Notification 2 -->
                    <div style="background-color:rgb(121, 130, 139); border-radius: 10px; box-shadow: 0px 10px 5px rgba(0, 0, 0, 0.15); padding:20px; margin-bottom:30px; margin-left:70px; margin-right:70px; display: flex; align-items: center; position: relative; font-family: Arial, sans-serif;">
                        <img src="the return.jpg" alt="Notification Image" style="width: 100px; height: 140px; border-radius: 5px; margin-right: 15px;">
                        <div style="margin-bottom: 50px;">
                            <h3 style="font-size: 20px;">Book Returned</h3>
                            <p style="font-size: 16px;">A user has returned "The Return of the king, The Lord of the Rings" to the catalog.</p>
                        </div>
                        <!-- Close button -->
                        <button style="position: absolute; top: 0px; right: 10px; background-color: transparent; border: none; color: white; font-size: 30px; cursor: pointer;" onclick="this.parentElement.style.display='none';">×</button>
                    </div>

                    <!-- Notification 3 -->
                    <div style="background-color:rgb(141, 152, 163); border-radius: 10px; box-shadow: 0px 10px 5px rgba(0, 0, 0, 0.15); padding:20px; margin-bottom:30px; margin-left:70px; margin-right:70px; display: flex; align-items: center; position: relative; font-family: Arial, sans-serif;">
                        <img src="the return.jpg" alt="Notification Image" style="width: 100px; height: 140px; border-radius: 5px; margin-right: 15px;">
                        <div style="margin-bottom: 50px;">
                            <h3 style="font-size: 20px;">Catalog Update</h3>
                            <p style="font-size: 16px;">Some of the books in the catalog have been updated.</p>
                        </div>
                        <!-- Close button -->
                        <button style="position: absolute; top: 0px; right: 10px; background-color: transparent; border: none; color: white; font-size: 30px; cursor: pointer;" onclick="this.parentElement.style.display='none';">×</button>
                    </div>

                    <!-- Notification 4 -->
                    <div style="background-color:rgb(163, 175, 187); border-radius: 10px; box-shadow: 0px 10px 5px rgba(0, 0, 0, 0.15); padding:20px; margin-bottom:30px; margin-left:70px; margin-right:70px; margin-top: 30px; display: flex; align-items: center; position: relative; font-family: Arial, sans-serif;">
                        <img src="the return.jpg" alt="Notification Image" style="width: 100px; height: 140px; border-radius: 5px; margin-right: 15px;">
                        <div style="margin-bottom: 50px;">
                            <h3 style="font-size: 20px;">Book Borrowed</h3>
                            <p style="font-size: 16px;">A user has borrowed "The Return of the king, The Lord of the Rings" from the catalog.</p>
                        </div>
                        <!-- Close button -->
                        <button style="position: absolute; top: 0px; right: 10px; background-color: transparent; border: none; color: white; font-size: 30px; cursor: pointer;" onclick="this.parentElement.style.display='none';">×</button>
                    </div>

                    <!-- Notification 5 -->
                    <div style="background-color:rgb(185, 198, 211); border-radius: 10px; box-shadow: 0px 10px 5px rgba(0, 0, 0, 0.15); padding:20px; margin-bottom:50px; margin-left:70px; margin-right:70px; margin-top: 30px; display: flex; align-items: center; position: relative; font-family: Arial, sans-serif;">
                        <img src="the return.jpg" alt="Notification Image" style="width: 100px; height: 140px; border-radius: 5px; margin-right: 15px;">
                        <div style="margin-bottom: 50px;">
                            <h3 style="font-size: 20px;">Book Reserved</h3>
                            <p style="font-size: 16px;">A user has reserved "The Return of the king, The Lord of the Rings" for future borrowing.</p>
                        </div>
                        <!-- Close button -->
                        <button style="position: absolute; top: 0px; right: 10px; background-color: transparent; border: none; color: white; font-size: 30px; cursor: pointer;" onclick="this.parentElement.style.display='none';">×</button>
                    </div>

        </div>
        <!-- ========================= Main END ==================== -->
           


<!-- =========== Scripts =========  -->
<script src="admin.js"></script>
<script src="ADMIN_MODAL.js"></script>


<!-- ====== ionicons ======= -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>