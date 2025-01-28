<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <title> Librarian Reservation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../User-side/USER_STYLE2.CSS">
    <link rel="stylesheet" href="LIBRARIAN_RESERVATION.CSS">


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
                            <ion-icon name="book-outline"></ion-icon>

                        </span>
                        <span class="title">Catalog</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <i class='bx bx-history' style="font-size:35px;"></i>
                        </span>
                        <span class="title">History</span>
                    </a>
                </li>

                <li>
                    <a href="USER_HISTORY.PHP">
                        <span class="icon">
                            <ion-icon name="person-add-outline" style="font-size: 30px;"></ion-icon>
                        </span>
                        <span class="title">Reservations</span>
                    </a>
                </li>

                <li>
                    <a href="USER_HELP&SUPPORT.PHP">
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
                    <a href="USER_TRENDING.php">
                        <span class="icon">
                            <ion-icon name="trending-up-outline"></ion-icon>
                        </span>
                        <span class="title">Reports</span>
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
            <div class="container mt-5">
                <h2 class="text-center mb-4" style="margin-top: 3%; margin-left:2%;">LIST OF BOOK BORROWERS</h2>

                <div class="tab-container">
                    <ul class="tabs">
                        <li class="tab-item active" id="borrowRequestTab">BORROW REQUEST</li>
                        <li class="tab-item" id="approvedTab">APPROVED</li>
                        <li class="tab-item" id="declinedTab">DECLINED</li>
                    </ul>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Borrow ID</th>
                            <th>Title</th>
                            <th>User</th>
                            <th>Date Form</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Placeholder Records -->
                        <tr>
                            <td>1</td>
                            <td>Book Title 1</td>
                            <td>User 1</td>
                            <td>2025-01-15</td>
                            <td>
                                <ion-icon name="eye-outline"></ion-icon>
                                <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                                <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Book Title 2</td>
                            <td>User 2</td>
                            <td>2025-01-16</td>
                            <td>
                                <ion-icon name="eye-outline"></ion-icon>
                                <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                                <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Book Title 3</td>
                            <td>User 3</td>
                            <td>2025-01-17</td>
                            <td>
                                <ion-icon name="eye-outline"></ion-icon>
                                <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                                <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Book Title 4</td>
                            <td>User 4</td>
                            <td>2025-01-18</td>
                            <td>
                                <ion-icon name="eye-outline"></ion-icon>
                                <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                                <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Book Title 5</td>
                            <td>User 5</td>
                            <td>2025-01-19</td>
                            <td>
                                <ion-icon name="eye-outline"></ion-icon>
                                <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                                <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Book Title 6</td>
                            <td>User 6</td>
                            <td>2025-01-20</td>
                            <td>
                                <ion-icon name="eye-outline"></ion-icon>
                                <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                                <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Book Title 7</td>
                            <td>User 7</td>
                            <td>2025-01-21</td>
                            <td>
                                <ion-icon name="eye-outline"></ion-icon>
                                <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                                <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Book Title 8</td>
                            <td>User 8</td>
                            <td>2025-01-22</td>
                            <td>
                                <ion-icon name="eye-outline"></ion-icon>
                                <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                                <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Book Title 9</td>
                            <td>User 9</td>
                            <td>2025-01-23</td>
                            <td>
                                <ion-icon name="eye-outline"></ion-icon>
                                <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                                <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Book Title 10</td>
                            <td>User 10</td>
                            <td>2025-01-24</td>
                            <td>
                                <ion-icon name="eye-outline"></ion-icon>
                                <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                                <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
            <!-- Content HERE End -->



        </div>


        <!-- ========================= Main END ==================== -->



        <!-- =========== Scripts =========  -->
        <script src="/User-side/USER.JS"></script>





        <!-- ====== ionicons ======= -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>