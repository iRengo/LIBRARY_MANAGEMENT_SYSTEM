<?php
// Include database connection
include '../homepage/db_connect.php';

// Start session
session_start();
if (!isset($_SESSION['acc_no'])) {
    die("Access Denied. Please log in.");
}

$acc_no = $_SESSION['acc_no']; // Get the logged-in user's acc_no

// Fetch Borrowing History (Including Status and Due Date)
$query_borrow = "SELECT bh.borrowing_id, bh.book_id, bh.status, b.book_title, bh.borrow_date, bh.due_date 
                 FROM borrowing_history bh
                 JOIN tbl_books b ON bh.book_id = b.book_id
                 WHERE bh.acc_no = ?";
$stmt_borrow = $conn->prepare($query_borrow);
$stmt_borrow->bind_param("s", $acc_no);
$stmt_borrow->execute();
$result_borrow = $stmt_borrow->get_result();

// Fetch Reservation History
$sql_reserve = "SELECT book_title, reservation_date, expiration_date 
                FROM reservation_history
                WHERE acc_no = ?";
$stmt_reserve = $conn->prepare($sql_reserve);
$stmt_reserve->bind_param("s", $acc_no);
$stmt_reserve->execute();
$result_reserve = $stmt_reserve->get_result();

// Fetch Renewal History
$sql_renew = "SELECT book_title, renewal_date, new_due_date
              FROM book_renewal_history WHERE acc_no = ?";
$stmt_renew = $conn->prepare($sql_renew);
$stmt_renew->bind_param("s", $acc_no);
$stmt_renew->execute();
$result_renew = $stmt_renew->get_result();

// Close statements
$stmt_borrow->close();
$stmt_reserve->close();
$stmt_renew->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <title> History </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="User_css/ADMIN_STYLES2.CSS">
    <link rel="stylesheet" href="User_css/ADMIN_MODAL.css">
    <link rel="stylesheet" href="User_css/User.css">
    <link rel="stylesheet" href="USER_HISTORY2.CSS">

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
        .cancel-btn {
    background-color: #ff4d4d; /* Red color */
    color: white;
    border: none;
    padding: 7px 8px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

.cancel-btn:hover {
    background-color: #cc0000; /* Darker red */
    transform: scale(1.05);
}

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
                <a href="USER_CATALOG.PHP">
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
                    <h2>Confirm Logout</h2>
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
        <div class="sub_buttons">
            <div class="buttons-group">
                <button id="account-btn" onclick="showContent('account')">Borrowing</button>
                <button id="notifications-btn" onclick="showContent('notifications')">Reservation</button>
                <button id="fines-btn" onclick="showContent('fines')">Book Renewal</button>
            </div>
            <select id="date-dropdown">
                <option value="" disabled selected>Select Date</option>
                <option value="2024-04-08">April 08, 2024</option>
                <option value="2024-04-15">April 15, 2024</option>
                <option value="2024-04-22">April 22, 2024</option>
            </select>
        </div>
    </div>
</div>

    <!-- Content Sections -->

   <!-- Borrowing History Section -->
<div id="account" class="content content-section">
    <div class="container_profile">
        <section class="profile-section">
            <div class="profile-form">
                <div class="form-group full-width">
                    <label class="history">Borrowing History</label>
                    <div class="main-table">
                        <?php while ($row = $result_borrow->fetch_assoc()) { ?>
                            <div class="table">
                                <div class="titlee">Book Title
                                    <div id="info"><?= htmlspecialchars($row['book_title']) ?></div>
                                </div>
                                <div class="borrowdate">Borrow Date
                                    <div id="info"><?= htmlspecialchars($row['borrow_date']) ?></div>
                                </div>

                                <!-- Show "Status" only if it's Pending -->
                                <?php if ($row['status'] == 'Pending') { ?>
                                    <div class="status">Status
                                        <div id="info"><?= htmlspecialchars($row['status']) ?></div>
                                    </div>
                                <?php } ?>

                                <!-- Show "Due Date" only if status is NOT Pending -->
                                <?php if ($row['status'] != 'Pending') { ?>
                                    <div class="duedate">Due Date
                                        <div id="info"><?= htmlspecialchars($row['due_date']) ?></div>
                                    </div>
                                <?php } ?>

                                <?php if ($row['status'] == 'Pending') { ?>
                                    <div class="cancel">
                                        <form action="cancel_borrow.php" method="POST">
                                            <input type="hidden" name="book_id" value="<?= htmlspecialchars($row['book_id']) ?>">
                                            <input type="hidden" name="borrowing_id" value="<?= htmlspecialchars($row['borrowing_id']) ?>">
                                            <button type="submit" class="cancel-btn">Cancel</button>
                                        </form>
                                    </div>
                                <?php } else { ?>
                                    <div class="returndate">Return Date
                                        <div id="info"><?= htmlspecialchars($row['return_date'] ?? 'Not returned') ?></div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Reservation History -->
<div id="notifications" class="content content-section">
    <div class="container_profile">
        <section class="profile-section">
            <div class="profile-form">
                <div class="form-group full-width">
                    <label class="history">Reservation History</label>
                    <div class="main-table">
                        <?php while ($row = $result_reserve->fetch_assoc()) { ?>
                            <div class="table">
                                <div class="titlee">Book Title<div id="info"><?= $row['book_title'] ?></div></div>
                                <div class="reservedate">Reservation Date<div id="info"><?= $row['reservation_date'] ?></div></div>
                                <div class="duedate">Expiration Date<div id="info"><?= $row['expiration_date'] ?></div></div>
                                <div class="action">
                                    <button class="cancel-btn" onclick="cancelReservation('<?= $row['book_title'] ?>')">Cancel</button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Book Renewal History -->
<div id="fines" class="content content-section" style="display:none;">
    <div class="container_profile">
        <section class="profile-section">
            <div class="profile-form">
                <div class="form-group full-width">
                    <label class="history">Book Renewal History</label>
                    <div class="main-table">
                        <?php while ($row = $result_renew->fetch_assoc()) { ?>
                            <div class="table">
                                <div class="titlee">Book Title<div id="info"><?= $row['book_title'] ?></div></div>
                                <div class="borrowdate">Book Renewal<div id="info"><?= $row['renewal_date'] ?></div></div>
                                <div class="duedate">New Due Date<div id="info"><?= $row['new_due_date'] ?></div></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


            <!-- Fines Information End... -->
</div>

            <!-- Settings End -->
</div>
        <!-- ========================= Main END ==================== -->
   
<!-- =========== Scripts =========  -->
<script>
function cancelReservation(bookTitle) {
    if (confirm(`Are you sure you want to cancel the reservation for "${bookTitle}"?`)) {
        fetch('cancel_reservation.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `book_title=${encodeURIComponent(bookTitle)}`
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === "success") {
                location.reload(); // Reload the page to reflect changes
            }
        })
        .catch(error => console.error("Error:", error));
    }
}
</script>
<script src="User_css/admin.js"></script>
<script src="User_css/ADMIN_MODAL.js"></script>

<script src="users_js/notiff.js"></script>



<!-- ====== ionicons ======= -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>