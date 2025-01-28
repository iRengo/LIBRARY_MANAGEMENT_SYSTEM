<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <title> Librarian Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../User-side/USER_STYLE2.CSS">
    <link rel="stylesheet" href="LIBRARIAN_DASHBOARD.CSS">
    <style>
        .submit-ticket-section .row {
            display: flex;
            gap: 15px;
        }

        .submit-ticket-section .col {
            flex: 1;
        }
    </style>

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

                <li>
                    <a href="LIBRARIAN_RESERVATION.PHP">
                        <span class="icon">
                            <ion-icon name="person-add-outline" style="font-size: 30px;"></ion-icon>
                        </span>
                        <span class="title">Reservations</span>
                    </a>
                </li>

                <li>
                    <a href="LIBRARIAN_NOTIFICATION.PHP">
                        <span class="icon">
                            <ion-icon name="notifications-outline"></ion-icon>
                        </span>
                        <span class="title">Notifications</span>
                    </a>
                </li>

                <li>
                <a href="USER_MANAGEMENT.PHP">
                        <span class="icon">
                            <ion-icon name="file-tray-stacked-outline"></ion-icon>
                        </span>
                        <span class="title">User Management</span>
                    </a>
                </li>
                <li>
                    <a href="LIBRARIAN_REPORTS.php">
                        <span class="icon">
                            <ion-icon name="trending-up-outline"></ion-icon>
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
                <div class="logo" title="LOGOUT YOUR ACCOUNT" style="margin-right: 1%; display: flex; align-items: center;">
                    <a href="#" id="logoutIcon" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                        <p style="margin: 0; font-size: 18px; margin-right: 8px;">LOGOUT</p>
                        <i class='bx bx-log-in-circle' style="font-size:35px; color:#da1b1b;"></i>
                    </a>
                </div>
            </div>

            <!-- Content HERE -->
            <div class="content">
                <div class="stats-container">
                    <div class="stat-card">
                        <ion-icon name="time-outline"></ion-icon>
                        <div>
                            <h3>Overdue</h3>
                            <p>12</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <ion-icon name="newspaper-outline"></ion-icon>
                        <div>
                            <h3>Reserved</h3>
                            <p>23</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <ion-icon name="file-tray-full-outline"></ion-icon>
                        <div>
                            <h3>Returned</h3>
                            <p>2</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <ion-icon name="bookmark-outline"></ion-icon>
                        <div>
                            <h3>Available books</h3>
                            <p>7</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <!-- Book Availability Chart -->
                <div class="col">
                    <h3 style="color:gray;"> Book Availability </h3>
                    <canvas id="bookAvailabilityChart"></canvas>
                </div>
                <!-- Book Popularity Chart -->
                <div class="col">
                    <h3 style="color:gray;"> Book Popularity </h3>
                    <canvas id="bookPopularityChart"></canvas>
                </div>
            </div>


            <div class="col-6 table-container">
                <h3 style="color: gray;">Active Borrowers</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Rank</th>
                            <th scope="col">Name</th>
                            <th scope="col">Books Borrowed</th>
                            <th scope="col">Last Borrowed </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>25</td>
                            <td>A year ago </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jane Smith</td>
                            <td>18</td>
                            <td>A year ago </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Mark Wilson</td>
                            <td>15</td>
                            <td>A year ago </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Emily Davis</td>
                            <td>12</td>
                            <td>A year ago </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Create Announcement Button -->
            <div class="col-6 announcement-container">
                <button class="announcement-button">+ Announcement</button>
            </div>
        </div>


    </div>


    <!-- ========================= Main END ==================== -->



    <!-- =========== Scripts =========  -->
    <script src="/User-side/USER.JS"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Book Availability Donut Chart
            const bookAvailabilityData = {
                labels: ['Action', 'Fiction', 'SciFi', 'Non-fiction', 'Study'],
                datasets: [{
                    data: [25, 40, 15, 10, 10], // Placeholder values
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)'
                    ],
                    hoverOffset: 4
                }]
            };

            const ctx1 = document.getElementById('bookAvailabilityChart').getContext('2d');
            new Chart(ctx1, {
                type: 'doughnut',
                data: bookAvailabilityData,
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Book Popularity Bar Chart
            const bookPopularityData = {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Books Borrowed',
                    data: [120, 200, 150, 80, 70, 110, 130], // Placeholder values
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            };

            const ctx2 = document.getElementById('bookPopularityChart').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: bookPopularityData,
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>

        <!-- =========== Scripts =========  -->
    <script src="LIBRA.js"></script>
    <script src="LIBRARIAN.js"></script>




    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>