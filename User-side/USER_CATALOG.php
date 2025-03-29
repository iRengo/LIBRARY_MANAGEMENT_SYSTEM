<?php
session_start();
include '../homepage/db_connect.php';



// Check if the admin session exists
if (!isset($_SESSION['acc_no'])) {
    // If not, show a SweetAlert notification and then redirect
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
window.onload = function() {
// Show SweetAlert notification
Swal.fire({
title: "You are not logged in!",
text: "Please log in to access the page.",
icon: "error",
confirmButtonText: "OK",
allowOutsideClick: false,
allowEscapeKey: false,
willClose: () => {
// Redirect to homepage after the notification is closed
window.location.href = "../homepage/homepage.php";
}
});
}
</script>';
    exit(); // Stop further execution after showing the notification and redirect script
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
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="USER_STYLE2.CSS">
    <link rel="stylesheet" href="User_css/ADMIN_MODAL.css">
    <link rel="stylesheet" href="USER_CATALOG1.CSS">

    <!-- ======= Scripts ====== -->


    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>



</head>

<body>
    <!-- =============== Navigation ================ -->
    <?php include 'HEADER-NAVBAR.PHP' ?>
    <!-- Content HERE -->

    <div class="titles-container">
        <div class="header-container">
            <!-- Available Books -->
            <div class="titles">
                <div class="available">Available Books</div>
            </div>

            <!-- Add Book Button & Search Bar -->


            <!-- Search Bar -->
            <div class="search-bar">
                <input type="text" class="form-control" placeholder="Search books..." id="searchInput">
            </div>
        </div>
    </div>

    <!--content-->
    <!-- Book List -->
    <div class="book-list">
        <?php
        // Fetch books from the database
        $query = "SELECT book_id, book_cover, book_title, book_author FROM tbl_books WHERE status = 'available'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $book_id = $row['book_id'];
                $book_cover = $row['book_cover'];
                $book_title = $row['book_title'];
                $author = $row['book_author'];
        ?>


                <div class="book-main-container">
                    <a href="../Homepage/BOOK-DETAILS.PHP?echo urlencode($book_id); ?>" class="book-link">
                        <div class="book-container">
                            <!-- Book Cover -->
                            <img src="<?php echo htmlspecialchars($book_cover); ?>" class="book-cover" alt="Book Cover">
                        </div>

                        <!-- Book Title and Author -->
                        <div class="book-details">
                            <h5><?php echo htmlspecialchars($book_title); ?></h5>
                            <p><?php echo htmlspecialchars($author); ?></p>
                        </div>
                    </a>
                </div>



        <?php
            }
        } else {
            echo "<p>No available books found.</p>";
        }
        ?>
    </div>

    </div>



    </div>
    <!-- ========================= Main END ==================== -->

    <script>
        // Improved search handling
        document.getElementById('searchInput').addEventListener('input', function() {
            let searchQuery = this.value.trim();

            if (searchQuery.length > 0) {
                fetch(`search_books.php?query=${encodeURIComponent(searchQuery)}`)
                    .then(response => response.json())
                    .then(data => {
                        const bookList = document.querySelector('.book-list');
                        bookList.innerHTML = '';

                        if (data.length > 0) {
                            data.forEach(book => {
                                const bookContainer = document.createElement('div');
                                bookContainer.classList.add('book-main-container');

                                bookContainer.innerHTML = `
<a href="BOOK-DETAILS.PHP?book_id=${encodeURIComponent(book.book_id)}" class="book-link">
<div class="book-container">
<img src="${book.book_cover}" class="book-cover" alt="Book Cover">
</div>
<div class="book-details">
<h5>${book.book_title}</h5>
<p>${book.book_author}</p>
</div>
</a>
`;
                                bookList.appendChild(bookContainer);
                            });
                        } else {
                            bookList.innerHTML = '<p>No books found matching your search.</p>';
                        }
                    })
                    .catch(err => console.error('Error:', err));
            } else {
                loadBooks();
            }
        });

        // Function to load books (initial + search fallback)
        function loadBooks(query = '') {
            fetch(`search_books.php?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    const bookList = document.querySelector('.book-list');
                    bookList.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(book => {
                            const bookContainer = document.createElement('div');
                            bookContainer.classList.add('book-main-container');

                            bookContainer.innerHTML = `
<a href="BOOK-DETAILS.PHP?book_id=${encodeURIComponent(book.book_id)}" class="book-link">
<div class="book-container">
<img src="${book.book_cover}" class="book-cover" alt="Book Cover">
</div>
<div class="book-details">
<h5>${book.book_title}</h5>
<p>${book.book_author}</p>
</div>
</a>
`;
                            bookList.appendChild(bookContainer);
                        });
                    } else {
                        bookList.innerHTML = '<p>No available books found.</p>';
                    }
                });
        }

        // Initial load of books
        document.addEventListener('DOMContentLoaded', () => loadBooks());
    </script>



    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>