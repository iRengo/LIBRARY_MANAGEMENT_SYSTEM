<?php
include '../homepage/db_connect.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">

    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="ADMIN_CATALOG.CSS">

    <link rel="stylesheet" href="admin_modal.php">
    <!-- ======= Scripts ====== -->


    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>



</head>

<body>
    <?php include 'header-navbar.php' ?>

    <!-- Content HERE -->

    <div class="titles-container">
        <div class="header-container">
            <!-- Available Books -->
            <div class="titles">
                <div class="available">Available Books</div>
            </div>

            <!-- Add Book Button & Search Bar -->
            <div class="search-container">
                <div>
                    <button class="btn import-book-btn" onclick="confirmImport()">Import Book</button>

                    <button class="btn add-book-btn" onclick="openAddBookForm()">Add Book</button>
                </div>

                <!-- Search Bar -->
                <div class="search-bar">
                    <input type="text" class="form-control" placeholder="Search books..." id="searchInput">
                </div>
            </div>
        </div>
    </div>


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
                    <div class="book-container">
                        <!-- Book Cover -->
                        <img src="<?php echo htmlspecialchars($book_cover); ?>" class="book-cover" alt="Book Cover">

                        <!-- Overlay Buttons -->
                        <div class="overlay">
                            <button class="archive-btn" onclick="archiveBook(<?php echo $book_id; ?>)">ARCHIVE</button>
                            <button class="delete-btn" onclick="confirmDelete(<?php echo $book_id; ?>)">DELETE</button>
                            <button class="edit-btn" onclick="editBook(<?php echo $book_id; ?>)">EDIT</button>
                        </div>
                    </div>

                    <!-- Book Title and Author (Now below the book-container) -->
                    <div class="book-details">
                        <h5><?php echo htmlspecialchars($book_title); ?></h5>
                        <p><?php echo htmlspecialchars($author); ?></p>

                    </div>

                </div>

        <?php
            }
        } else {
            echo "<p>No available books found.</p>";
        }
        ?>
    </div>

    <script>
        function confirmDelete(bookId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will delete this book!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete handler
                    window.location.href = 'admin_delete_book.php?book_id=' + bookId;
                }
            });
        }

        // Display SweetAlert if a success message exists in the URL
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                Swal.fire({
                    title: 'Deleted!',
                    text: urlParams.get('success'),
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    </script>
    <script>
        // Open SweetAlert2 form for adding a book
        function openAddBookForm() {
            Swal.fire({
                title: 'Add New Book',
                width: '50vw', // Makes the form 80% of the viewport width
                html: `
        <style>
        * {
        text-align:left;

        </style>
            <form id="addBookForm" enctype="multipart/form-data" style="display: flex; flex-wrap: wrap; gap: 10px;">
                <Br><Br>
                <!-- Book Title and Author -->
                <div style="flex: 1; min-width: 48%; display: flex; flex-direction: column;">
                    <label for="bookTitle">Book Title:</label>
                    <input type="text" id="bookTitle" name="bookTitle" class="swal2-input" required>
                </div>
                <div style="flex: 1; min-width: 48%; display: flex; flex-direction: column;">
                <label for="author">Book Author:</label>
                <input type="text" id="author" name="author" class="swal2-input" required>
                </div>

                <!-- Publisher ID and Publication Date -->
                <div style="flex: 1; min-width: 48%; display: flex; flex-direction: column;">
                    <label for="publisher">Publisher</label>
                    <input type="text" id="publisher" name="publisher" class="swal2-input" required>
                </div>
                <div style="flex: 1; min-width: 48%; display: flex; flex-direction: column;">
                    <label for="pubDate">Publication Date:</label>
                    <input type="date" id="pubDate" name="publication_date" class="swal2-input" required>
                </div>

                <!-- ISBN and Genre ID -->
                <div style="flex: 1; min-width: 48%; display: flex; flex-direction: column;">
                    <label for="isbn">ISBN:</label>
                    <input type="text" id="isbn" name="isbn" class="swal2-input" required>
                </div>
                <div style="flex: 1; min-width: 48%; display: flex; flex-direction: column;">
                    <label for="genre">Genre</label>
                    <input type="text" id="genre" name="book_genre" class="swal2-input" required>
                </div>

                <!-- Stocks and Status -->
                <div style="flex: 1; min-width: 48%; display: flex; flex-direction: column;">
                    <label for="stocks">Stocks:</label>
                    <input type="number" id="stocks" name="book_stocks" class="swal2-input" required>
                </div>
                <div style="flex: 1; min-width: 48%; display: flex; flex-direction: column;">
                    <label for="status">Status:</label>
                    <select id="status" name="status" class="swal2-select" required>
                        <option value="available">Available</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>

                <!-- Book Cover (Full Width) -->
                <div style="flex: 1 1 100%; display: flex; flex-direction: column;">
                    <label for="bookCover">Book Cover:</label>
                    <input type="file" id="bookCover" name="bookCover" accept="image/*" class="swal2-file" required>
                </div>

                <!-- Description (Full Width Textarea) -->
                <div style="flex: 1 1 100%; display: flex; flex-direction: column;">
                    <label for="bookDescription">Description:</label>
                    <textarea id="bookDescription" name="bookDescription" class="swal2-textarea" required></textarea>
                </div>

            </form>
        `,
                confirmButtonText: 'Add Book',
                showCancelButton: true,
                preConfirm: () => {
                    const formData = new FormData(document.getElementById('addBookForm'));
                    return fetch('admin_add_book.php', {
                            method: 'POST',
                            body: formData
                        }).then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                throw new Error(data.message || 'Failed to add book');
                            }
                            return data;
                        }).catch(error => {
                            Swal.showValidationMessage(error.message);
                        });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Success!', 'Book added successfully.', 'success')
                        .then(() => location.reload());
                }
            });
        }
        // Submit the book form via AJAX
        function submitBookForm(bookData) {
            const formData = new FormData();
            formData.append('book_cover', bookData.bookCover); // Book Cover (file)
            formData.append('book_title', bookData.bookTitle); // Book Title
            formData.append('book_description', bookData.bookDescription); // Description
            formData.append('publisher_id', bookData.publisherId); // Publisher (ID)
            formData.append('publication_date', bookData.publicationDate); // Date
            formData.append('isbn', bookData.isbn); // ISBN
            formData.append('book_genre_id', bookData.bookGenreId); // Genre (ID)
            formData.append('book_stocks', bookData.bookStocks); // Stocks
            formData.append('status', bookData.status); // Status (e.g., available/unavailable)

            fetch('admin_add_book.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success!', 'Book added successfully.', 'success')
                            .then(() => location.reload()); // Reload to see new book
                    } else {
                        Swal.fire('Error!', data.error || 'Failed to add book.', 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                });
        }

        // Confirm Delete Function
        function confirmDelete(bookId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will delete this book!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'admin_delete_book.php?book_id=' + bookId;
                }
            });
        }
    </script>
    <script>
        // Function to confirm and trigger book import
        function confirmImport() {
            Swal.fire({
                title: 'Import Books?',
                text: 'This will fetch and add books to your catalog.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Import',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                // ✅ If user clicks "Yes, Import", call the fetch function
                if (result.isConfirmed) {
                    fetchGutenbergBooks();
                }
            });
        }

        // Function to call fetch_gutenburg.php using AJAX
        function fetchGutenbergBooks() {
            fetch('fetch_gutenburg.php')
                .then(response => response.json()) // Parse JSON response
                .then(data => {
                    // ✅ If success, show a success message
                    if (data.success) {
                        Swal.fire('Success!', data.message, 'success')
                            .then(() => location.reload()); // Reload to show new books
                    } else {
                        // ❌ Handle errors
                        Swal.fire('Error!', data.message || 'Failed to import books.', 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error!', 'An error occurred while importing books.', 'error');
                });
        }
    </script>
    <script>
document.getElementById('searchInput').addEventListener('input', function() {
    let searchQuery = this.value; // Get the value from the search input field

    if (searchQuery.length > 0) {
        // Send AJAX request to search_books.php with the search query
        fetch(`search_books.php?query=${encodeURIComponent(searchQuery)}`)
            .then(response => response.json()) // Parse the response as JSON
            .then(data => {
                // Clear the current book list
                const bookList = document.querySelector('.book-list');
                bookList.innerHTML = '';

                // Check if any books were found
                if (data.length > 0) {
                    // Loop through the books and display them
                    data.forEach(book => {
                        const bookContainer = document.createElement('div');
                        bookContainer.classList.add('book-main-container');

                        bookContainer.innerHTML = `
                            <div class="book-container">
                                <!-- Book Cover -->
                                <img src="${book.book_cover}" class="book-cover" alt="Book Cover">

                                <!-- Overlay Buttons -->
                                <div class="overlay">
                                    <button class="archive-btn" onclick="archiveBook(${book.book_id})">ARCHIVE</button>
                                    <button class="delete-btn" onclick="confirmDelete(${book.book_id})">DELETE</button>
                                    <button class="edit-btn" onclick="editBook(${book.book_id})">EDIT</button>
                                </div>
                            </div>

                            <!-- Book Title and Author -->
                            <div class="book-details">
                                <h5>${book.book_title}</h5>
                                <p>${book.book_author}</p>
                            </div>
                        `;
                        bookList.appendChild(bookContainer); // Add the book to the list
                    });
                } else {
                    bookList.innerHTML = '<p>No books found matching your search.</p>';
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Something went wrong. Please try again.');
            });
    } else {
        // If the search query is empty, reload the books list
        loadBooks();
    }
});

// Function to load all books initially (if needed when search is empty)
function loadBooks() {
    fetch('search_books.php?query=')
        .then(response => response.json())
        .then(data => {
            const bookList = document.querySelector('.book-list');
            bookList.innerHTML = ''; // Clear the book list

            if (data.length > 0) {
                data.forEach(book => {
                    const bookContainer = document.createElement('div');
                    bookContainer.classList.add('book-main-container');

                    bookContainer.innerHTML = `
                        <div class="book-container">
                            <!-- Book Cover -->
                            <img src="${book.book_cover}" class="book-cover" alt="Book Cover">

                            <!-- Overlay Buttons -->
                            <div class="overlay">
                                <button class="archive-btn" onclick="archiveBook(${book.book_id})">ARCHIVE</button>
                                <button class="delete-btn" onclick="confirmDelete(${book.book_id})">DELETE</button>
                                <button class="edit-btn" onclick="editBook(${book.book_id})">EDIT</button>
                            </div>
                        </div>

                        <!-- Book Title and Author -->
                        <div class="book-details">
                            <h5>${book.book_title}</h5>
                            <p>${book.book_author}</p>
                        </div>
                    `;
                    bookList.appendChild(bookContainer);
                });
            } else {
                bookList.innerHTML = '<p>No available books found.</p>';
            }
        });
}

// Initial load of books
loadBooks();

        </script>

    <!-- ========================= Main END ==================== -->


    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>