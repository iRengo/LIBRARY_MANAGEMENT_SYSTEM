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
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="ADMIN_STYLES2.CSS">
    <link rel="stylesheet" href="ADMIN_MODAL.css">
    <link rel="stylesheet" href="ADMIN_modals.css">

    <!-- ======= Scripts ====== -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php include 'header-navbar.php' ?>
    <!-- ========================= Main ==================== -->
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
        </div>
        <!-- Back Button -->
        <div class="back">
            <a href="javascript:history.back()" class="btn btn-back">
                <ion-icon name="arrow-back-outline" class="me-2"></ion-icon>
                Back
            </a>
        </div>


        <!-- Left and Right Panel Section -->
        <div class="row mt-5">
            <!-- Left Panel: Title, Description, Genre -->
            <div class="col-md-6">
                <h2>The Last Four Things</h2>
                <p><strong>Description:</strong> TIn Along for the Ride by Sarah Dessen, Auden spends the summer in a beach town with her dad’s new family, feeling out of place. She meets Eli, a quiet, adventurous guy, and together they explore the town at night. Through their friendship, Auden learns to open up and enjoy life.</p>
                <!-- New Text Added Below Description -->
                <p>2005 • 18+ • Romance • 13 chp</p>

                <div class="btn-group" role="group">
                    <a href="ADMIN_BOOK_BORROW.php" class="btn btn-borrow">Borrow</a>
                    <a href="#sneakpeek" class="btn btn-sneakpeek">Sneak Peek</a>
                </div>

            </div>

            <!-- Right Panel: Image -->
            <div class="col-md-6">
                <img src="https://www.creativindiecovers.com/wp-content/uploads/2012/02/9780718155209.jpg" class="img-fluid" alt="Book Cover">
            </div>
        </div>
        <!-- ========================= Suggested Books ==================== -->
        <div class="suggested-books mt-5">
            <h3>Suggested Books</h3>
            <div class="row">
                <div class="col-md-2">
                    <a href="modal1.php">
                        <img src="https://ph.bbwbooks.com/cdn/shop/products/9780374351281_1_347413de-9f1c-468a-89b3-f0b2c0e408e0_600x.jpg?v=1625489251"
                            class="img-fluid"
                            alt="Suggested Book 1">
                    </a>
                </div>
                <div class="col-md-2">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRU--MXPOfwwWTvR9vCB2UkzeiBeX9ZkGayag&s" class="img-fluid" alt="Suggested Book 2">
                </div>
                <div class="col-md-2">
                    <img src=https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQKYmrUbkRM3aWolsdDNGGUz9mgkcWlYTZyMY6yRBCbNknziBqxaeyCTBsmgYa1p86AHxg&usqp=CAU" class="img-fluid" alt="Suggested Book 3">
                </div>
                <div class="col-md-2">
                    <img src="https://lbabooks.com/assets/books/_small/411NFkiBKwL-1.jpg" class="img-fluid" alt="Suggested Book 4">
                </div>
                <div class="col-md-2">
                    <img src="https://lbabooks.com/assets/books/_small/Before-We-Say-Goodbye-cover.jpg" class="img-fluid" alt="Suggested Book 5">
                </div>
                <div class="col-md-2">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRU--MXPOfwwWTvR9vCB2UkzeiBeX9ZkGayag&s" class="img-fluid" alt="Suggested Book 5">
                </div>
            </div>
        </div>
    </div>
    </div>

    

    <!-- =========== Scripts =========  -->
    <script src="admin.js"></script>
    <script src="ADMIN_MODAL.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>