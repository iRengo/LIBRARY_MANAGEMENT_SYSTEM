        <?php
        session_start();
        include '../homepage/db_connect.php';

        // Ensure user is logged in
        if (!isset($_SESSION['acc_no'])) {
        die("Access Denied. Please log in.");
        }

        $acc_no = $_SESSION['acc_no']; // Get logged-in user's account number
        $login_time = date("Y-m-d H:i:s");

        // Update the last_login column
        $stmt = $conn->prepare("UPDATE stud_acc SET last_logged_in = ? WHERE student_no = ?");
        $stmt->bind_param("si", $login_time, $acc_no);
        $stmt->execute();

        // Fetch Borrowed Count (Only for logged-in user)
        $stmt = $conn->prepare("SELECT COUNT(*) FROM borrowed_books WHERE student_no = ? AND status = 'borrowed'");
        $stmt->bind_param("i", $acc_no);
        $stmt->execute();
        $stmt->bind_result($borrowed_count);
        $stmt->fetch();
        $stmt->close();

        // Fetch Reserved Count
        $stmt = $conn->prepare("SELECT COUNT(*) FROM reserved_books WHERE student_no = ?");
        $stmt->bind_param("i", $acc_no);
        $stmt->execute();
        $stmt->bind_result($reserved_count);
        $stmt->fetch();
        $stmt->close();

        // Fetch Overdue Count
        $stmt = $conn->prepare("SELECT COUNT(*) FROM borrowed_books WHERE student_no = ? AND due_date < NOW() AND status = 'borrowed'");
        $stmt->bind_param("i", $acc_no);
        $stmt->execute();
        $stmt->bind_result($overdue_count);
        $stmt->fetch();
        $stmt->close();

        // Fetch Due Books Count
        $stmt = $conn->prepare("SELECT COUNT(*) FROM borrowed_books WHERE student_no = ? AND due_date = CURDATE() AND status = 'borrowed'");
        $stmt->bind_param("i", $acc_no);
        $stmt->execute();
        $stmt->bind_result($due_count);
        $stmt->fetch();
        $stmt->close();

        // Get all genres with their counts
        $sql = "
        SELECT book_genre, COUNT(*) as total
        FROM (
        SELECT b.book_genre FROM borrowed_books bb
        JOIN tbl_books b ON bb.book_id = b.book_id
        WHERE bb.student_no = ?

        UNION ALL

        SELECT b.book_genre FROM reserved_books rb
        JOIN tbl_books b ON rb.book_id = b.book_id
        WHERE rb.acc_no = ?

        UNION ALL

        SELECT b.book_genre FROM book_likes_dislikes ld
        JOIN tbl_books b ON ld.book_id = b.book_id
        WHERE ld.acc_no = ? AND ld.action = 1

        UNION ALL

        SELECT b.book_genre FROM collection_books cb
        JOIN tbl_books b ON cb.book_id = b.book_id
        WHERE cb.acc_no = ?
        ) AS activity
        GROUP BY book_genre
        ORDER BY total DESC
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $acc_no, $acc_no, $acc_no, $acc_no);
        $stmt->execute();
        $result = $stmt->get_result();

        // Get the highest genre count
        $genres = [];
        $maxCount = 0;

        while ($row = $result->fetch_assoc()) {
        if ($maxCount == 0) {
        $maxCount = $row['total'];
        }

        if ($row['total'] == $maxCount) {
        $genres[] = $row['book_genre'];
        } else {
        break; // Only keep genres with the same top count
        }
        }

        // Prepare recommendations
        if (!empty($genres)) {
        $conditions = [];
        $params = [];
        $types = '';

        foreach ($genres as $genre) {
        $conditions[] = 'book_genre LIKE ?';
        $params[] = '%' . $genre . '%';
        $types .= 's';
        }

        $whereClause = implode(' OR ', $conditions);
        $sql = "SELECT * FROM tbl_books WHERE $whereClause ORDER BY RAND()";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        } else {
        $stmt = $conn->prepare("SELECT * FROM tbl_books ORDER BY RAND()");
        }

        $stmt->execute();
        $recommended = $stmt->get_result();


                // Fetch Top Books Ranking (Most Liked, Reserved, & Borrowed This Week)
        $query = "
        SELECT 
            b.book_id, 
            b.book_title, 
            b.book_author,
            (
                COUNT(DISTINCT CASE WHEN l.action = 'like' THEN l.id END) +
                COUNT(DISTINCT rb.book_id) +
                COUNT(DISTINCT bb.book_id)
            ) AS total_count
        FROM tbl_books b
        LEFT JOIN book_likes_dislikes l ON b.book_id = l.book_id
        LEFT JOIN reserved_books rb ON b.book_id = rb.book_id
        LEFT JOIN borrowed_books bb ON b.book_id = bb.book_id
        GROUP BY b.book_id, b.book_author
        HAVING total_count > 0
        ORDER BY total_count DESC
        LIMIT 10";

        $result = $conn->query($query);
