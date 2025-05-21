<?php

include '../Homepage/db_connect.php';

if (isset($_SESSION['librarian_no'])) {
    $librarianNo = $_SESSION['librarian_no'];


    $query = "SELECT first_name FROM librarian_acc WHERE librarian_no = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $librarianNo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($librarianFirstName);
            $stmt->fetch();
        } else {

            $librarianFirstName = "Librarian";
        }

        $stmt->close();
    } else {

        $librarianFirstName = "Librarian";
    }
} else {

    $librarianFirstName = "Librarian";
}

// Borrow Requests
$borrowRequestsCount = $conn->query("SELECT COUNT(*) AS total FROM borrowed_books WHERE status = 'Pending'")->fetch_assoc()['total'];

// Ready to Pickup
$readyPickupCount = $conn->query("SELECT COUNT(*) AS total FROM borrowed_books WHERE status = 'Approved'")->fetch_assoc()['total'];

// Reserved Books
$reservedBooksCount = $conn->query("SELECT COUNT(*) AS total FROM reserved_books")->fetch_assoc()['total'];

// Due Books: due today
$dueBooksCount = $conn->query("SELECT COUNT(*) AS total FROM borrowed_books WHERE status = 'Borrowed' AND due_date = CURDATE()")->fetch_assoc()['total'];

// Overdue Books: past due
$overdueBooksCount = $conn->query("SELECT COUNT(*) AS total FROM borrowed_books WHERE status = 'Borrowed' AND due_date < CURDATE()")->fetch_assoc()['total'];

// Returned Books
$returnedBooksCount = $conn->query("SELECT COUNT(*) AS total FROM returned_books")->fetch_assoc()['total'];

// Unpaid Fines
$unpaidFinesCount = $conn->query("SELECT COUNT(*) AS total FROM student_fines WHERE status = 'Unpaid'")->fetch_assoc()['total'];

// Borrowed Books
$borrowedBooksCount = $conn->query("SELECT COUNT(*) AS total FROM borrowed_books WHERE status = 'Borrowed'")->fetch_assoc()['total'];

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
                            <span class="title1"><?php echo htmlspecialchars($librarianFirstName); ?></span>
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
                    <a href="LIBRARIAN_CATALOG.PHP">
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

                <li class="has-dropdown">
                    <a href=" ">
                        <span class="icon">
                            <ion-icon name="notifications-outline"></ion-icon>
                        </span>
                        <span class="title">Notifications</span>
                    </a>
                    <ul class="sidebar-dropdown push-inside">
                        <li></li>
                        <li><a href="BORROWED_BOOKS.PHP">Borrowed Books <span class="badge"><?php echo $borrowedBooksCount; ?></span></a></li>
                        <li><a href="BORROW_REQUEST.PHP">Borrow Requests <span class="badge"><?php echo $borrowRequestsCount; ?></span></a></li>
                        <li><a href="READY_PICKUP.PHP">Ready to Pickup <span class="badge"><?php echo $readyPickupCount; ?></span></a></li>
                        <li><a href="RESERVED_BOOKS.PHP">Reserved Books <span class="badge"><?php echo $reservedBooksCount; ?></span></a></li>
                        <li><a href="DUE_BOOKS.PHP">Due Books <span class="badge"><?php echo $dueBooksCount; ?></span></a></li>
                        <li><a href="OVERDUE_BOOKS.PHP">Overdue Books <span class="badge"><?php echo $overdueBooksCount; ?></span></a></li>
                        <li><a href="RETURNED_BOOKS.PHP">Returned Books <span class="badge"><?php echo $returnedBooksCount; ?></span></a></li>
                        <li><a href="UNPAID_FINES.PHP">Unpaid Fines <span class="badge"><?php echo $unpaidFinesCount; ?></span></a></li>

                    </ul>
                </li>





                <li>
                    <a href="LIBRARIAN_USER_MANAGEMENT.PHP">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">User Management</span>
                    </a>
                </li>
                <li>
                    <a href="LIBRARIAN_REPORT.PHP">
                        <span class="icon">
                            <ion-icon name="stats-chart-outline"></ion-icon>
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

                <!-- Dropdown Menu -->
                <div class="dropdown">
                    <button class="dropbtn">
                        <ion-icon name="person-circle-outline" style="font-size: 32px;"></ion-icon>
                        <ion-icon name="caret-down-outline" style="margin-left: 5px;margin-bottom:5px;"></ion-icon>
                    </button>
                    <div class="dropdown-content">
                        <a href="#" id="toggleNotifications">
                            <ion-icon name="notifications-outline"></ion-icon> Notifications
                        </a>
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
                function toggleNotificationDropdown(event) {
                    event.preventDefault(); // Prevent default link behavior

                    const dropdown = document.getElementById("notificationDropdown");
                    dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
                }

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
                            window.location.href = 'LIBRARIAN-LOGOUT.php';
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