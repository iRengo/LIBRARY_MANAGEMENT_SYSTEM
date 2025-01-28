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
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            .header {
                background-color: rgb(160, 87, 87);
                padding: 20px;
                text-align: center;
            }

            .header h1 {
                margin: 0;
            }

            .content {
                padding: 20px;
            }

            .welcome {
                text-align: left;
                margin-bottom: 20px;
            }

            .dashboard-container {
            display: flex;
            justify-content: space-between; /* Add space between the metrics and books */
            padding: 20px;
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            width: 70%; /* Take up 70% of the space for the metrics */
            height:150%;
        }

        .dashboard .metric {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
            background-color: #738ea7;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-size: 1rem;
            color: #ffffff;
        }

        .dashboard .metric2 {
            background-color: #a39393;
        }

        .dashboard .metric3 {
            background-color: #5c5555;
        }

        .dashboard .metric4 {
            background-color: #8f85d5;
        }

        .dashboard .metric ion-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .dashboard .metric h2 {
            font-size: 1.2rem;
            margin: 5px 0;
        }

        .dashboard .metric p {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
        }
        .books {
        background-color: #fff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: 28%; /* Take up 28% of the space for the books section */
        margin-top: 0; /* Removed extra margin-top to align with dashboard */
        height: 100%; /* Ensure the book section matches the height of the dashboard */
    }

    .book-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* 2 items per row */
        gap: 15px;
    }

    .book {
        text-align: center;
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        font-size: 0.9rem; /* Reduce the font size */
        
    }

    .book img {
        width: 100%; /* Ensure the image fits inside */
        height: 150px; /* Set a fixed height */
        object-fit: cover; /* Maintain aspect ratio */
        border-radius: 5px;
    }

    .book h3 {
        margin: 10px 0 5px;
    }

    .book p {
        margin: 0;
    }
    .table-container {
    margin-top: 20px; /* Space between metrics and table */
    padding: 0 20px; /* Align with dashboard metrics */
    
}

.dashboard-container {
    display: flex;
    justify-content: space-between;
    padding: 20px;
}

.dashboard {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    width: 70%;
}

.dashboard-container {
    display: flex;
    justify-content: space-between;
    padding: 20px;
}

.dashboard {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    width: 70%; /* Metrics take up 70% */
}

.books {
    width: 28%; /* Books take up 28% */
    margin-top: 0;
}

.dashboard-container {
    display: flex;
    justify-content: space-between;
    padding: 20px;
}

.dashboard {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    width: 70%;
}


.table-and-books {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 20px;
    margin-top: 20px; /* Space below metrics */
}

.table-container {
    width: 70%; /* Matches the width of the metrics */
}

.table-small {
    width: 710%; /* Full width inside its container */
    border-collapse: collapse;
}

.table-small th, .table-small td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
    font-size: 0.9rem; /* Smaller font size */
}

.table-small th {
    background-color: #333;
    color: white;
}

.table-small tr:nth-child(even) {
    background-color: #f9f9f9;
}