?>


        <!DOCTYPE html>
        <html lang="en">

        <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
        <title> Admin Dashboard</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <!-- ======= Styles ====== -->
        <link rel="stylesheet" href="USER_STYLE2.CSS">
        <link rel="stylesheet" href="User_css/ADMIN_MODAL.css">
        <link rel="stylesheet" href="USER_DASHBOARD1.css">



        <!-- ======= Scripts ====== -->


        <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


        </head>

        <body>
        <?php include 'HEADER-NAVBAR.PHP' ?>

        <!-- Content Grid with Clickable Sections -->
        <br>
        <div class="content-grid">
        <div class="content-item" onclick="showBooks('due')">
        <ion-icon name="calendar-outline" style="font-size: 50px; color: #4CAF50;"></ion-icon>
        <div class="content-text">
        <p>DUE DATE</p>
        <h1><?= $due_count ?></h1>
        </div>
        </div>

        <div class="content-item" onclick="showBooks('borrowed')">
        <ion-icon name="book-outline" style="font-size: 50px; color: #2196F3;"></ion-icon>
        <div class="content-text">
        <p>Borrowed</p>
        <h1><?= $borrowed_count ?></h1>
        </div>
        </div>

        <div class="content-item" onclick="showBooks('overdue')">
        <ion-icon name="alert-circle-outline" style="font-size: 50px; color: #FF5722;"></ion-icon>
        <div class="content-text">
        <p>Overdue</p>
        <h1><?= $overdue_count ?></h1>
        </div>
        </div>

        <div class="content-item" onclick="showBooks('reserved')">
        <ion-icon name="bookmark-outline" style="font-size: 50px; color: #FFC107;"></ion-icon>
        <div class="content-text">
        <p>Reserved</p>
        <h1><?= $reserved_count ?></h1>
        </div>
        </div>
        </div>

        <!-- Bootstrap Modal -->
        <div class="modal fade" id="bookDetailsModal" tabindex="-1" aria-labelledby="bookDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">
        <!-- Modal Header -->
        <div class="modal-header custom-header">
        <h5 class="modal-title" id="bookDetailsLabel">📖 Book Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
        <p><strong>📌 Title:</strong> <span id="modalBookTitle"></span></p>
        <p><strong>✍ Author:</strong> <span id="modalBookAuthor"></span></p>
        <p id="modalReservedDate" style="display: none;"><strong>📅 Reserved on:</strong> <span></span></p>
        <p id="modalBorrowedAt" style="display: none;"><strong>📆 Borrowed at:</strong> <span></span></p>
        <p id="modalDueDate" style="display: none;"><strong>⏳ Due Date:</strong> <span></span></p>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
        </div>
        </div>

        <!-- Custom CSS -->
        <style>
        /* Modal Styling */
        .custom-modal {
        border-radius: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        }

        /* Header with Soft Gradient */
        .custom-header {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        color: white;
        padding: 15px;
        font-weight: bold;
        border-radius: 10px 10px 0 0;
        }

        /* Modal Body Text */
        .modal-body p {
        font-size: 1rem;
        color: #333;
        margin-bottom: 8px;
        padding: 8px 12px;
        border-left: 4px solid #6a11cb;
        background: #f9f9f9;
        border-radius: 5px;
        }

        /* Modal Footer Buttons */
        .btn-secondary {
        background-color: #6a11cb;
        border: none;
        padding: 8px 15px;
        font-weight: bold;
        transition: 0.3s ease-in-out;
        }

        .btn-secondary:hover {
        background-color: #2575fc;
        }
        </style>








        <!-- Table Section -->
        <div class="table-container">
        <!-- Table Header -->
        <h2 class="table-header">TOP BOOKS RANKING</h2>

        <!-- Table -->
        <table class="styled-table">
        <thead>
        <tr>
        <th>#</th>
        <th>Title</th>
        <th>Author</th>
        <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (isset($_SESSION['message'])) {
        echo "<div class='alert alert-info'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']); // Clear message after displaying
        }
        ?>


        <?php
        if ($result->num_rows > 0) {
        $rank = 1;
        while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>{$rank}</td>
        <td>{$row['book_title']}</td>
        <td>{$row['book_author']}</td>
        <td class='action-column'>
        <button class='btn view-btn' onclick=\"window.location.href='book-details.php?book_id={$row['book_id']}'\">View</button>
        <form method='post' action='add_to_collection.php' style='display:inline;'>
        <input type='hidden' name='book_id' value='" . $row['book_id'] . "'>
        <button type='submit' class='btn btn-collection'
        style='background-color:rgb(95, 183, 95); color: #fff; border: none; padding: 6px 12px;
        font-size: 14px; font-weight: bold; border-radius: 5px; cursor: pointer;
        transition: all 0.3s ease-in-out;'
        onmouseover=\"this.style.backgroundColor='#4DA04D'; this.style.transform='scale(1.05)';\"
        onmouseout=\"this.style.backgroundColor='rgb(95, 183, 95);'; this.style.transform='scale(1)';\">
        Add to Collection
        </button>
        </form>
        </td>
        </tr>";

        $rank++;
        }
        } else {
        echo "<tr><td colspan='4'>No data available this week.</td></tr>";
        }
        ?>
        </tbody>
        </table>
        </div>

        <!-- Book Container Section -->
        <div class="book-header">Upcoming Books </div> <!-- Moved outside book-container -->
        <div class="book-container" id="upcomingBooksContainer">


        <!-- Book 1 -->
        <div class="book">
        <img src="book-covers/gatsby.jpg" alt="Book Cover" class="book-cover">
        <div class="book-info">
        <h3 class="book-title">The Great Gatsby</h3>
        <p class="book-author">by F. Scott Fitzgerald</p>
        <div class="genre-btn action">Action</div>
        <div class="genre-btn fiction">Fiction</div>
        </div>
        </div>

        <!-- Book 2 -->
        <div class="book">
        <img src="book-covers/mockingbird.jpg" alt="Book Cover" class="book-cover">
        <div class="book-info">
        <h3 class="book-title">To Kill a Mockingbird</h3>
        <p class="book-author">by Harper Lee</p>
        <div class="genre-btn drama">Drama</div>
        <div class="genre-btn historical">Historical</div>
        </div>
        </div>

        <!-- Book 3 -->
        <div class="book">
        <img src="book-covers/1984.jpg" alt="Book Cover" class="book-cover">
        <div class="book-info">
        <h3 class="book-title">1984</h3>
        <p class="book-author">by George Orwell</p>
        <div class="genre-btn dystopia">Dystopia</div>
        </div>
        </div>

        <!-- Book 4 -->
        <div class="book">
        <img src="book-covers/pride.jpg" alt="Book Cover" class="book-cover">
        <div class="book-info">
        <h3 class="book-title">Pride and Prejudice</h3>
        <p class="book-author">by Jane Austen</p>
        <div class="genre-btn romance">Romance</div>
        </div>
        </div>

        <!-- Book 5 -->
        <div class="book">
        <img src="book-covers/moby.jpg" alt="Book Cover" class="book-cover">
        <div class="book-info">
        <h3 class="book-title">Moby-Dick</h3>
        <p class="book-author">by Herman Melville</p>
        <div class="genre-btn adventure">Adventure</div>
        </div>
        </div>

        <!-- Book 6 -->
        <div class="book">
        <img src="book-covers/war.jpg" alt="Book Cover" class="book-cover">
        <div class="book-info">
        <h3 class="book-title">War and Peace</h3>
        <p class="book-author">by Leo Tolstoy</p>
        <div class="genre-btn historical">Historical</div>
        </div>
        </div>
        </div>


         <!-- Recommended Books-->
         <Div class="recommended-header">
                <h2> Recommended Books </h2>
            </Div>
            
        <div class="recommended-books-container" id="recommendedBooksContainer">
    <div class="recommended-books">
        <?php while ($book = $recommended->fetch_assoc()): ?>
            <a href="book-details.php?book_id=<?= $book['book_id'] ?>" class="recommended-book-link">
                <div class="recommended-book">
                    <img src="<?= htmlspecialchars($book['book_cover']) ?>" alt="Book Cover" class="recommended-book-cover">
                    <div class="recommended-book-info">
                        <h3 class="recommended-book-title"><?= htmlspecialchars($book['book_title']) ?></h3>
                        <p class="recommended-book-author">by <?= htmlspecialchars($book['book_author']) ?></p>
                        <p class="recommended-book-genre"><?= htmlspecialchars($book['book_genre']) ?></p>
                    </div>
                </div>
            </a>
        <?php endwhile; ?>
    </div>
