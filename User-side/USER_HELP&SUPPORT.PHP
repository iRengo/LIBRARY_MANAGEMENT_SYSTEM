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

            <div style="display: flex; justify-content: space-between; margin-top: 5%; border: 1px solid #ccc; padding: 20px; border-radius: 10px;">
    <div style="margin: auto;">
        <img src="helpsup1.png" alt="Left Image" style="max-width: 200px;max-height:200px;">
    </div>
    <div class="center" style="text-align: center;">
        <div style="margin-bottom: 10px;margin-top:8%;">
            <h3 style="margin: 0; font-size: 1.5rem; color: #333;">HELP CENTER</h3>
            <p style="margin: 5px 0; font-size: 0.9rem; color: gray;">How can we assist you today?</p>
        </div>
        <input type="text" placeholder="Search..." style="border-radius: 20px; max-height: 100%; width: 500px; height: 40px; padding: 10px; font-size: 16px; border: 1px solid #ccc;">
    </div>
    <div style="margin: auto;">
        <img src="helpsup2.png" alt="Right Image" style="max-width:300px;max-height:250px;">
    </div>
</div>

<div style="display: flex; justify-content: space-between; align-items: flex-start; padding: 20px; margin-top:2%;">
    <!-- FAQ Section (Left Content) -->
    <div class="faq" style="font-size: 200%; margin-left: 8%;margin-top:2%;">
        <h4 style="font-weight: 800;">FAQ</h4>
        <h2>FREQUENTLY</h2>
        <h2>ASKED</h2>
        <h2>QUESTIONS.</h2>
    </div>

    <!-- Dropdown Section (Right Content) -->
    <div style="width: 100%; max-width:850px;margin-right:5%; margin-top:2%;">
        <!-- 2x2 Grid for Dropdowns with Adjusted Space and Width -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; width: 100%;">
            <!-- Dropdown 1 -->
            <div 
                id="dropdownToggle1" 
                style="display: flex; justify-content: space-between; align-items: center; cursor: pointer; padding: 15px; background-color: #F9F9F9; border-radius: 8px; border: 1px solid #ccc; width: 100%;">
                <span style="font-size: 1rem; color: #333;">Problem with my account?</span>
                <i id="chevron1" class="bx bx-chevron-down" style="font-size: 1.5rem; color: #333; transition: transform 0.3s;"></i>
            </div>
            <!-- Dropdown 2 -->
            <div 
                id="dropdownToggle2" 
                style="display: flex; justify-content: space-between; align-items: center; cursor: pointer; padding: 15px; background-color: #F9F9F9; border-radius: 8px; border: 1px solid #ccc; width: 100%;">
                <span style="font-size: 1rem; color: #333;">Billing Issues</span>
                <i id="chevron2" class="bx bx-chevron-down" style="font-size: 1.5rem; color: #333; transition: transform 0.3s;"></i>
            </div>
            <!-- Dropdown 3 -->
            <div 
                id="dropdownToggle3" 
                style="display: flex; justify-content: space-between; align-items: center; cursor: pointer; padding: 15px; background-color: #F9F9F9; border-radius: 8px; border: 1px solid #ccc; width: 100%;">
                <span style="font-size: 1rem; color: #333;">Account Settings</span>
                <i id="chevron3" class="bx bx-chevron-down" style="font-size: 1.5rem; color: #333; transition: transform 0.3s;"></i>
            </div>
            <!-- Dropdown 4 -->
            <div 
                id="dropdownToggle4" 
                style="display: flex; justify-content: space-between; align-items: center; cursor: pointer; padding: 15px; background-color: #F9F9F9; border-radius: 8px; border: 1px solid #ccc; width: 100%;">
                <span style="font-size: 1rem; color: #333;">Other Issues</span>
                <i id="chevron4" class="bx bx-chevron-down" style="font-size: 1.5rem; color: #333; transition: transform 0.3s;"></i>
            </div>
        </div>
        
        
</div>



        </div>



    </div>
    <!-- ========================= Main END ==================== -->



    <!-- =========== Scripts =========  -->
    <script src="USER.js"></script>
    



    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>