.table-small tr:hover {
    background-color: #f1f1f1;
}
.carousel-container {
            margin: 20px 0;
        }

        .carousel {
            display: flex;
            overflow-x: auto;
            gap: 15px;
            padding: 10px;
        }

        .carousel::-webkit-scrollbar {
            display: none;
        }

        .carousel-item {
            flex: 0 0 auto;
            width: 200px;
            text-align: center;
            background-color: #fff; /* Optional: Adds a background to enhance the shadow effect */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Adds a subtle shadow */
            border-radius: 5px; /* Keeps the edges rounded */
            padding: 10px; /* Adds padding inside the items */
            transition: transform 0.3s, box-shadow 0.3s; /* Smooth transition for hover effect */
        }
        .carousel-item:hover {
            transform: scale(1.05); /* Slightly enlarges the item on hover */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Makes the shadow more prominent on hover */
        }


        .carousel-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }

        .carousel-item h5 {
            margin: 10px 0 5px;
            font-size: 1rem;
            font-weight: bold;
        }

        .carousel-item p {
            margin: 0;
            font-size: 0.9rem;
        }

    

            .action-buttons {
                display: flex;
                gap: 10px;
                justify-content: center;
            }
            .btn {
                padding: 5px 10px;
                border: none;
                border-radius: 3px;
                color: white;
                cursor: pointer;
            }
            .btn-info {
                background-color: #007bff;
            }
            .btn-add {
                background-color: #28a745;
            }
            .book-card {
                text-align: center;
            }
            .book-card img {
                width: 100%;
                height: 250px;
                object-fit: cover;
            }
            .badge {
                margin-right: 5px;
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
                    <!-- Content HERE -->
                    <div class="content">
                    <div class="welcome">
                        <h2>Welcome, Guest!</h2>
                        <p>Last Login: ###</p>
                    </div>
                    <div class="dashboard-container">
    <!-- Metrics Section -->
    <div class="dashboard">
        <div class="metric">
            <ion-icon name="book-outline"></ion-icon>
            <h2>BORROWED</h2>
            <p>10</p>
        </div>
        <div class="metric metric2">
            <ion-icon name="timer-outline"></ion-icon>
            <h2>INCOMING DUE</h2>
            <p>5</p>
        </div>
        <div class="metric metric3">
            <ion-icon name="alert-circle-outline"></ion-icon>
            <h2>OVERDUE</h2>
            <p>###</p>
        </div>
        <div class="metric metric4">
            <ion-icon name="clipboard-outline"></ion-icon>
            <h2>RESERVED</h2>
            <p>7</p>
        </div>
        <!-- Table Section -->
<div class="table-container">
    <table class="table-small">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Not Available</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-info">INFO</button>
                        <button class="btn btn-add">ADD</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Not Available</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-info">INFO</button>
                        <button class="btn btn-add">ADD</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Not Available</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-info">INFO</button>
                        <button class="btn btn-add">ADD</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
    </div>

    <!-- New Arrived Section -->
    <div class="books">
        <h2>New Arrived</h2>
        <div class="book-grid">
            <div class="book">
                <img src="../Guest-side/Book/ibong adarna.jpg" alt="Ibong Adarna">
                <h3>Ibong Adarna</h3>
                <p>Francisco Balagtas</p>
                <p>Action</p>
            </div>
            <div class="book">
                <img src="../Guest-side/Book/lord of the ring.jpg" alt="Lord of the Rings">
                <h3>Lord of the Rings</h3>
                <p>J.R.R. Tolkien</p>
                <p>Fantasy</p>
            </div>
        </div>
    </div>
</div>
        <div class="carousel-container">
                    <h2>Available</h2>
                    <div class="carousel">
                    <div class="carousel-item">
                            <img src="../Guest-side/Book/1984.jpg" alt="Fellowship of the Ring">
                            <h5>Lord of The Ring I</h5>
                            <p>Nicolas Cage</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/arcnae.jpg" alt="Harry Potter 1">
                            <h5>Harry Potter I</h5>
                            <p>David Hume</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/catcher.jpg" alt="Harry Potter 2">
                            <h5>Harry Potter II</h5>
                            <p>David Hume</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/gatsby.jpg" alt="Harry Potter 3">
                            <h5>Harry Potter III</h5>
                            <p>David Hume</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/hitch.jpg" alt="Harry Potter 4">
                            <h5>Harry Potter IV</h5>
                            <p>David Hume</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/ibong adarna.jpg" alt="Harry Potter 5">
                            <h5>Harry Potter V</h5>
                            <p>J.K. Rowling</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/lord of the ring.jpg" alt="Harry Po">
                            <h5>Harry Po</h5>
                            <p>Nicolas Cag</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                    </div>
                </div>
                <div class="carousel-container">
                    <h2>Recommended</h2>
                    <div class="carousel">
                        <div class="carousel-item">
                                <img src="../Guest-side/Book/Lrings.jpg" alt="Fellowship of the Ring">
                                <h5>Lord of The Ring I</h5>
                                <p>Nicolas Cage</p>
                                <span class="badge bg-danger">Horror</span>
                                <span class="badge bg-primary">Fiction</span>
                            </div>
                        <div class="carousel-item">
                                <img src="../Guest-side/Book/moby.jpg" alt="Fellowship of the Ring">
                                <h5>Lord of The Ring I</h5>
                                <p>Nicolas Cage</p>
                                <span class="badge bg-danger">Horror</span>
                                <span class="badge bg-primary">Fiction</span>
                            </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/mockingbird.jpg" alt="Fellowship of the Ring">
                            <h5>Lord of The Ring I</h5>
                            <p>Nicolas Cage</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/pride.jpg" alt="The Two Towers">
                            <h5>The Two Towers</h5>
                            <p>Nicolas Cage</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/war.jpg" alt="The Return of the King">
                            <h5>Lord of The Rings III</h5>
                            <p>Nicolas Cage</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/Prejudice.jpg" alt="Florante at Laura">
                            <h5>Florante at Laura</h5>
                            <p>Nicolas Cage</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/Wind.webp" alt="Chronicles of Narnia">
                            <h5>The Chron</h5>
                            <p>C.S. Lewis</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                    </div>
                </div>
                <div class="carousel-container">
                    <h2>Browse - Only</h2>
                    <div class="carousel">
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/Game of thrones.jpeg" alt="Harry Potter VII">
                            <h5>Harry Potter VII</h5>
                            <p>Nicolas Cage</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/dune.jpg" alt="The Name of the Wind">
                            <h5>The Name of the Wind</h5>
                            <p>Patrick Rothfuss</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/mist.avif" alt="The Hobbit">
                            <h5>The Hobbit</h5>
                            <p>J.R.R. Tolkien</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/enders.jpg" alt="The Lightning Thief">
                            <h5>The Lightning Thief</h5>
                            <p>Rick Riordan</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/darkness.avif" alt="Harry Po">
                            <h5>Harry Po</h5>
                            <p>Nicolas Cage</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/neuromancer.jpg" alt="Fellowship of the Ring">
                            <h5>Lord of The Ring I</h5>
                            <p>Nicolas Cage</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/hear.jpg" alt="Fellowship of the Ring">
                            <h5>Lord of The Ring I</h5>
                            <p>Nicolas Cage</p>
                            <span class="badge bg-danger">Horror</span>
                            <span class="badge bg-primary">Fiction</span>
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