</div>



        <div id="bookModal" style="display:none; position:fixed; top:20%; left:50%; transform:translate(-50%, 0); background:white; padding:20px; box-shadow:0px 4px 6px rgba(0,0,0,0.1);">
        <h2 id="modal-title"></h2>
        <div id="modal-content"></div>
        <button onclick="document.getElementById('bookModal').style.display='none'">Close</button>
        </div>














        <!-- ========================= Main END ==================== -->

        <div id="logoutModal" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Confirm Logout</h2>
        <p>Are you sure you want to logout?</p>
        <div class="modal-actions">
        <a href="../Homepage/signin.php" class="btn-action btn-yes">Yes</a>
        <button class="btn-action btn-no" id="cancelLogout">No</button>
        </div>
        </div>
        </div>


        <script>
        function showBooks(type) {
        fetch(`fetch_books.php?type=${type}`)
        .then(response => response.json())
        .then(data => {
        let modalBody = document.querySelector(".modal-body");
        modalBody.innerHTML = ""; // Clear previous content

        if (data.length > 0) {
        data.forEach(book => {
        let bookDetails = `
        <p><strong>📌 Title:</strong> ${book.book_title}</p>
        <p><strong>✍ Author:</strong> ${book.author}</p>
        ${book.reserved_date ? `<p><strong>📅 Reserved on:</strong> ${book.reserved_date}</p>` : ""}
        ${book.borrowed_at ? `<p><strong>📆 Borrowed at:</strong> ${book.borrowed_at}</p>` : ""}
        ${book.due_date ? `<p><strong>⏳ Due Date:</strong> ${book.due_date}</p>` : ""}
        <hr>
        `;
        modalBody.innerHTML += bookDetails;
        });
        } else {
        // Display a message when no books are found
        modalBody.innerHTML = `<p class="text-center text-muted">📌 No records found.</p>`;
        }

        // Open the modal
        let modal = new bootstrap.Modal(document.getElementById("bookDetailsModal"));
        modal.show();
        })
        .catch(error => console.error("Error fetching book details:", error));
        }
        </script>


        <!-- =========== Scripts ========= -->
        <script src="User_css/admin.js"></script>
        <script src="User_css/ADMIN_MODAL.js"></script>


        <!-- ====== ionicons ======= -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <!-- Bootstrap CSS -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


        </body>

        </html>