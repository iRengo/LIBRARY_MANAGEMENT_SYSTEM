<?php

session_start();
        include '../homepage/db_connect.php';

        // Check if the admin session exists
        if (!isset($_SESSION['acc_no'])) {
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

        $acc_no = $_SESSION['acc_no']; // Get logged-in user's account number
        $login_time = date("Y-m-d H:i:s");

        // Update the last_login column
        $stmt = $conn->prepare("UPDATE stud_acc SET last_logged_in = ? WHERE student_no = ?");
        $stmt->bind_param("si", $login_time, $acc_no);
        $stmt->execute();

// Assuming you've already connected to your database

$query = "SELECT student_no, email, last_name, first_name, contact FROM stud_acc WHERE acc_no = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $acc_no);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $student_no = $row['student_no'];
    $email = $row['email'];
    $last_name = $row['last_name'];
    $first_name = $row['first_name'];
    $contact = $row['contact'];
} else {
    $student_no = $email = $last_name = $first_name = $contact = "Not available";
}

?>

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
    
    <style>
        .container_profile {
    padding: 2rem;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

.profile-section {
    background-color: #fff;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.profile-form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.full-width {
    flex: 100%;
}

label {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

input[readonly] {
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    padding: 0.75rem;
    border-radius: 8px;
    font-size: 1rem;
    color: #333;
}

    </style>
    
</head>

<body>
    <!-- =============== Navigation ================ -->
    <?php include 'HEADER-NAVBAR.PHP' ?>
    <BR><BR><BR><BR>
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

    <div id="account" class="content content-section">
    <div class="container_profile">
        <!-- Unified Profile Section -->
        <section class="profile-section">
            <h2 class="user_profile">Profile</h2>
            <h3 class="user_profile_sub">Your account details</h3>
            
            <!-- Row 1: Email & Student Number -->
            <div class="profile-form-row">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" value="<?= htmlspecialchars($email) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="user-id">Student Number</label>
                    <input type="text" id="user-id" value="<?= htmlspecialchars($student_no) ?>" readonly>
                </div>
            </div>

            <!-- Row 2: Lastname & Firstname -->
            <div class="profile-form-row">
                <div class="form-group">
                    <label for="lastname">Lastname</label>
                    <input type="text" id="lastname" value="<?= htmlspecialchars($last_name) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="firstname">Firstname</label>
                    <input type="text" id="firstname" value="<?= htmlspecialchars($first_name) ?>" readonly>
                </div>
            </div>

            <!-- Row 3: Contact (full width) -->
            <div class="profile-form-row">
                <div class="form-group full-width">
                    <label for="contact">Contact</label>
                    <input type="text" id="contact" value="<?= htmlspecialchars($contact) ?>" readonly>
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