<?php

include '../Homepage/db_connect.php';
include '../Homepage/automatic_borrowing_process.php';
include '../Homepage/due_overdue_checkr.php';
include '../Homepage/archiver.php';
include '../Homepage/release_upcoming_books.php';
include '../Homepage/UNCLAIMED_BOOK_CHECKER.PHP';

if (isset($_SESSION['admin_no'])) {
    $AdminNo = $_SESSION['admin_no'];  


    $query = "SELECT first_name FROM admin_acc WHERE admin_no = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $AdminNo); 
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($adminFirstName); 
            $stmt->fetch();
        } else {

            $adminFirstname = "Admin";
        }

        $stmt->close();
    } else {

        $AdminFirstName = "Admin";
    }
} else {

    $AdminFirstName = "Admin";
}

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="HEADER-NAVBAR.CSS">

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
                                 <span class="title1"><?php echo htmlspecialchars($adminFirstName); ?></span>
                        </a>
                    </div>
                </li>

                <li>
                    <a href="ADMIN_DASHBOARD.PHP">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="ADMIN_CATALOG.PHP">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Catalog</span>
                    </a>
                </li>

                <li>
                    <a href="ADMIN_USERS.PHP">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">User Management</span>
                    </a>
                </li>
                <li>
                    <a href="ADMIN_NOTIFICATIONS.PHP">
                        <span class="icon">
                            <ion-icon name="notifications-outline"></ion-icon>
                        </span>
                        <span class="title">Notifications</span>
                    </a>
                </li>

                <li>
                    <a href="ADMIN_STAFF_TOOLS.PHP">
                        <span class="icon">
                            <ion-icon name="build-outline"></ion-icon>
                        </span>
                        <span class="title">Staff tools</span>
                    </a>
                </li>


                <li>
                    <a href="ADMIN_SETTINGS.PHP">
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

                <!-- Dropdown Menu -->
                <div class="dropdown">
                    <button class="dropbtn">
                        <ion-icon name="person-circle-outline" style="font-size: 32px;"></ion-icon>
                        <ion-icon name="caret-down-outline" style="margin-left: 5px;margin-bottom:5px;"></ion-icon>
                    </button>
                    <div class="dropdown-content">
                        <a href="#" id="logoutIcon">
                            <ion-icon name="log-out-outline"></ion-icon> Logout
                        </a>
                    </div>
                </div>

                <!-- Notification Panel -->
                <div id="notificationPanel" class="notification-panel">

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
                            window.location.href = 'ADMIN-LOGOUT.php';
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