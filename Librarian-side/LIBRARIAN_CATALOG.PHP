<?php
session_start();
include '../Homepage/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Librarian Catalog</title>
    <link rel="stylesheet" href="LIBRARIAN_CATALOG.CSS">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">



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

            <div class="search-bar">
                <i class="ion-ios-search search-icon"></i>
                <input type="text" class="form-control" placeholder="Search available books..." id="searchAvailableInput" />
                <button type="button" id="voiceBtn" class="voice-btn" aria-label="Voice Search">
                    <i class="ion-ios-mic"></i>
                </button>
            </div>
        </div>
    </div>


    <!-- Available Book List -->
    <div class="book-list" id="available-book-list">
        <?php
        $query_available = "
    SELECT 
        b.book_id, 
        b.book_cover, 
        b.book_title, 
        b.book_author, 
        b.book_stocks, 
        b.publisher, 
        b.publication_date, 
        b.ISBN, 
        b.book_genre,
        b.book_description,
        b.book_category,
        COUNT(bb.book_id) AS borrow_count
    FROM tbl_books b
    LEFT JOIN borrowed_books bb ON b.book_id = bb.book_id AND bb.status = 'returned'
    WHERE b.status = 'available'
    GROUP BY b.book_id
    ORDER BY borrow_count DESC
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
                $publisher = $row['publisher'];
                $publication_date = date("Y-m-d", strtotime($row['publication_date']));
                $isbn = $row['ISBN'];
                $genre = $row['book_genre'];
                $category = $row['book_category'];
                $book_description = $row['book_description'];

                if ($book_stocks >= 21 && $book_stocks <= 30) {
                    $stock_class = 'stock-high';
                } elseif ($book_stocks >= 11 && $book_stocks <= 20) {
                    $stock_class = 'stock-medium';
                } else {
                    $stock_class = 'stock-low';
                }
        ?>
                <div class="book-main-container">
                    <a href="#" class="book-link"
                        data-book-id="<?php echo $book_id; ?>"
                        data-book-title="<?php echo htmlspecialchars($book_title); ?>"
                        data-book-author="<?php echo htmlspecialchars($author); ?>"
                        data-book-cover="<?php echo htmlspecialchars($book_cover); ?>"
                        data-book-stocks="<?php echo $book_stocks; ?>"
                        data-borrow-count="<?php echo $borrow_count; ?>"
                        data-book-isbn="<?php echo htmlspecialchars($isbn); ?>"
                        data-book-publisher="<?php echo htmlspecialchars($publisher); ?>"
                        data-book-date="<?php echo htmlspecialchars($publication_date); ?>"
                        data-book-language="English"
                        data-book-genre="<?php echo htmlspecialchars($genre); ?>"
                        data-book-category="<?php echo htmlspecialchars($category); ?>"
                        data-book-description="<?php echo htmlspecialchars($book_description); ?>">

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




    </script>


    <!-- Upcoming Books Section -->
    <div class="titles-container" style="margin-top: 40px;">
        <div class="header-container">
            <div class="titles">
                <div class="upcoming">Upcoming Books</div>
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
            b.ISBN,
            b.publisher,
            b.publication_date,
            b.book_description,
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
                $isbn = $row['ISBN'];
                $publisher = $row['publisher'];
                $publication_date = $row['publication_date'];
                $description = $row['book_description'];

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
                    <a
                        href="#"
                        class="book-link"
                        data-book-id="<?php echo htmlspecialchars($book_id); ?>"
                        data-book-cover="<?php echo htmlspecialchars($book_cover); ?>"
                        data-book-title="<?php echo htmlspecialchars($book_title); ?>"
                        data-book-author="<?php echo htmlspecialchars($author); ?>"
                        data-book-stocks="<?php echo htmlspecialchars($book_stocks); ?>"
                        data-borrow-count="<?php echo htmlspecialchars($borrow_count); ?>"
                        data-book-isbn="<?php echo htmlspecialchars($isbn); ?>"
                        data-book-language="English"
                        data-book-publisher="<?php echo htmlspecialchars($publisher); ?>"
                        data-book-date="<?php echo htmlspecialchars($publication_date); ?>"
                        data-book-description="<?php echo htmlspecialchars($description); ?>">
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


        // Live Search
        document.getElementById('searchAvailableInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const books = document.querySelectorAll('#available-book-list .book-main-container');

            books.forEach(book => {
                const title = book.querySelector('h5').textContent.toLowerCase();
                const author = book.querySelector('p').textContent.toLowerCase();

                if (title.includes(searchTerm) || author.includes(searchTerm)) {
                    book.style.display = 'block';
                } else {
                    book.style.display = 'none';
                }
            });
        });

           // Live Search
    document.getElementById('searchAvailableInput').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const books = document.querySelectorAll('#available-book-list .book-main-container');

        books.forEach(book => {
            const title = book.querySelector('h5').textContent.toLowerCase();
            const author = book.querySelector('p').textContent.toLowerCase();

            if (title.includes(searchTerm) || author.includes(searchTerm)) {
                book.style.display = 'block';
            } else {
                book.style.display = 'none';
            }
        });
    });

        // Live Search
    document.getElementById('searchAvailableInput').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const books = document.querySelectorAll('#available-book-list .book-main-container');

        books.forEach(book => {
            const title = book.querySelector('h5').textContent.toLowerCase();
            const author = book.querySelector('p').textContent.toLowerCase();

            if (title.includes(searchTerm) || author.includes(searchTerm)) {
                book.style.display = 'block';
            } else {
                book.style.display = 'none';
            }
        });
    });

    // Voice Search with SweetAlert and silent "clear"
    const voiceBtn = document.getElementById('voiceBtn');
    const searchInput = document.getElementById('searchAvailableInput');

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
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                    recognition.start();
                }
            });
        });

        recognition.onresult = (event) => {
            Swal.close(); // Close the "Listening..." alert
            const transcript = event.results[0][0].transcript.trim().toLowerCase();

            if (transcript === 'clear') {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input')); // Clear field silently
            } else {
                searchInput.value = transcript;
                searchInput.dispatchEvent(new Event('input')); // Trigger live search
            }
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

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.book-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const bookId = this.dataset.bookId;
                    const bookTitle = this.dataset.bookTitle;
                    const bookAuthor = this.dataset.bookAuthor;
                    const bookCover = this.dataset.bookCover;
                    const bookStocks = this.dataset.bookStocks;
                    const borrowCount = this.dataset.borrowCount;
                    const bookISBN = this.dataset.bookIsbn;
                    const bookLanguage = this.dataset.bookLanguage || '';
                    const bookPublisher = this.dataset.bookPublisher;
                    const bookDate = this.dataset.bookDate;
                    const bookDescription = this.dataset.bookDescription;

                    Swal.fire({
                        title: `<strong style="text-align: left; display: block;">Edit Book Info</strong>`,
                        customClass: {
                            popup: 'wide-modal'
                        },
                        html: `
                
                    <div class="text-center mb-3">
                        <img src="${bookCover}" alt="Book Cover" class="img-fluid" style="max-width: 150px;">
                    </div>
                    <form id="edit-book-form" style="text-align: left;">
    <input type="hidden" name="book_id" value="${bookId}">
    
    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 5px;">Title</label>
            <input type="text" name="book_title" value="${bookTitle}" class="swal2-input" style="width: 80%;" required>
        </div>
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 5px;">Author</label>
            <input type="text" name="book_author" value="${bookAuthor}" class="swal2-input" style="width: 80%;" required>
        </div>
    </div>

    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 5px;">ISBN</label>
            <input type="text" name="ISBN" value="${bookISBN}" class="swal2-input" style="width: 80%;" required>
        </div>
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 5px;">Language</label>
            <input type="text" name="book_language" value="${bookLanguage}" class="swal2-input" style="width: 80%;">
        </div>
    </div>

    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 5px;">Publisher</label>
            <input type="text" name="publisher" value="${bookPublisher}" class="swal2-input" style="width: 80%;" required>
        </div>
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 5px;">Publication Date</label>
            <input type="date" name="publication_date" value="${bookDate}" class="swal2-input" style="width: 80%;" required>
        </div>
    </div>

    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 5px;">Available Stocks</label>
            <input type="number" name="book_stocks" value="${bookStocks}" class="swal2-input" style="width: 80%;" min="0" required>
        </div>
        <div style="flex: 1;">
            <!-- You can use this for an optional field or leave blank -->
        </div>
    </div>

    <div style="margin-top: 10px;">
        <label style="display: block; margin-bottom: 5px;">Description</label>
        <textarea name="book_description" class="swal2-textarea" rows="4" style="width: 80%;" required>${bookDescription}</textarea>
    </div>
</form>

                `,
                        showCancelButton: true,
                        confirmButtonText: 'Save',
                        focusConfirm: false,
                        didOpen: () => {
                            // Optional: Initialize any Bootstrap JS components if needed
                        },
                        preConfirm: () => {
                            const form = Swal.getPopup().querySelector('#edit-book-form');
                            const formData = new FormData(form);
                            for (const [key, value] of formData.entries()) {
                                if (!value.trim() && key !== 'book_language') {
                                    Swal.showValidationMessage(`Please fill out the ${key.replace('_', ' ')} field`);
                                    return false;
                                }
                            }
                            return formData;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('LIBRARIAN_UPDATEBOOK.php', {
                                    method: 'POST',
                                    body: result.value
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Updated!', 'Book info has been updated.', 'success').then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire('Error', data.message || 'Failed to update book info.', 'error');
                                    }
                                })
                                .catch(() => {
                                    Swal.fire('Error', 'Failed to send request.', 'error');
                                });
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>