<?php
include '../homepage/db_connect.php';
session_start();
if (!isset($_SESSION['admin_no'])) {
    // If not, show a SweetAlert notification and then redirect
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        window.onload = function() {
            // Show SweetAlert notification
            Swal.fire({
                title: "You are not logged in!",
                text: "Please log in to access the page.",
                icon: "error",
                confirmButtonText: "OK",
                allowOutsideClick: false,
                allowEscapeKey: false,
                willClose: () => {
                    // Redirect to homepage after the notification is closed
                    window.location.href = "../homepage/homepage.php";
                }
            });
        }
        </script>';
    exit(); // Stop further execution after showing the notification and redirect script
}
// Get the current time
$current_time = date('Y-m-d H:i:s');

// Assuming the admin is logged in and their ID is stored in session
$admin_id = $_SESSION['admin_no'];

// Update the 'last_logged_in' field in the database for the logged-in admin
$query = "UPDATE admin_acc SET last_logged_in = ? WHERE admin_no = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $current_time, $admin_id); // 'si' means string and integer
$stmt->execute();

?>
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
    <link rel="stylesheet" href="ADMIN_DASHBOARD.CSS">

    <!-- ======= Scripts ====== -->


    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>


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
                        <a href="ADMIN_CATALOG.PHP">
                            <span class="icon">
                                <ion-icon name="book-outline"></ion-icon>
                            </span>
                            <span class="title">Catalog</span>
                        </a>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <a href="ADMIN_USERS.PHP">
                            <span class="icon">
                                <ion-icon name="person-outline"></ion-icon>
                            </span>
                            <span class="title">Users</span>
                        </a>
                    </a>
                </li>

                <li>
                    <a href="STAFF_TOOLS.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Staff Tools</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <a href="ADMIN_NOTIFICATIONS.php">
                        <span class="icon">
                            <ion-icon name="notifications-outline"></ion-icon>
                        </span>
                        <span class="title">Notifications</span>
                        </a>
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




            <!-- Monthly Bar Graph -->
            <div class="bar-graph-container">
                <h3>Book Usage (Monthly)</h3>
                <div class="bar-graph">
                    <div class="bar" style="height: 75%;"></div> <!-- 75% height as example -->
                    <div class="bar" style="height: 50%;"></div> <!-- 50% height as example -->
                    <div class="bar" style="height: 85%;"></div> <!-- 85% height as example -->
                    <div class="bar" style="height: 40%;"></div> <!-- 40% height as example -->
                    <div class="bar" style="height: 60%;"></div> <!-- 60% height as example -->
                    <div class="bar" style="height: 30%;"></div> <!-- 30% height as example -->
                    <div class="bar" style="height: 90%;"></div> <!-- 90% height as example -->
                </div>
            </div>

            <!-- Charts Container -->
            <div class="charts-container">
                <!-- Doughnut Chart -->
                <div class="doughnut-chart">
                    <h3 style="margin-bottom: 40px; margin-top: -60px;">Library Metrics</h3>
                    <div class="doughnut">
                        <div class="inner-circle"></div>
                    </div>
                    <ul class="legend">
                        <li><span class="legend-color growth"></span> Growth</li>
                        <li><span class="legend-color satisfaction"></span> Satisfaction</li>
                        <li><span class="legend-color usage"></span> Usage</li>
                        <li><span class="legend-color financial"></span> Financial Stability</li>
                    </ul>
                </div>

                <!-- Pie Chart -->
                <div class="pie-chart">
                    <h3 style="margin-bottom: 40px; margin-top: -60px;">Patreon Feedback</h3>
                    <div class="pie"></div>
                    <ul class="legend">
                        <li><span class="legend-color satisfactory"></span> Satisfactory (60%)</li>
                        <li><span class="legend-color unsatisfactory"></span> Unsatisfactory (40%)</li>
                    </ul>
                </div>
            </div>


            <!-- Gray-colored div under the charts with image and text -->

            <div class="used-box">
                <h3 class="used-text">NOT USED BOOKS</h3>
                <img src="the return.jpg" alt="Return Image" class="image1">
                <img src="the return.jpg" alt="Return Image" class="image2">
                <img src="the return.jpg" alt="Return Image" class="image3">
                <img src="the return.jpg" alt="Return Image" class="image4">
                <img src="the return.jpg" alt="Return Image" class="image5">
            </div>

            <!-- New brown-colored div below the gray box -->
            <div class="avail-box">
                <h3 class="avail-text">BOOK AVAILABILITY</h3><span></span>
                <div class="avail-image-container">
                    <img src="the return.jpg" alt="Return Image" class="avail-image">
                    <div class="status available"></div> <!-- Available Status -->
                </div>
                <div class="avail-image-container">
                    <img src="the return.jpg" alt="Return Image" class="avail-image">
                    <div class="status available"></div> <!-- Available Status -->
                </div>
                <div class="avail-image-container">
                    <img src="the return.jpg" alt="Return Image" class="avail-image">
                    <div class="status available"></div> <!-- Available Status -->
                </div>
                <div class="avail-image-container">
                    <img src="the return.jpg" alt="Return Image" class="avail-image">
                    <div class="status unavailable"></div> <!-- Unavailable Status -->
                </div>
                <div class="avail-image-container">
                    <img src="the return.jpg" alt="Return Image" class="avail-image">
                    <div class="status unavailable"></div> <!-- Unavailable Status -->
                </div>
                <div class="avail-image-container">
                    <img src="the return.jpg" alt="Return Image" class="avail-image">
                    <div class="status unavailable"></div> <!-- Unavailable Status -->
                </div>
                <div class="avail-image-container">
                    <img src="the return.jpg" alt="Return Image" class="avail-image">
                    <div class="status available"></div> <!-- Available Status -->
                </div>
            </div>


            <!-- New div for Top 10 Users List -->
            <!-- New div for Top 10 Users List -->
            <div class="user-list-box">
                <h3 class="user-list-text">TOP USERS</h3>
                <ul class="user-list">
                    <li><span class="user-icon"><img src="no profile.png" alt="User 1"></span> Jose Luis</li>
                    <li><span class="user-icon"><img src="no profile.png" alt="User 2"></span> Antonio Reyes</li>
                    <li><span class="user-icon"><img src="no profile.png" alt="User 3"></span> Ana Maria</li>
                    <li><span class="user-icon"><img src="no profile.png" alt="User 4"></span> Carlos Santos</li>
                    <li><span class="user-icon"><img src="no profile.png" alt="User 5"></span> Gabriela Torres</li>
                    <li><span class="user-icon"><img src="no profile.png" alt="User 6"></span> Manuel Aquino</li>
                    <li><span class="user-icon"><img src="no profile.png" alt="User 7"></span> Rosa Santiago</li>
                    <li><span class="user-icon"><img src="no profile.png" alt="User 9"></span> Rafael Gutierrez</li>
                </ul>
            </div>



            <!-- Content HERE -->
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