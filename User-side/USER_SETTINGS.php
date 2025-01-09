<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <title> Settings </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="User_css/ADMIN_STYLES2.CSS">
    <link rel="stylesheet" href="User_css/ADMIN_MODAL.css">
    <link rel="stylesheet" href="User_css/User.css">

    <!-- ======= User Styles Start ====== -->

    <link rel="stylesheet" href="three_settings/account_user_css1.css">
    <link rel="stylesheet" href="three_settings/account_user_fines_css.css">
    <link rel="stylesheet" href="three_settings/account_user_notification_css.css">

    <!-- ======= User Styles End ====== -->


    <!-- ======= Scripts ====== -->
    <script src="users_js/fines.js"></script>


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
                    <h2>Confirm Logou       t</h2>
                    <p>Are you sure you want to logout?</p>
                    <div class="modal-actions">
                        <a href="#" class="btn-action btn-yes">Yes</a>
                        <button class="btn-action btn-no" id="cancelLogout">No</button>
                    </div>
                </div>
            </div>

            <!-- Content HERE -->

            <!-- Settings Start -->
            
<div class="Settings_content">
    <div class="top_text">
        <h2>Settings</h2>
        <div class="subtext">
            <h3>Manage Your Account Settings and Preferences</h3>
            <div class="sub_buttons">
                <button id="account-btn" onclick="showContent('account')">Account</button>
                <button id="notifications-btn" onclick="showContent('notifications')">Notifications</button>
                <button id="fines-btn" onclick="showContent('fines')">Fines</button>
            </div>
        </div>
    </div>

    <!-- Content Sections -->

            <!-- Accounts Information Start... -->
<div id="account" class="content content-section">
    <div class="container_profile">
        <!-- Profile Section -->
        <section class="profile-section">
            <h2 class="user_profile">Profile</h2>
            <h3 class="user_profile_sub">Set your account details</h3>
            <div class="profile-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="user-id">USER ID</label>
                    <input type="text" id="user-id" placeholder="Enter user ID">
                </div>
                <div class="form-group full-width">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="Enter email">
                </div>
                <div class="upload-section">
                    <div class="upload-placeholder">
                        <img src="https://via.placeholder.com/100" alt="Profile Icon">
                    </div>
                    <button class="upload-button">UPLOAD</button>
                </div>
            </div>
        </section>



        <!-- Personal Information Section -->
        <section class="personal-info-section">
                <h2>Personal Information</h2>
                <div class="personal-info-form">
                    <div class="form-group">
                        <label for="lastname">Lastname</label>
                        <input type="text" id="lastname" placeholder="Enter lastname">
                    </div>
                    <div class="form-group">
                        <label for="firstname">Firstname</label>
                        <input type="text" id="firstname" placeholder="Enter firstname">
                    </div>
                    <div class="form-group">
                        <label for="mi">M.I</label>
                        <input type="text" id="mi" placeholder="M.I">
                    </div>
                    <div class="form-group">
                        <label for="birth-date">Birth Date</label>
                        <input type="date" id="birth-date">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" placeholder="Age">
                    </div>
                    <div class="form-group full-width">
                        <label for="address">Address</label>
                        <input type="text" id="address" placeholder="Enter address">
                    </div>
                    <div class="form-group">
                        <label for="civil-status">Civil Status</label>
                        <input type="text" id="civil-status" placeholder="Civil status">
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact</label>
                        <input type="text" id="contact" placeholder="Enter contact">
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <input type="text" id="gender" placeholder="Enter gender">
                    </div>
                </div>
            </section>
        </div>
    </div>

            <!-- Accounts Information End... -->


            <!-- Notifications Information Start... -->

<div id="notifications" class="content content-section settings-container" style="display:none;">
    <h2>Notification Preferences</h2>
    <div class="line"></div>
    <br>
    <div class="notification-preferences">
        <div class="notification-toggle">
            <label for="turn-off-notifications">Turn off Notification Temporarily</label>
            <select id="turn-off-notifications">
                <option value="off">Off</option>
                <option value="1-day">1 Day</option>
                <option value="1-week">1 Week</option>
            </select>
        </div>
        <div class="via_notifs">
            <h4>Notify Via</h4>
        </div>
        <div class="notify-options">
            <label class="notify-button">
                <span>
                    <span class="icon email-icon"><ion-icon name="mail-unread" style="font-size:50px;"></ion-icon></span>
                    Email
                </span>
                <span class="radio-container"><input type="radio" name="notify" checked></span>
            </label>
            <label class="notify-button">
                <span>
                    <span class="icon app-icon"><img src="logo.png" alt=""></span>
                    In-app notifications Only
                </span>
                <span class="radio-container"><input type="radio" name="notify"></span>
            </label>
            <label class="notify-button">
                <span>Both</span>
                <span class="radio-container"><input type="radio" name="notify"></span>
            </label>
        </div>

        <div class="actions">
            <button class="edit-button">Edit</button>
            <button class="save-button">Save</button>
        </div>
    </div>
</div>

            <!-- Notifications Information End... -->
                    

            <!-- Fines Information Start... -->

    <div id="fines" class="content content-section" style="display:none;">
        <h3>Fines Information</h3>
        <table class="fines_table">
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Borrow Date</th>
                    <th>Returned Date</th>
                    <th>Remark</th>
                    <th>FINES</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Filtered Life</td>
                    <td>April 08, 1992</td>
                    <td>April 08, 1992</td>
                    <td>Damaged</td>
                    <td>$3.00</td>
                </tr>
                <!-- Add other fines here -->
            </tbody>
        </table>
            <!-- Pagination -->
        <div class="pagination">
            <button>Prev</button>
            <button>1</button>
            <button>2</button>
            <button>3</button>
            <button>Next</button>
        </div>
    </div>

            <!-- Fines Information End... -->
</div>

            <!-- Settings End -->
</div>
        <!-- ========================= Main END ==================== -->
   
<!-- =========== Scripts =========  -->
<script src="User_css/admin.js"></script>
<script src="User_css/ADMIN_MODAL.js"></script>

<script src="users_js/notiff.js"></script>



<!-- ====== ionicons ======= -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>