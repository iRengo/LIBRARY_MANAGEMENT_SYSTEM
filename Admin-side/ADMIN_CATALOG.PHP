<?php
session_start();
include '../homepage/db_connect.php';

$successMessage = '';
if (isset($_SESSION['archive_success'])) {
    $successMessage = $_SESSION['archive_success'];
    unset($_SESSION['archive_success']); // Prevent repeat display
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="ADMIN_CATALOG.CSS">
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'header-navbar.php' ?>

    <!-- Content HERE -->

    <div class="titles-container">
        <div class="header-container">

            <div class="titles">
                <div class="available" id="bookSectionTitle">Available Books</div>
            </div>


            <!-- Add Book Button & Search Bar -->
            <div class="search-container">
                <button class="btn archived-book-btn" id="toggleBooksBtn" onclick="toggleBookView()">Archived</button>
                <br>
                <div id="mainActionButtons">
                    <button class="btn import-book-btn" onclick="confirmImport()">Import Book</button> &nbsp; &nbsp;
                    <button class="btn add-book-btn" onclick="openAddBookForm()">Add Book</button>
                </div>


                <div>
                    <div class="search-bar" id="searchBar">
                        <i class="ion-ios-search search-icon"></i>
                        <input type="search" class="form-control" placeholder="Search books..." id="searchInput">
                        <button type="button" id="voiceBtn" class="voice-btn" aria-label="Voice Search">
                            <i class="ion-ios-mic"></i>
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Available Books Section -->
    <div id="availableBooksSection" class="book-section">
        <div class="book-list">
            <?php
            $query = "SELECT book_id, book_cover, book_title,book_category, book_author FROM tbl_books WHERE status = 'available' order by book_id desc";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $categoryClass = 'genre-default'; // default fallback
                    $category = strtolower(trim($row['book_category']));

                    if ($category === 'fiction') {
                        $categoryClass = 'genre-fiction';
                    } else if ($category === 'non-fiction' || $category === 'non fiction') {
                        $categoryClass = 'genre-nonfiction';
                    } else if ($category === 'biography') {
                        $categoryClass = 'genre-biography';
                    } else if ($category === 'mystery') {
                        $categoryClass = 'genre-mystery';
                    } else if ($category === 'science') {
                        $categoryClass = 'genre-science';
                    } else if ($category === 'history') {
                        $categoryClass = 'genre-history';
                    } else if ($category === 'others' || $category === 'other') {
                        $categoryClass = 'genre-others';
                    }

            ?>
                    <div class="book-main-container">
                        <div class="book-container">
                            <img src="<?= htmlspecialchars($row['book_cover']); ?>" class="book-cover" alt="Book Cover">
                            <div class="overlay">
                                <button class="archive-btn" onclick="archiveBook(<?= $row['book_id']; ?>)">ARCHIVE</button>
                            </div>
                        </div>
                        <div class="book-details">
                            <h5><?= htmlspecialchars($row['book_title']); ?></h5>
                            <p><?= htmlspecialchars($row['book_author']); ?></p>
                            <span class="book-category <?= $categoryClass ?>">
                                <?= htmlspecialchars($row['book_category']) ?>
                            </span>
                        </div>
                    </div>
            <?php
                }
            }else {
    echo '
    <div class="no-books-container">
        <img src="../public/images/no-found.jpg" alt="No books">
    </div>';
}
            ?>
        </div>
    </div>

            <div class="titles">
                <div class="available" id="bookSectionTitle">Upcoming Books</div>
            </div>
    <!-- Upcoming Books Section -->
    <div id="availableBooksSection" class="book-section">
        <div class="book-list">
            <?php
            $query = "SELECT book_id, book_cover, book_title,book_category, book_author FROM tbl_books WHERE status = 'Upcoming'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $categoryClass = 'genre-default'; // default fallback
                    $category = strtolower(trim($row['book_category']));

                    if ($category === 'fiction') {
                        $categoryClass = 'genre-fiction';
                    } else if ($category === 'non-fiction' || $category === 'non fiction') {
                        $categoryClass = 'genre-nonfiction';
                    } else if ($category === 'biography') {
                        $categoryClass = 'genre-biography';
                    } else if ($category === 'mystery') {
                        $categoryClass = 'genre-mystery';
                    } else if ($category === 'science') {
                        $categoryClass = 'genre-science';
                    } else if ($category === 'history') {
                        $categoryClass = 'genre-history';
                    } else if ($category === 'others' || $category === 'other') {
                        $categoryClass = 'genre-others';
                    }

            ?>
                    <div class="book-main-container">
                        <div class="book-container">
                            <img src="<?= htmlspecialchars($row['book_cover']); ?>" class="book-cover" alt="Book Cover">
                            <div class="overlay">
                                <button class="archive-btn" onclick="archiveBook(<?= $row['book_id']; ?>)">ARCHIVE</button>
                            </div>
                        </div>
                        <div class="book-details">
                            <h5><?= htmlspecialchars($row['book_title']); ?></h5>
                            <p><?= htmlspecialchars($row['book_author']); ?></p>
                            <span class="book-category <?= $categoryClass ?>">
                                <?= htmlspecialchars($row['book_category']) ?>
                            </span>
                        </div>
                    </div>
            <?php
                }
            } else {
    echo '
    <div class="no-books-container">
        <img src="../public/images/no-found.jpg" alt="No books">
    </div>';
}
            ?>
        </div>
    </div>
    

    <!-- Archived Books Section (initially hidden) -->
    <div id="archivedBooksSection" class="book-section" style="display: none;">
        <div class="book-list">
            <?php
            $archivedQuery = "SELECT book_id, book_cover, book_title,book_category, book_author FROM tbl_archived_books";
            $archivedResult = mysqli_query($conn, $archivedQuery);

            if (mysqli_num_rows($archivedResult) > 0) {
                while ($row = mysqli_fetch_assoc($archivedResult)) {
                    $categoryClass = 'genre-default'; // default fallback
                    $category = strtolower(trim($row['book_category']));

                    if ($category === 'fiction') {
                        $categoryClass = 'genre-fiction';
                    } else if ($category === 'non-fiction' || $category === 'non fiction') {
                        $categoryClass = 'genre-nonfiction';
                    } else if ($category === 'biography') {
                        $categoryClass = 'genre-biography';
                    } else if ($category === 'mystery') {
                        $categoryClass = 'genre-mystery';
                    } else if ($category === 'science') {
                        $categoryClass = 'genre-science';
                    } else if ($category === 'history') {
                        $categoryClass = 'genre-history';
                    } else if ($category === 'others' || $category === 'other') {
                        $categoryClass = 'genre-others';
                    }
            ?>
                    <div class="book-main-container">
                        <div class="book-container">
                            <img src="<?= htmlspecialchars($row['book_cover']); ?>" class="book-cover" alt="Book Cover">

                            <!-- Overlay for Restore Button -->
                            <div class="overlay">
                                <button class="restore-btn" onclick="restoreBook(<?= $row['book_id']; ?>)">Restore</button>
                            </div>
                        </div>
                        <div class="book-details">
                            <h5><?= htmlspecialchars($row['book_title']); ?></h5>
                            <p><?= htmlspecialchars($row['book_author']); ?></p>
                            <span class="book-category <?= $categoryClass ?>">
                                <?= htmlspecialchars($row['book_category']) ?>
                            </span>
                        </div>
                    </div>
            <?php
                }
            } else {
    echo '
    <div class="no-books-container">
        <img src="../public/images/no-found.jpg" alt="No books">
    </div>';
}
            ?>
        </div>
    </div>


    <script>
        function archiveBook(bookId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This book will be archived!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, archive it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'admin_delete_book.php?book_id=' + bookId;
                }
            });
        }


        // Display SweetAlert if a success message exists in the URL
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                Swal.fire({
                    title: 'Archived!',
                    text: urlParams.get('success'),
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    </script>
    <script>
        let showingArchived = false;

        function toggleBookView() {
            const available = document.getElementById('availableBooksSection');
            const archived = document.getElementById('archivedBooksSection');
            const toggleBtn = document.getElementById('toggleBooksBtn');
            const titleText = document.getElementById('bookSectionTitle');
            const actionButtons = document.getElementById('mainActionButtons');
            const searchBar = document.getElementById('searchBar');

            if (showingArchived) {
                // Show available books
                archived.style.display = 'none';
                available.style.display = 'block';
                toggleBtn.textContent = 'Archived';
                titleText.textContent = 'Available Books';
                actionButtons.style.display = 'flex';
                searchBar.style.display = 'block';
            } else {
                // Show archived books
                archived.style.display = 'block';
                available.style.display = 'none';
                toggleBtn.textContent = 'Back to Available';
                titleText.textContent = 'Archived Books';
                actionButtons.style.display = 'none';
                searchBar.style.display = 'none';
            }

            showingArchived = !showingArchived;
        }
    </script>



    <script>
        function openAddBookForm() {
            Swal.fire({
                title: 'Add New Book',
                width: '50vw',
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

                <div style="flex: 1; min-width: 48%; display: flex; flex-direction: column;">
    <label for="bookCategory">Book Category:</label>
    <select id="bookCategory" name="book_category" class="swal2-select" required>
        <option value="" disabled selected>Select category</option>
        <option value="Fiction">Fiction</option>
        <option value="Non-Fiction">Non-Fiction</option>
        <option value="Biography">Biography</option>
        <option value="Mystery">Mystery</option>
        <option value="Science">Science</option>
        <option value="History">History</option>
        <option value="Others">Others</option>
    </select>
</div>

                <!-- Stocks and Status -->
                <div style="flex: 1; min-width: 48%; display: flex; flex-direction: column;">
                    <label for="stocks">Stocks:</label>
                    <input type="number" id="stocks" name="book_stocks" class="swal2-input" required>
                </div>
                <div style="flex: 1; min-width: 48%; display: flex; flex-direction: column;">
                    <label for="status">Status:</label>
                    <select id="status" name="status" class="swal2-select" required>
                        <option value="Available">Available</option>
                        <option value="Upcoming">Upcoming</option>
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
        function archiveBook(bookId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This book will be archived!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, archive it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'admin_delete_book.php?book_id=' + bookId;
                }
            });
        }


        // Display SweetAlert if a success message exists in the URL
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                Swal.fire({
                    title: 'Archived!',
                    text: urlParams.get('success'),
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
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

    <?php if (!empty($successMessage)) : ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?= addslashes($successMessage) ?>'
            });
        </script>
    <?php endif; ?>

    <script>
        function restoreBook(bookId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This book will be restored back to the available books list!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745', // Green
                cancelButtonColor: '#3085d6', // Blue
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send a request to restore the book (via a PHP script)
                    window.location.href = 'restore_book.php?book_id=' + bookId;
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                Swal.fire({
                    title: 'Restored!',
                    text: urlParams.get('success'),
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });

        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            const books = document.querySelectorAll('.book-main-container');

            books.forEach(book => {
                const title = book.querySelector('.book-details h5')?.textContent.toLowerCase() || '';
                const author = book.querySelector('.book-details p')?.textContent.toLowerCase() || '';

                if (title.includes(query) || author.includes(query)) {
                    book.style.display = '';
                } else {
                    book.style.display = 'none';
                }
            });
        });

        // Voice Search using SpeechRecognition + SweetAlert
        const voiceBtn = document.getElementById('voiceBtn');
        const searchInput = document.getElementById('searchInput');

        if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            const recognition = new SpeechRecognition();
            recognition.lang = 'en-US';
            recognition.continuous = false;
            recognition.interimResults = false;

            voiceBtn.addEventListener('click', () => {
                Swal.fire({
                    title: 'Listening...',
                    text: 'Speak now',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Stop',
                    cancelButtonText: 'Cancel',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                        recognition.start();
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.cancel || result.isConfirmed) {
                        recognition.stop();
                    }
                });
            });

            recognition.onresult = (event) => {
                Swal.close();
                const transcript = event.results[0][0].transcript.trim().toLowerCase();

                if (transcript === 'clear') {
                    searchInput.value = '';
                } else {
                    searchInput.value = transcript;
                }

                searchInput.dispatchEvent(new Event('input')); // Trigger live search
            };

            recognition.onerror = (event) => {
                Swal.close();
                console.error('Speech recognition error:', event.error);
                Swal.fire('Error', 'Voice recognition failed: ' + event.error, 'error');
            };
        } else {
            voiceBtn.disabled = true;
            voiceBtn.title = "Voice search not supported in this browser.";
        }
    </script>

</body>

</html>