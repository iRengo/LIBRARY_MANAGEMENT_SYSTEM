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
    <link rel="stylesheet" href="ADMIN_USERS.CSS">
    <link rel="stylesheet" href="ADMIN_MODAL.css">
    <link rel="stylesheet" href="../User-side/USER_STYLE2.CSS">

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
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Catalog</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Users</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Staff Tools</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="notifications-outline"></ion-icon>
                        </span>
                        <span class="title">Notifications</span>
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
            <div class="content" style="display: flex; align-items: flex-start;">
                <div class="table-container" style="flex: 2; margin-right: 20px;">
                    <h2 class="table-title">User Management</h2>
                    <h4 style="margin-top: -0.5%; font-weight:200; color:gray;"> Manage overall Users </h4>
                    <br>

                    <!-- Search Bar -->
                    <div class="search-container" style="margin-bottom: 20px; display: flex; align-items: center;">
                        <input type="text" id="searchInput" placeholder="Search users..." style="padding: 8px; width: 100%; border-radius: 5px; border: 1px solid #ddd; font-size: 0.95rem;">
                        <button type="button" style="background-color: #1C2E5C; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; margin-left: 5px;">
                            <ion-icon name="search-outline" style="color: white; font-size: 1.2rem;"></ion-icon>
                        </button>
                    </div>
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Created At</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Last Logged In</th> <!-- New column -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John</td>
                                <td>Doe</td>
                                <td>2025-01-28</td>
                                <td>Librarian</td>
                                <td>john.doe@example.com</td>
                                <td>2025-01-25</td> <!-- Example last login date -->
                                <td>
                                    <button class="btn-action delete">Delete</button>
                                    <button class="btn-action archive">Archive</button>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>John</td>
                                <td>Doe</td>
                                <td>2025-01-28</td>
                                <td>Librarian</td>
                                <td>john.doe@example.com</td>
                                <td>2025-01-22</td>
                                <td>
                                    <button class="btn-action delete">Delete</button>
                                    <button class="btn-action archive">Archive</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane</td>
                                <td>Smith</td>
                                <td>2025-01-15</td>
                                <td>User</td>
                                <td>jane.smith@example.com</td>
                                <td>2025-01-10</td>
                                <td>
                                    <button class="btn-action delete">Delete</button>
                                    <button class="btn-action archive">Archive</button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Michael</td>
                                <td>Johnson</td>
                                <td>2024-12-20</td>
                                <td>Librarian</td>
                                <td>michael.johnson@example.com</td>
                                <td>2024-12-18</td>
                                <td>
                                    <button class="btn-action delete">Delete</button>
                                    <button class="btn-action archive">Archive</button>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Emily</td>
                                <td>Davis</td>
                                <td>2024-11-10</td>
                                <td>User</td>
                                <td>emily.davis@example.com</td>
                                <td>2024-11-05</td>
                                <td>
                                    <button class="btn-action delete">Delete</button>
                                    <button class="btn-action archive">Archive</button>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Chris</td>
                                <td>Brown</td>
                                <td>2024-10-05</td>
                                <td>Librarian</td>
                                <td>chris.brown@example.com</td>
                                <td>2024-10-01</td>
                                <td>
                                    <button class="btn-action delete">Delete</button>
                                    <button class="btn-action archive">Archive</button>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Sarah</td>
                                <td>Wilson</td>
                                <td>2024-09-28</td>
                                <td>User</td>
                                <td>sarah.wilson@example.com</td>
                                <td>2024-09-25</td>
                                <td>
                                    <button class="btn-action delete">Delete</button>
                                    <button class="btn-action archive">Archive</button>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>David</td>
                                <td>Martinez</td>
                                <td>2024-08-30</td>
                                <td>User</td>
                                <td>david.martinez@example.com</td>
                                <td>2024-08-28</td>
                                <td>
                                    <button class="btn-action delete">Delete</button>
                                    <button class="btn-action archive">Archive</button>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Linda</td>
                                <td>Garcia</td>
                                <td>2024-07-25</td>
                                <td>Librarian</td>
                                <td>linda.garcia@example.com</td>
                                <td>2024-07-20</td>
                                <td>
                                    <button class="btn-action delete">Delete</button>
                                    <button class="btn-action archive">Archive</button>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>James</td>
                                <td>Anderson</td>
                                <td>2024-06-15</td>
                                <td>User</td>
                                <td>james.anderson@example.com</td>
                                <td>2024-06-10</td>
                                <td>
                                    <button class="btn-action delete">Delete</button>
                                    <button class="btn-action archive">Archive</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>


                    <!-- Pagination -->
                    <div class="pagination-container" style="display: flex; justify-content: center; margin-top: 20px;">
                        <button id="prevBtn" class="pagination-btn" style="padding: 5px 10px; border: none; background-color: #1C2E5C; color: white; border-radius: 5px; cursor: pointer;">Prev</button>
                        <span id="pageInfo" style="margin: 0 15px; font-size: 1rem; align-self: center;">Page 1</span>
                        <button id="nextBtn" class="pagination-btn" style="padding: 5px 10px; border: none; background-color: #1C2E5C; color: white; border-radius: 5px; cursor: pointer;">Next</button>
                    </div>
                </div>

                <!-- Sidebar for Actions -->
                <div class="sidebar" style="flex: 1; max-width: 250px;">
                    <div class="sidebar-tools" style="background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                        <h4 style="margin-bottom: 15px; color: #333;">Actions</h4>
                        <button style="background-color: #1C2E5C; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; font-size: 0.95rem; width: 100%; margin-bottom: 15px;">Add New User</button>
                        <hr>
                        <h5 style="margin-bottom: 10px;">Filter by Role:</h5>
                        <div style="margin-bottom: 10px;">
                            <input type="checkbox" id="filterLibrarian" name="role" value="Librarian">
                            <label for="filterLibrarian" style="font-size: 0.95rem;">Librarian</label>
                        </div>
                        <div>
                            <input type="checkbox" id="filterUser" name="role" value="User">
                            <label for="filterUser" style="font-size: 0.95rem;">User</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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