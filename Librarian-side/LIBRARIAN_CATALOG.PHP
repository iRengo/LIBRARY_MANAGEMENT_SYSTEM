<?php
session_start();
include '../Homepage/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Librarian Catalog</title>
    <link rel="stylesheet" href="LIBRARIAN_CATALOG.CSS">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>


    <!-- Available Books Section -->
    <div class="titles-container">
        <div class="header-container">
            <div class="titles" style="display: flex; align-items: center; gap: 20px;">
                <div class="available" style="font-size: 1.5rem; font-weight: bold;">Available Books</div>

                <!-- Add Book Button -->
                <button onclick="openAddBookForm()" style="
                background-color: #4CAF50;
                color: white;
                padding: 8px 16px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 0.9rem;
            ">
                    + Add Book
                </button>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <input type="text" class="form-control" placeholder="Search available books..." id="searchAvailableInput">
            </div>
        </div>
    </div>


    <!-- Available Book List -->
    <div class="book-list" id="available-book-list">
        <?php
        $limit = 14;
        $query_available = "
        SELECT 
            b.book_id, 
            b.book_cover, 
            b.book_title, 
            b.book_author, 
            b.book_stocks, 
            COUNT(bb.book_id) AS borrow_count
        FROM tbl_books b
        LEFT JOIN borrowed_books bb ON b.book_id = bb.book_id AND bb.status = 'returned'
        WHERE b.status = 'available'
        GROUP BY b.book_id
        ORDER BY borrow_count DESC
        LIMIT $limit
    ";

        $result = mysqli_query($conn, $query_available);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $book_id = $row['book_id'];
                $book_cover = $row['book_cover'];
                $book_title = $row['book_title'];
                $author = $row['book_author'];
                $borrow_count = $row['borrow_count'];
                $book_stocks = (int)$row['book_stocks'];

                if ($book_stocks >= 21 && $book_stocks <= 30) {
                    $stock_class = 'stock-high';
                } elseif ($book_stocks >= 11 && $book_stocks <= 20) {
                    $stock_class = 'stock-medium';
                } else {
                    $stock_class = 'stock-low';
                }
        ?>
                <div class="book-main-container" data-book-id="<?php echo $book_id; ?>">
                    <a href="BOOK-DETAILS.PHP?book_id=<?php echo urlencode($book_id); ?>" class="book-link">
                        <div class="book-container">
                            <img src="<?php echo htmlspecialchars($book_cover); ?>" class="book-cover" alt="Book Cover">
                        </div>
                        <div class="book-details">
                            <div>
                                <span class="borrow-count"><?php echo $borrow_count; ?> borrows</span>
                                <span class="stock-badge <?php echo $stock_class; ?>"><?php echo $book_stocks; ?> left</span>
                            </div>
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

    <button id="toggleAvailableBooks">Show More</button>

    <script>
        const limit = <?php echo $limit; ?>;
        const toggleBtn = document.getElementById('toggleAvailableBooks');
        const bookList = document.getElementById('available-book-list');
        let showingAll = false;
        let allBooks = [];

        // Helper function to render books
        function renderBooks(booksToRender) {
            bookList.innerHTML = '';
            booksToRender.forEach(book => {
                let stockClass = 'stock-low';
                if (book.book_stocks >= 21 && book.book_stocks <= 30) stockClass = 'stock-high';
                else if (book.book_stocks >= 11 && book.book_stocks <= 20) stockClass = 'stock-medium';

                const div = document.createElement('div');
                div.classList.add('book-main-container');
                div.setAttribute('data-book-id', book.book_id);

                div.innerHTML = `
<a href="BOOK-DETAILS.PHP?book_id=${encodeURIComponent(book.book_id)}" class="book-link">
  <div class="book-container">
    <img src="${book.book_cover}" class="book-cover" alt="Book Cover">
  </div>
  <div class="book-details">
    <div>
      <span class="borrow-count">${book.borrow_count} borrows</span>
      <span class="stock-badge ${stockClass}">${book.book_stocks} left</span>
    </div>
    <h5>${book.book_title}</h5>
    <p>${book.book_author}</p>
  </div>
</a>
      `;

                bookList.appendChild(div);
            });
        }

        toggleBtn.addEventListener('click', () => {
            // Add fade-out class to trigger opacity transition
            bookList.classList.add('fade-out');

            setTimeout(() => {
                if (!showingAll) {
                    // Fetch all books
                    fetch(`fetch_more_books.php?all=true`)
                        .then(res => res.json())
                        .then(data => {
                            allBooks = data;
                            renderBooks(data);
                            toggleBtn.textContent = 'Show Less';
                            showingAll = true;
                            bookList.classList.remove('fade-out'); // fade-in
                        })
                        .catch(err => {
                            console.error('Error fetching all books:', err);
                            bookList.classList.remove('fade-out'); // fade-in even if error
                        });
                } else {
                    // Show limited books from cached allBooks or fallback to limit
                    const limitedBooks = allBooks.length > 0 ? allBooks.slice(0, limit) : [];
                    renderBooks(limitedBooks);
                    toggleBtn.textContent = 'Show More';
                    showingAll = false;
                    bookList.classList.remove('fade-out'); // fade-in
                }
            }, 500); // match CSS transition duration (0.5s)
        });
    </script>


    <!-- Upcoming Books Section -->
    <div class="titles-container" style="margin-top: 40px;">
        <div class="header-container">
            <div class="titles">
                <div class="upcoming">Upcoming Books</div>
            </div>
            <div class="search-bar">
                <input type="text" class="form-control" placeholder="Search upcoming books..." id="searchUpcomingInput">
            </div>
        </div>
    </div>

    <!-- Upcoming Book List -->
    <div class="book-list" id="upcoming-book-list">
        <?php
        $query_upcoming = "
        SELECT 
            b.book_id, 
            b.book_cover, 
            b.book_title, 
            b.book_author, 
            b.book_stocks, 
            COUNT(bb.book_id) AS borrow_count
        FROM tbl_books b
        LEFT JOIN borrowed_books bb ON b.book_id = bb.book_id AND bb.status = 'returned'
        WHERE b.status = 'upcoming'
        GROUP BY b.book_id
        ORDER BY borrow_count DESC
    ";

        $result_upcoming = mysqli_query($conn, $query_upcoming);

        if (mysqli_num_rows($result_upcoming) > 0) {
            while ($row = mysqli_fetch_assoc($result_upcoming)) {
                $book_id = $row['book_id'];
                $book_cover = $row['book_cover'];
                $book_title = $row['book_title'];
                $author = $row['book_author'];
                $borrow_count = $row['borrow_count'];
                $book_stocks = (int)$row['book_stocks'];

                // Determine stock badge class
                if ($book_stocks >= 21 && $book_stocks <= 30) {
                    $stock_class = 'stock-high';
                } elseif ($book_stocks >= 11 && $book_stocks <= 20) {
                    $stock_class = 'stock-medium';
                } else {
                    $stock_class = 'stock-low';
                }
        ?>
                <div class="book-main-container">
                    <a href="BOOK-DETAILS.PHP?book_id=<?php echo urlencode($book_id); ?>" class="book-link">
                        <div class="book-container">
                            <img src="<?php echo htmlspecialchars($book_cover); ?>" class="book-cover" alt="Book Cover">
                        </div>
                        <div class="book-details">
                            <div>
                                <span class="borrow-count"><?php echo $borrow_count; ?> borrows</span>
                                <span class="stock-badge <?php echo $stock_class; ?>"><?php echo $book_stocks; ?> left</span>
                            </div>
                            <h5><?php echo htmlspecialchars($book_title); ?></h5>
                            <p><?php echo htmlspecialchars($author); ?></p>
                        </div>
                    </a>
                </div>
        <?php
            }
        } else {
            echo "<p>No upcoming books found.</p>";
        }
        ?>
    </div>

    <!-- JavaScript Search -->
    <script>
        const searchInput = document.getElementById('searchAvailableInput');
        const bookList1 = document.getElementById('available-book-list');

        // Updated search event for Available Books
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();

            if (query.length === 0) {
                // If empty, revert view
                if (showingAll && allBooks.length > 0) {
                    renderBooks(allBooks);
                } else {
                    fetch('fetch_more_books.php?all=true')
                        .then(res => res.json())
                        .then(data => {
                            renderBooks(data.slice(0, limit));
                        })
                        .catch(err => console.error('Error restoring limited books:', err));
                }
                return;
            }

            fetch(`librarian_catalog_search.php?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    bookList1.innerHTML = '';

                    if (data.length > 0) {
                        renderBooks(data);
                    } else {
                        bookList1.innerHTML = '<p>No available books found matching your search.</p>';
                    }
                })
                .catch(err => console.error('Search error:', err));
        });

        // Search for Upcoming Books
        document.getElementById('searchUpcomingInput').addEventListener('input', function() {
            let searchQuery = this.value.trim();

            if (searchQuery.length > 0) {
                fetch(`search_books.php?query=${encodeURIComponent(searchQuery)}&status=upcoming`)
                    .then(response => response.json())
                    .then(data => {
                        const bookList = document.getElementById('upcoming-book-list');
                        bookList.innerHTML = '';

                        if (data.length > 0) {
                            data.forEach(book => {
                                const bookContainer = document.createElement('div');
                                bookContainer.classList.add('book-main-container');

                                let stockClass = 'stock-low';
                                if (book.book_stocks >= 21 && book.book_stocks <= 30) stockClass = 'stock-high';
                                else if (book.book_stocks >= 11 && book.book_stocks <= 20) stockClass = 'stock-medium';

                                bookContainer.innerHTML = `
<a href="BOOK-DETAILS.PHP?book_id=${encodeURIComponent(book.book_id)}" class="book-link">
    <div class="book-container">
        <img src="${book.book_cover}" class="book-cover" alt="Book Cover">
    </div>
    <div class="book-details">
        <div>
            <span class="borrow-count">${book.borrow_count} borrows</span>
            <span class="stock-badge ${stockClass}">${book.book_stocks} left</span>
        </div>
        <h5>${book.book_title}</h5>
        <p>${book.book_author}</p>
    </div>
</a>`;
                                bookList.appendChild(bookContainer);
                            });
                        } else {
                            bookList.innerHTML = '<p>No upcoming books found matching your search.</p>';
                        }
                    })
                    .catch(err => console.error('Error:', err));
            } else {
                loadBooks('upcoming');
            }
        });

        // Load books by status
        function loadBooks(status = 'available') {
            fetch(`search_books.php?status=${encodeURIComponent(status)}`)
                .then(response => response.json())
                .then(data => {
                    const listId = status === 'available' ? 'available-book-list' : 'upcoming-book-list';
                    const bookList = document.getElementById(listId);
                    bookList.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(book => {
                            const bookContainer = document.createElement('div');
                            bookContainer.classList.add('book-main-container');

                            let stockClass = 'stock-low';
                            if (book.book_stocks >= 21 && book.book_stocks <= 30) stockClass = 'stock-high';
                            else if (book.book_stocks >= 11 && book.book_stocks <= 20) stockClass = 'stock-medium';

                            bookContainer.innerHTML = `
<a href="BOOK-DETAILS.PHP?book_id=${encodeURIComponent(book.book_id)}" class="book-link">
    <div class="book-container">
        <img src="${book.book_cover}" class="book-cover" alt="Book Cover">
    </div>
    <div class="book-details">
        <div>
            <span class="borrow-count">${book.borrow_count} borrows</span>
            <span class="stock-badge ${stockClass}">${book.book_stocks} left</span>
        </div>
        <h5>${book.book_title}</h5>
        <p>${book.book_author}</p>
    </div>
</a>
`;
                            bookList.appendChild(bookContainer);
                        });
                    } else {
                        bookList.innerHTML = `<p>No ${status} books found.</p>`;
                    }
                });
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadBooks('available');
            loadBooks('upcoming');
        });
    </script>
    <script>
        function openAddBookForm() {
            Swal.fire({
                title: 'Add New Book',
                width: '60vw',
                html: `
            <form id="addBookForm" enctype="multipart/form-data" style="display: flex; flex-wrap: wrap; gap: 15px;">
                <div style="flex: 1 1 48%;">
                    <label>Book Title:</label>
                    <input type="text" name="bookTitle" class="swal2-input" required>
                </div>
                <div style="flex: 1 1 48%;">
                    <label>Author:</label>
                    <input type="text" name="author" class="swal2-input" required>
                </div>
                <div style="flex: 1 1 48%;">
                    <label>Publisher:</label>
                    <input type="text" name="publisher" class="swal2-input" required>
                </div>
                <div style="flex: 1 1 48%;">
                    <label>Publication Date:</label>
                    <input type="date" name="publication_date" class="swal2-input" required>
                </div>
                <div style="flex: 1 1 48%;">
                    <label>ISBN:</label>
                    <input type="text" name="isbn" class="swal2-input" required>
                </div>
                <div style="flex: 1 1 48%;">
                    <label>Genre:</label>
                    <input type="text" name="book_genre" class="swal2-input" required>
                </div>
                <div style="flex: 1 1 48%;">
                    <label>Stocks:</label>
                    <input type="number" name="book_stocks" class="swal2-input" required>
                </div>
                <div style="flex: 1 1 48%;">
                    <label>Status:</label>
                    <select name="status" class="swal2-select" required>
                        <option value="Available">Available</option>
                        <option value="Upcoming">Upcoming</option>
                    </select>
                </div>
                <div style="flex: 1 1 100%;">
                    <label>Book Cover:</label>
                    <input type="file" name="bookCover" accept="image/*" class="swal2-file" required>
                </div>
                <div style="flex: 1 1 100%;">
                    <label>Description:</label>
                    <textarea name="bookDescription" class="swal2-textarea" required></textarea>
                </div>
            </form>
        `,
                confirmButtonText: 'Add Book',
                showCancelButton: true,
                focusConfirm: false,
                preConfirm: () => {
                    const form = document.getElementById('addBookForm');
                    const formData = new FormData(form);

                    return fetch('librarian_add_book.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                throw new Error(data.message || 'Failed to add book');
                            }
                            return data;
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Error: ${error.message}`);
                        });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Success!', 'Book added successfully.', 'success')
                        .then(() => location.reload());
                }
            });
        }
    </script>
</body>

</html>