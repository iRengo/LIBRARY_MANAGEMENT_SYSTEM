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
        .header-container {
            display: flex;
            justify-content: space-between; /* Push items to opposite sides */
            align-items: center; /* Vertically align items */
            margin-bottom: 20px;
            padding-top: 10px;
            padding-right: 30px; /* Adjust space between elements */
            margin-left: 10px; /* Add a little space on the left side */
        }

        .section-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            padding-top: 5px;
            margin-right: 20px; /* Bring the Available Books title closer to the search bar */
        }

        .search-bar {
            display: flex;
            align-items: center;
            padding-top: 5px;
            margin-left: 0; /* Remove any left margin from the search bar */
        }

        .search-bar input {
            width: 200px;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-bar button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            margin-left: 5px;
        }

        /* Book category adjustments */
        .book-category {
                margin-bottom: 40px;
                margin-left: 20px; /* Add space on the left side of the books */
            }

            .book {
                width: 150px;
                margin-bottom: 20px;
            }

            .book img {
                width: 100%;
                height: auto;
                border-radius: 5px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

        /* .navigation {
            width: 250px;
            background: #333;
            color: white;
            height: 100vh;
            padding: 15px;
            position: fixed;
        }

        .navigation ul {
            list-style: none;
            padding: 0;
        }

        .navigation ul li {
            margin: 20px 0;
        }

        .navigation ul li a {
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
        }

        .navigation ul li a .icon {
            margin-right: 10px;
        }

        .main {
            margin-left: 270px;
            padding: 20px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .topbar .logo {
            display: flex;
            align-items: center;
        }

        .topbar .logo img {
            height: 60px;
            width: 60px;
            padding: 4px;
        } */
    </style>


</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <div class="admin-gradient">
                        <a href="../Guest-side/GUEST_DASHBOARD.php">
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
            
            <div class="header-container">
                <h1 class="section-title">Available Books</h1>
                <div class="search-bar">
                    <input type="text" id="search" placeholder="Search">
                    <button>Search</button>
                </div>
            </div>
            <div class="carousel-container">
                    <h2 style="margin-left: 15px;">Fantasy</h2>
                    <div class="carousel">
                    <div class="carousel-item">
                            <img src="../Guest-side/Book/Lrings.jpg" alt="Fellowship of the Ring">
                            <h5>Lord of The Ring I</h5>
                            <p>Nicolas Cage</p>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/ibong adarna.jpg" alt="Harry Potter 1">
                            <h5>Harry Potter I</h5>
                            <p>David Hume</p>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/hear.jpg" alt="Harry Potter 2">
                            <h5>Harry Potter II</h5>
                            <p>David Hume</p>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/mockingbird.jpg" alt="Harry Potter 3">
                            <h5>Harry Potter III</h5>
                            <p>David Hume</p>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/Lrings.jpg" alt="Harry Potter 4">
                            <h5>Harry Potter IV</h5>
                            <p>David Hume</p>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/pride.jpg" alt="Harry Potter 5">
                            <h5>Harry Potter V</h5>
                            <p>J.K. Rowling</p>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/Prejudice.jpg" alt="Harry Po">
                            <h5>Harry Po</h5>
                            <p>Nicolas Cag</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-container">
                    <h2 style="margin-left: 15px;">Romance</h2>
                    <div class="carousel">
                    <div class="carousel">
                    <div class="carousel-item">
                            <img src="../Guest-side/Book/lord of the ring.jpg" alt="Fellowship of the Ring">
                            <h5>Lord of The Ring I</h5>
                            <p>Nicolas Cage</p>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/pride.jpg" alt="Harry Potter 1">
                            <h5>Harry Potter I</h5>
                            <p>David Hume</p>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/war.jpg" alt="Harry Potter 2">
                            <h5>Harry Potter II</h5>
                            <p>David Hume</p>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/neuromancer.jpg" alt="Harry Potter 3">
                            <h5>Harry Potter III</h5>
                            <p>David Hume</p>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/mockingbird.jpg" alt="Harry Potter 4">
                            <h5>Harry Potter IV</h5>
                            <p>David Hume</p>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/darkness.avif" alt="Harry Potter 5">
                            <h5>Harry Potter V</h5>
                            <p>J.K. Rowling</p>
                        </div>
                        <div class="carousel-item">
                            <img src="../Guest-side/Book/enders.jpg"alt="Harry Po">
                            <h5>Harry Po</h5>
                            <p>Nicolas Cag</p>
            
                        </div>
                    </div>
                </div>
    
</div>



        </div>
        <!-- ========================= Main END ==================== -->
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


        <!-- =========== Scripts =========  -->
        <script src="../Guest-side/Guest_js/GUEST.JS"></script>
        <script src="../Guest-side/Guest_js/GUEST_MODAL.JS"></script>
        <script>
        const searchInput = document.getElementById('search');
        searchInput.addEventListener('input', function () {
            const query = searchInput.value.toLowerCase();
            const books = document.querySelectorAll('.carousel-item'); // Update to target carousel items

            books.forEach(book => {
                const title = book.querySelector('h5').textContent.toLowerCase(); // Target the book title in <h5>
                if (title.includes(query)) {
                    book.style.display = ''; // Show matching items
                } else {
                    book.style.display = 'none'; // Hide non-matching items
                }
            });
        });

    </script>


        <!-- ====== ionicons ======= -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>