<?php
session_start();
include '../homepage/db_connect.php';

if (!isset($_SESSION['acc_no'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    window.onload = function() {
        Swal.fire({
            title: "You are not logged in!",
            text: "Please log in to access the page.",
            icon: "error",
            confirmButtonText: "OK",
            allowOutsideClick: false,
            allowEscapeKey: false,
            willClose: () => {
                window.location.href = "../homepage/homepage.php";
            }
        });
    }
    </script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Catalog</title>
    <link rel="stylesheet" href="USER_STYLE2.CSS">
    <link rel="icon" type="image/png" href="../logosample1.png">
    <link rel="stylesheet" href="USER_CATALOG.CSS">
</head>
<body>
    <?php include 'HEADER-NAVBAR.PHP' ?>

    <div class="titles-container">
        <div class="header-container">
            <div class="titles">
                <div class="available">Available Books</div>
            </div>

            <div class="search-bar-container">
                <div class="search-bar">
                    <div class="search-input-wrapper">
                        <input type="text" class="form-control" placeholder="Search books..." id="searchInput">
                        <ion-icon name="search-outline" class="search-icon"></ion-icon>
                    </div>
                    <button id="voiceSearchBtn" title="Voice Search">
                        <ion-icon name="mic-outline"></ion-icon>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="filter-container">
        <label for="categoryFilter">Filter by Category:</label>
            <select id="categoryFilter">
                <option value="all">All</option>
                <option value="fiction">Fiction</option>
                <option value="non-fiction">Non-Fiction</option>
                <option value="biography">Biography</option>
                <option value="mystery">Mystery</option>
                <option value="science">Science</option>
                <option value="history">History</option>
                <option value="others">Others</option>
            </select>
    </div>

    <div class="book-list">
        <?php
        $query = "SELECT book_id, book_cover, book_title, book_category, book_author FROM tbl_books WHERE status = 'Available'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
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
                    <a href="BOOK-DETAILS.PHP?book_id=<?= urlencode($row['book_id']) ?>" class="book-link">
                        <div class="book-container">
                            <img src="<?= htmlspecialchars($row['book_cover']) ?>" class="book-cover" alt="Book Cover">
                        </div>
                        <div class="book-details">
                            <h5><?= htmlspecialchars($row['book_title']) ?></h5>
                            <p><?= htmlspecialchars($row['book_author']) ?></p>
                            <span class="book-category <?= $categoryClass ?>">
                                <?= htmlspecialchars($row['book_category']) ?>
                            </span>
                        </div>
                    </a>
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


        <!-- Upcoming Books Section -->
    <div class="titles-container">
        <div class="header-container">
            <div class="titles">
                <div class="available">Upcoming Books</div>
            </div>
        </div>
    </div>

    <div class="book-list">
        <?php
        $upcomingQuery = "SELECT book_id, book_cover, book_title, book_category, book_author FROM tbl_books WHERE status = 'Upcoming'";
        $upcomingResult = mysqli_query($conn, $upcomingQuery);

        if (mysqli_num_rows($upcomingResult) > 0) {
            while ($row = mysqli_fetch_assoc($upcomingResult)) {
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
                } else {
                    $categoryClass = '';
                }
        ?>
            <div class="book-main-container">
                <a href="BOOK-DETAILS.PHP?book_id=<?= urlencode($row['book_id']) ?>" class="book-link">
                    <div class="book-container">
                        <img src="<?= htmlspecialchars($row['book_cover']) ?>" class="book-cover" alt="Book Cover">
                    </div>
                    <div class="book-details">
                        <h5><?= htmlspecialchars($row['book_title']) ?></h5>
                        <p><?= htmlspecialchars($row['book_author']) ?></p>
                        <span class="book-category <?= $categoryClass ?>">
                            <?= htmlspecialchars($row['book_category']) ?>
                        </span>
                    </div>
                </a>
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

    <script>
const searchInput = document.getElementById('searchInput');
const categoryFilter = document.getElementById('categoryFilter');
const voiceBtn = document.getElementById('voiceSearchBtn');
const books = document.querySelectorAll('.book-main-container');

function filterBooks() {
    const searchTerm = searchInput.value.toLowerCase().trim();
    const selectedCategory = categoryFilter.value.toLowerCase();

    books.forEach(book => {
        const title = book.querySelector('h5').textContent.toLowerCase();
        const author = book.querySelector('p').textContent.toLowerCase();
        const category = book.querySelector('.book-category')?.textContent.toLowerCase().trim() || '';

        const matchesSearch = title.includes(searchTerm) || author.includes(searchTerm) || category.includes(searchTerm);
        const matchesCategory = (selectedCategory === 'all') || (category === selectedCategory);

        book.style.display = (matchesSearch && matchesCategory) ? 'block' : 'none';
    });
}

searchInput.addEventListener('input', filterBooks);
categoryFilter.addEventListener('change', filterBooks);

// Voice recognition
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

    recognition.onresult = event => {
        Swal.close();
        const transcript = event.results[0][0].transcript.trim().toLowerCase();
        searchInput.value = transcript === 'clear' ? '' : transcript;
        searchInput.dispatchEvent(new Event('input'));
    };

    recognition.onerror = event => {
        Swal.close();
        Swal.fire('Error', 'Voice recognition failed: ' + event.error, 'error');
    };
} else {
    voiceBtn.disabled = true;
    voiceBtn.title = "Voice search not supported in this browser.";
}
</script>


    

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
