<?php
include '../homepage/db_connect.php';
session_start();
if (!isset($_SESSION['admin_no'])) {
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
// Get the current time
$current_time = date('Y-m-d H:i:s');

// Assuming the admin is logged in and their ID is stored in session
$admin_id = $_SESSION['admin_no'];

// Update the 'last_logged_in' field in the database for the logged-in admin
$query = "UPDATE admin_acc SET last_logged_in = ? WHERE admin_no = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $current_time, $admin_id); // 'si' means string and integer
$stmt->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="ADMIN_STAFF_TOOLS.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />


</head>

<body>
    <?PHP include 'HEADER-NAVBAR.PHP' ?>

    <!-- Content HERE -->
    <div class="navbar" id="navbar">
        <a href="#" onclick="showSection('book-cataloging', this)">Book Cataloging</a>
        <a href="#" onclick="showSection('generate-report', this)">Generate Report</a>
        <a href="#" onclick="showSection('library-inventory', this)">Library Inventory</a>
        <a href="#" onclick="showSection('circulation-records', this)">Circulation Records</a>
    </div>




    <div class="main-container">
        <div id="book-cataloging" class="content-section">
            <div class="book-details">
                <h2>BOOK DETAILS</h2>

                <div class="form-row">
                    <input type="text" id="bookTitle" placeholder="Title">
                    <input type="text" id="bookAuthor" placeholder="Author">
                    <input type="text" id="bookISBN" placeholder="ISBN">
                    <input type="text" id="bookGenre" placeholder="category">
                </div>
                <div class="form-row">
                    <input type="date" id="bookPubDate" placeholder="Publication Date">
                    <input type="text" id="bookPublisher" placeholder="Publisher">
                    <input type="number" id="bookStocks" placeholder="Number Of Copies">
                </div>
                <div class="form-row">
                    <textarea rows="4" id="bookDescription" placeholder="Description" style="width: 100%;"></textarea>
                </div>


                <div class="book-scroll-wrapper">
                    <button class="scroll-btn left-btn">&#8592;</button> <!-- ← -->

                    <div class="book-list" id="bookList">
                        <?php
                        $query = "SELECT * FROM tbl_books";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $cover = !empty($row['book_cover']) ? $row['book_cover'] : 'https://via.placeholder.com/150x220?text=No+Cover';
                            echo '<div class="book-item" ' .
                                'data-id="' . $row['book_id'] . '" ' .
                                'data-title="' . htmlspecialchars($row['book_title'], ENT_QUOTES) . '" ' .
                                'data-author="' . htmlspecialchars($row['book_author'], ENT_QUOTES) . '" ' .
                                'data-isbn="' . htmlspecialchars($row['ISBN'], ENT_QUOTES) . '" ' .
                                'data-genre="' . htmlspecialchars($row['book_category'], ENT_QUOTES) . '" ' .
                                'data-pubdate="' . $row['publication_date'] . '" ' .
                                'data-publisher="' . htmlspecialchars($row['publisher'], ENT_QUOTES) . '" ' .
                                'data-stocks="' . $row['book_stocks'] . '" ' .
                                'data-description="' . htmlspecialchars($row['book_description'], ENT_QUOTES) . '"' .
                                '>';
                            echo '<img class="book-cover" src="' . htmlspecialchars($cover) . '" alt="Cover">';
                            echo '<div class="book-details-text">';
                            echo '<p><strong>Title:</strong> ' . htmlspecialchars($row['book_title']) . '</p>';
                            echo '<p><strong>Author:</strong> ' . htmlspecialchars($row['book_author']) . '</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>

                    <button class="scroll-btn right-btn">&#8594;</button> <!-- → -->
                </div>

                <div class="form-buttons">
                    <button class="save-btn">Save</button>
                    <button class="cancel-btn">Cancel</button>
                </div>
            </div>
        </div>

        <!-- Generate report -->
        <div id="generate-report" class="content-section" style="display: none;">
            <div class="book-details">
                <h2>GENERATE REPORT</h2>
                <div class="report-header">
                    <div class="overview">

                    </div>
                    <div class="filters">
                        <select id="report-type" class="report-select">
                            <option value="RESERVATION">Reserved Books</option>
                            <option value="BORROWED">Borrowed Books</option>
                            <option value="FINES">Student Fines</option>
                        </select>

                        <input type="date" class="report-date">
                    </div>
                </div>

                <!-- Reserved Books Table -->
                <table id="reserved-report" class="report-table">
                    <thead>
                        <tr>
                            <th>RESERVE ID</th>
                            <th>STUDENT NO</th>
                            <th>EMAIL</th>
                            <th>BOOK TITLE</th>
                            <th>RESERVE DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT reserve_id, student_no, email, book_title, reserve_date FROM reserved_books";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0):
                            while ($row = mysqli_fetch_assoc($result)):
                        ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['reserve_id']) ?></td>
                                    <td><?= htmlspecialchars($row['student_no']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['book_title']) ?></td>
                                    <td><?= htmlspecialchars($row['reserve_date']) ?></td>
                                </tr>
                        <?php
                            endwhile;
                        else:
                            echo "<tr><td colspan='5'>No reservations found.</td></tr>";
                        endif;
                        ?>
                    </tbody>
                </table>

                <!-- Borrowed Books Table -->
                <table id="borrowed-report" class="report-table" style="display: none;">
                    <thead>
                        <tr>
                            <th>BORROW ID</th>
                            <th>STUDENT NO</th>
                            <th>EMAIL</th>
                            <th>BOOK TITLE</th>
                            <th>BORROW DATE</th>
                            <th>DUE DATE</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_borrowed = "SELECT borrow_id, student_no, email, book_title, preferred_date, due_date, status FROM borrowed_books";
                        $result_borrowed = mysqli_query($conn, $sql_borrowed);
                        if (mysqli_num_rows($result_borrowed) > 0):
                            while ($row = mysqli_fetch_assoc($result_borrowed)):
                        ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['borrow_id']) ?></td>
                                    <td><?= htmlspecialchars($row['student_no']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['book_title']) ?></td>
                                    <td><?= htmlspecialchars($row['preferred_date']) ?></td>
                                    <td><?= htmlspecialchars($row['due_date']) ?></td>
                                    <td><?= htmlspecialchars($row['status']) ?></td>
                                </tr>
                        <?php
                            endwhile;
                        else:
                            echo "<tr><td colspan='7'>No borrowed books found.</td></tr>";
                        endif;
                        ?>
                    </tbody>
                </table>

                <!-- Student Fines Table -->
                <table id="fines-report" class="report-table" style="display: none;">
                    <thead>
                        <tr>
                            <th>STUDENT NO</th>
                            <th>BOOK TITLE</th>
                            <th>AUTHOR</th>
                            <th>FINE NAME</th>
                            <th>AMOUNT</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $fines_sql = "
                    SELECT 
                        sf.student_no,
                        b.book_title,
                        b.book_cover,
                        b.book_author,
                        f.fine_name,
                        f.price AS fine_amount,
                        sf.status,
                        sf.fine_id,
                        sf.proof
                    FROM student_fines sf
                    LEFT JOIN tbl_books b ON sf.book_id = b.book_id
                    LEFT JOIN fines_table f ON sf.fine_id = f.fine_id
                    WHERE sf.status = 'unpaid'
                    ORDER BY sf.fine_id DESC
                ";
                        $result_fines = mysqli_query($conn, $fines_sql);
                        if (mysqli_num_rows($result_fines) > 0):
                            while ($row = mysqli_fetch_assoc($result_fines)):
                        ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['student_no']) ?></td>
                                    <td><?= htmlspecialchars($row['book_title']) ?></td>

                                    <td><?= htmlspecialchars($row['book_author']) ?></td>
                                    <td><?= htmlspecialchars($row['fine_name']) ?></td>
                                    <td><?= htmlspecialchars(number_format($row['fine_amount'], 2)) ?></td>
                                    <td><?= htmlspecialchars($row['status']) ?></td>
                                </tr>
                        <?php
                            endwhile;
                        else:
                            echo "<tr><td colspan='8'>No unpaid fines found.</td></tr>";
                        endif;
                        ?>
                    </tbody>
                </table>

                <div class="pagination-container">
                    <button class="pagination-btn">Prev</button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <button class="pagination-btn">Next</button>
                </div>

                <div class="form-buttons">
                    <button class="save-btn">GENERATE</button>
                    <button class="cancel-btn">CLEAR</button>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const reportSelect = document.getElementById("report-type");
                const reservedTable = document.getElementById("reserved-report");
                const borrowedTable = document.getElementById("borrowed-report");
                const finesTable = document.getElementById("fines-report");

                function toggleReports() {
                    const selected = reportSelect.value;
                    reservedTable.style.display = "none";
                    borrowedTable.style.display = "none";
                    finesTable.style.display = "none";

                    if (selected === "RESERVATION") {
                        reservedTable.style.display = "table";
                    } else if (selected === "BORROWED") {
                        borrowedTable.style.display = "table";
                    } else if (selected === "FINES") {
                        finesTable.style.display = "table";
                    }
                }

                // Initialize
                toggleReports();

                reportSelect.addEventListener("change", toggleReports);
            });
        </script>



        <!-- Library Inventory -->
        <div id="library-inventory" class="content-section" style="display: none;">
            <div class="book-details">
                <h2>Library Inventory</h2>
                <div class="inventory-header">
                    <div class="filters">
                        <input type="text" class="report-date" placeholder="Search...">
                        <button class="filter-btn" title="Filter"><i class="fa-solid fa-filter"></i></button>
                    </div>
                    <button class="add-book-btn">Add New Book</button>
                </div>


                <table class="report-table inventory-table">
                    <thead>
                        <tr>
                            <th>ISBN</th>
                            <th>BOOK TITLE</th>
                            <th>AUTHOR</th>
                            <th>NO. OF BOOKS</th>
                            <th>GENRE</th>
                            <th>PUBLISHER</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $book_sql = "SELECT book_id, book_title, book_author, book_stocks, ISBN, book_category, publisher FROM tbl_books";
                        $fetch_book = mysqli_query($conn, $book_sql);

                        if (mysqli_num_rows($fetch_book) > 0):
                            while ($row = mysqli_fetch_assoc($fetch_book)):
                        ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['ISBN']) ?></td>
                                    <td><?= htmlspecialchars($row['book_title']) ?></td>
                                    <td><?= htmlspecialchars($row['book_author']) ?></td>
                                    <td><?= intval($row['book_stocks']) ?></td>
                                    <td><?= htmlspecialchars($row['book_category']) ?></td>
                                    <td><?= htmlspecialchars($row['publisher']) ?></td>
                                    <td>
                                        <button class="action-btn edit-btn" data-id="<?= $row['book_id'] ?>" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="action-btn delete-btn" data-id="<?= $row['book_id'] ?>" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        <button class="action-btn archived-btn" data-id="<?= $row['book_id'] ?>" title="Archived">
                                            <i class="fa-solid fa-box-archive"></i>
                                        </button>
                                    </td>
                                </tr>
                        <?php
                            endwhile;
                        else:
                            echo "<tr><td colspan='7'>No books found.</td></tr>";
                        endif;

                        ?>

                    </tbody>


                </table>

                <div class="pagination-container">
                    <button class="pagination-btn">Prev</button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <button class="pagination-btn">Next</button>
                </div>
            </div>

        </div>


        <!-- Circulation Records -->
        <div id="circulation-records" class="content-section" style="display: none;">
            <div class="book-details">
                <h2>Circulation Records</h2>
                <div class="circulation-header">
                    <div class="filters">
                        <input type="text" class="circulation-search" placeholder="Search records">
                        <button class="circulation-filter-btn" title="Filter">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                    </div>
                </div>

                <table class="report-table circulation-table">
                    <thead>
                        <tr>
                            <th>BOOK TITLE</th>
                            <th>USERNAME</th>
                            <th>BORROWED DATE</th>
                            <th>DUE DATE</th>
                            <th>STATUS</th>
                            <th>LAST UPDATED</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch all records from borrowed_book
                        $sql = "SELECT * FROM borrowed_books";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0):
                            while ($row = mysqli_fetch_assoc($result)):
                                $username = $row['first_name'] . ' ' . $row['last_name'];
                        ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['book_title']) ?></td>
                                    <td><?= htmlspecialchars($username) ?></td>
                                    <td><?= htmlspecialchars($row['preferred_date']) ?></td>
                                    <td><?= htmlspecialchars($row['due_date']) ?></td>
                                    <td><?= htmlspecialchars($row['status']) ?></td>
                                    <td><?= htmlspecialchars($row['update_datetime']) ?></td>
                                    <td>
                                        <button class="action-btn edit-btn" data-id="<?= $row['borrow_id'] ?>" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="action-btn delete-btn" data-id="<?= $row['borrow_id'] ?>" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                        <?php
                            endwhile;
                        else:
                            echo "<tr><td colspan='7'>No borrowed books found.</td></tr>";
                        endif;
                        ?>
                    </tbody>
                </table>


                </table>

                <div class="pagination-container">
                    <button class="pagination-btn">Prev</button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <button class="pagination-btn">Next</button>
                </div>
            </div>
        </div>





    </div>

    <!-- Content HERE -->

    <!-- ========================= Main END ==================== -->


    <script>
        document.querySelectorAll('.book-item').forEach(item => {
            item.addEventListener('click', () => {
                // Get data attributes from clicked book
                const id = item.getAttribute('data-id');
                const title = item.getAttribute('data-title');
                const author = item.getAttribute('data-author');
                const isbn = item.getAttribute('data-isbn');
                const genre = item.getAttribute('data-genre');
                const pubdate = item.getAttribute('data-pubdate');
                const publisher = item.getAttribute('data-publisher');
                const stocks = item.getAttribute('data-stocks');
                const description = item.getAttribute('data-description');

                // Fill inputs
                document.getElementById('bookTitle').value = title;
                document.getElementById('bookAuthor').value = author;
                document.getElementById('bookISBN').value = isbn;
                document.getElementById('bookGenre').value = genre;
                document.getElementById('bookPubDate').value = pubdate;
                document.getElementById('bookPublisher').value = publisher;
                document.getElementById('bookStocks').value = stocks;
                document.getElementById('bookDescription').value = description;

                // If you want to store the book_id somewhere for save/update later
                document.getElementById('book-cataloging').setAttribute('data-current-book-id', id);
            });
        });

        function showSection(sectionId, clickedLink) {
            // Hide all content sections
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(sec => sec.style.display = 'none');

            // Show the selected section
            const targetSection = document.getElementById(sectionId);
            if (targetSection) {
                targetSection.style.display = 'block';
            }

            // Remove 'active' from all navbar links
            const links = document.querySelectorAll('.navbar a');
            links.forEach(link => link.classList.remove('active'));

            // Add 'active' to the clicked link
            clickedLink.classList.add('active');
        }

        document.querySelector(".left-btn").addEventListener("click", () => {
            document.getElementById("bookList").scrollBy({
                left: -200,
                behavior: 'smooth'
            });
        });

        document.querySelector(".right-btn").addEventListener("click", () => {
            document.getElementById("bookList").scrollBy({
                left: 200,
                behavior: 'smooth'
            });
        });
    </script>



</body>

</html>