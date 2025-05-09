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
    <link rel="stylesheet" href="ADMIN_DASHBOARD.CSS">
</head>

<body>
    <?PHP INCLUDE 'HEADER-NAVBAR.PHP' ?>
    
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




</body>

</html>