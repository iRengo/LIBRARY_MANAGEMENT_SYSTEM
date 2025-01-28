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
            <link rel="stylesheet" href="../Guest-side/Guest_css/GUEST_STYLE2.css">
            <link rel="stylesheet" href="../Guest-side/Guest_css/GUEST_MODAL.CSS">

            <!-- ======= Scripts ====== -->


            <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
            <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        </head>
        <style>


h1 {
    text-align: left;
    font-size: 24px;
    margin-bottom: 20px;
}

.book-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); /* Slightly increased */
    gap: 20px;
    margin-left: 15px;
}

.book-card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    padding: 10px; /* Added slight padding */
}
.book-card:hover {
    transform: scale(1.05); /* Slight zoom */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3); /* More pronounced shadow */
}

.book-card img {
    width: 100%; /* Makes sure it scales with the card */
    height: 220px; /* Increased the height slightly */
    object-fit: cover; /* Keeps aspect ratio */
    display: block;
}

.book-card .info {
    padding: 15px;
}

.book-card .info h3 {
    font-size: 18px; /* Slightly bigger text */
    margin: 0;
    margin-bottom: 5px;
}

.book-card .info p {
    font-size: 14px;
    color: #555;
    margin: 0;
    margin-bottom: 10px;
}
.book-card .colors {
    display: flex;
    gap: 5px;
}

.color-box {
    width: 15px;
    height: 15px;
    border-radius: 3px;
}

.color-red {
    background-color: #d32f2f;
}

.color-purple {
    background-color: #7b1fa2;
}

.color-blue {
    background-color: #1976d2;
}
            .collection-card {
                position: relative;
                background: url('../Guest-side/Book/neuromancer.jpg') no-repeat center center/cover;
                height: 300px;
                width: 98%;
                margin: 0 auto;
                color: white;
                border-radius: 8px;
                overflow: hidden;
            }
            .collection-card::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: inherit; /* Use the same background image */
                filter: blur(8px); /* Blur effect */
                transform: scale(1.1); /* Slightly scale up to hide edges caused by blur */
                z-index: 1;
            }
            .collection-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.7);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                z-index: 2; /* Place overlay on top of the blur */
            }

            .lock-icon {
                font-size: 5rem; /* Increased icon size */
                margin-bottom: 1.5rem; /* Adjust spacing */
            }

            .collection-overlay button {
                font-size: 1.2rem; /* Larger font size for the button text */
                padding: 0.75rem 1.5rem; /* Increased padding */
                border-radius: 0.5rem; /* Slightly rounded corners */
                font-weight: bold; /* Make the text bold */
            }

            .collection-overlay button:hover {
                background-color: #004085; /* Darker shade for hover effect */
            }

            .samples-grid img {
                height: 200px;
                object-fit: cover;
                border-radius: 5px;
            }
        </style>
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
                                    <span class="title1">GUEST</span>
                                </a>
                            </div>
                        </li>

                        <li>
                            <a href="../Guest-side/GUEST_DASHBOARD.php">
                                <span class="icon">
                                    <ion-icon name="home-outline"></ion-icon>
                                </span>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="../Guest-side/GUEST_COLLECTION.php">
                                <span class="icon">
                                    <ion-icon name="file-tray-stacked-outline"></ion-icon>

                                </span>
                                <span class="title">Collection</span>
                            </a>
                        </li>

                        <li>
                            <a href="../Guest-side/GUEST_CATALOG.php">
                                <span class="icon">
                                    <ion-icon name="book-outline"></ion-icon>
                                </span>
                                <span class="title">Catalog</span>
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
                    <br>
                        <div class="container mt-4">
                <!-- My Collections Section -->
                <h1 class="mb-4" style="margin-left: 50px;">My Collections</h1>
                    <div style="position: absolute; top: 15px; right: 200px; display: flex; align-items: center;">
                        <label for="searchBy" style="margin-right: 8px; font-weight: bold;">Search By:</label>
                        <select id="searchBy" class="form-select" style="width: 150px;" aria-label="Select Options">
                            <option selected>Select Date</option>
                            <option value="1">September</option>
                            <option value="2">October</option>
                            <option value="3">December</option>
                        </select>
                    </div>
                <br>
                <div class="collection-card mb-4">
                    <div class="collection-overlay">
                        <div class="lock-icon">🔒</div> <!-- Large icon -->
                        <h1>Unlock this feature by signing up</h1>
                        <button class="btn btn-primary">Become Member</button> <!-- Larger button -->
                    </div>
                </div>
                <br>
                <div class="container">
        <h1 style="margin-left: 50px;">SAMPLES</h1>
        <div class="book-grid">
        <div class="book-card">
        <img src="../Guest-side/Book/Prejudice.jpg" alt="Harry Potter II">
            <div class="info">
                <h3>Ibong Adarna</h3>
                <p>Francisco Balagtas</p>
                <div class="colors">
                    <div class="color-box color-purple"></div>
                </div>
            </div>
        </div>
        
        <div class="book-card">
         <img src="../Guest-side/Book/Prejudice.jpg" alt="Harry Potter II">
            <div class="info">
                <h3>Lord of the Rings</h3>
                <p>J.R.R. Tolkien</p>
                <div class="colors">
                    <div class="color-box color-red"></div>
                </div>
            </div>
        </div>
        
        <div class="book-card">
            <<img src="../Guest-side/Book/Prejudice.jpg" alt="Harry Potter II">
            <div class="info">
                <h3>Harry Potter I</h3>
                <p>David Hume</p>
                <div class="colors">
                    <div class="color-box color-red"></div>
                    <div class="color-box color-purple"></div>
                </div>
            </div>
        </div>
        
        <div class="book-card">
            <img src="../Guest-side/Book/Prejudice.jpg" alt="Harry Potter II">
            <div class="info">
                <h3>Harry Potter II</h3>
                <p>David Hume</p>
                <div class="colors">
                    <div class="color-box color-red"></div>
                </div>
            </div>
        </div>

        <div class="book-card">
            <img src="../Guest-side/Book/1984.jpg" alt="Harry Potter III">
            <div class="info">
                <h3>Harry Potter III</h3>
                <p>David Hume</p>
                <div class="colors">
                    <div class="color-box color-red"></div>
                </div>
            </div>
        </div>

        <div class="book-card">
            <img src="../Guest-side/Book/Prejudice.jpg" alt="Harry Potter IV">
            <div class="info">
                <h3>Harry Potter IV</h3>
                <p>David Hume</p>
                <div class="colors">
                    <div class="color-box color-purple"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="logoutModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Confirm Logout</h2>
                    <p>Are you sure you want to logout?</p>
                    <div class="modal-actions">
                        <a href="../Homepage/HOMEPAGE.PHP" class="btn-action btn-yes">Yes</a>
                        <button class="btn-action btn-no" id="cancelLogout">No</button>
                    </div>
                </div>
            </div>



                <!-- ========================= Main END ==================== -->



                <!-- =========== Scripts =========  -->
                <script src="../Guest-side/Guest_js/GUEST.JS"></script>
                <script src="../Guest-side/Guest_js/GUEST_MODAL.JS"></script>


                <!-- ====== ionicons ======= -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

                <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
                <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

        </body>

        </html>