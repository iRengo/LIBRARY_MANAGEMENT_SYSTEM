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
                <h2>Book Details</h2>

                <!-- Hidden input to hold selected book ID -->
                <input type="hidden" id="selectedBookId">

                <div class="form-row">
                    <input type="text" id="bookTitle" placeholder="Title">
                    <input type="text" id="bookAuthor" placeholder="Author">
                    <input type="text" id="bookISBN" placeholder="ISBN" disabled>
                    <input type="text" id="bookGenre" placeholder="Category">
                </div>
                <div class="form-row">
                    <input type="date" id="bookPubDate" placeholder="Publication Date" disabled>
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
                <h2>Generate Report</h2>
                <div class="report-header">
                    <div class="overview">

                    </div>
                    <div class="form-buttons">
                        <form method="POST" action="ADMIN_GENERATE_REPORT.php" target="_blank">
                            <label for="report-type">Select Report Type:</label>
                            <select name="report_type" id="report-type">
                                <option value="RESERVATION">Reserved Books</option>
                                <option value="BORROWED">Borrowed Books</option>
                                <option value="FINES">Student Fines</option>
                                <option value="ALL">All Reports</option>
                            </select>
                            <button type="submit">Print Report</button>
                        </form>
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

                    // Hide all tables initially
                    reservedTable.style.display = "none";
                    borrowedTable.style.display = "none";
                    finesTable.style.display = "none";

                    if (selected === "RESERVATION") {
                        reservedTable.style.display = "table";
                    } else if (selected === "BORROWED") {
                        borrowedTable.style.display = "table";
                    } else if (selected === "FINES") {
                        finesTable.style.display = "table";
                    } else if (selected === "ALL") {
                        reservedTable.style.display = "table";
                        borrowedTable.style.display = "table";
                        finesTable.style.display = "table";
                    }
                }

                // Initialize on page load
                toggleReports();

                // Trigger toggle on dropdown change
                reportSelect.addEventListener("change", toggleReports);
            });
        </script>



        <!-- Library Inventory -->
        <div id="library-inventory" class="content-section" style="display: none;">
            <div class="book-details">
                <h2>Library Inventory</h2>
                <div class="inventory-header">
                    <div class="filters">
                        <input type="text" id="inventorySearch" class="report-date" placeholder="Search...">
                        <button class="filter-btn" title="Filter"><i class="fa-solid fa-search"></i></button>
                    </div>
                    <form method="POST" action="admin_print_book.php" target="_blank" style="display: inline;">
                        <button type="submit" class="print-book-btn">Print Report</button>
                    </form>
                </div>


                <table id="inventoryTable" class="report-table inventory-table">
                    <thead>
                        <tr>
                            <th>ISBN</th>
                            <th>BOOK TITLE</th>
                            <th>AUTHOR</th>
                            <th>BOOK STOCKS</th>
                            <th>GENRE</th>
                            <th>PUBLISHER</th>
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
                                </tr>
                        <?php
                            endwhile;
                        else:
                            echo "<tr><td colspan='7'>No books found.</td></tr>";
                        endif;

                        ?>
                    </tbody>
                </table>
                <div id="pagination-controls" style="margin-top: 15px; text-align: center;">
                    <button id="prevPage" class="pagination-btn">Previous</button>
                    <span id="pageInfo" style="margin: 0 10px;"></span>
                    <button id="nextPage" class="pagination-btn">Next</button>
                </div>

            </div>
        </div>


        <!-- Circulation Records -->
        <div id="circulation-records" class="content-section" style="display: none;">
            <div class="book-details">
                <h2>Circulation Records</h2>
                <div class="circulation-header">
                    <div class="filters">
                        <input type="text" id="circulationSearch" class="circulation-search" placeholder="Search records">

                        <button class="circulation-filter-btn" title="Filter">
                            <i class="fa-solid fa-search"></i>
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

                                </tr>
                        <?php
                            endwhile;
                        else:
                            echo "<tr><td colspan='7'>No borrowed books found.</td></tr>";
                        endif;
                        ?>
                    </tbody>

                    <form method="POST" action="admin_print_borrowed.php" target="_blank" style="display: inline; margin-bottom: 15px;">
                        <button type="submit" class="print-borrowed-btn">Print Report</button>
                    </form>
                </table>

            </div>
        </div>





    </div>

    <!-- Content HERE -->

    <!-- ========================= Main END ==================== -->


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const table = document.getElementById("inventoryTable");
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));
            const rowsPerPage = 5;
            let currentPage = 1;
            const totalPages = Math.ceil(rows.length / rowsPerPage);

            const prevBtn = document.getElementById("prevPage");
            const nextBtn = document.getElementById("nextPage");
            const pageInfo = document.getElementById("pageInfo");

            function showPage(page) {
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                rows.forEach((row, index) => {
                    row.style.display = (index >= start && index < end) ? "" : "none";
                });

                pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
                prevBtn.disabled = currentPage === 1;
                nextBtn.disabled = currentPage === totalPages;
            }

            prevBtn.addEventListener("click", () => {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                }
            });

            nextBtn.addEventListener("click", () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    showPage(currentPage);
                }
            });

            if (rows.length > 0) {
                showPage(currentPage);
            } else {
                pageInfo.textContent = "No records found.";
                prevBtn.disabled = true;
                nextBtn.disabled = true;
            }
        });

        $(document).ready(function() {
            $('#inventorySearch').on('input', function() {
                let searchQuery = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'admin_search_inventory.php',
                    data: {
                        inventory_search: searchQuery
                    },
                    success: function(response) {
                        $('.inventory-table tbody').html(response);
                    }
                });
            });
        });
        $(document).ready(function() {
            $('#circulationSearch').on('input', function() {
                let search = $(this).val();
                $.ajax({
                    url: 'admin_search_circulation.php',
                    method: 'POST',
                    data: {
                        query: search
                    },
                    success: function(response) {
                        $('.circulation-table tbody').html(response);
                    }
                });
            });
        });
       // Store selected book element
let selectedBookElement = null;

document.querySelectorAll('.book-item').forEach(item => {
    item.addEventListener('click', function () {
        // Highlight selected
        document.querySelectorAll('.book-item').forEach(b => b.classList.remove('selected'));
        this.classList.add('selected');
        selectedBookElement = this;

        // Fill input fields
        document.getElementById('selectedBookId').value = this.dataset.id;
        document.getElementById('bookTitle').value = this.dataset.title;
        document.getElementById('bookAuthor').value = this.dataset.author;
        document.getElementById('bookISBN').value = this.dataset.isbn;
        document.getElementById('bookGenre').value = this.dataset.genre;
        document.getElementById('bookPubDate').value = this.dataset.pubdate;
        document.getElementById('bookPublisher').value = this.dataset.publisher;
        document.getElementById('bookStocks').value = this.dataset.stocks;
        document.getElementById('bookDescription').value = this.dataset.description;
    });
});

document.querySelector('.save-btn').addEventListener('click', function () {
    const bookId = document.getElementById('selectedBookId').value;
    if (!bookId) {
        Swal.fire({
            icon: 'warning',
            title: 'No Book Selected',
            text: 'Please select a book first.'
        });
        return;
    }

    const data = {
        book_id: bookId,
        book_title: document.getElementById('bookTitle').value,
        book_author: document.getElementById('bookAuthor').value,
        ISBN: document.getElementById('bookISBN').value,
        book_category: document.getElementById('bookGenre').value,
        publication_date: document.getElementById('bookPubDate').value,
        publisher: document.getElementById('bookPublisher').value,
        book_stocks: document.getElementById('bookStocks').value,
        book_description: document.getElementById('bookDescription').value
    };

    fetch('ADMIN_EDIT_BOOK.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.text())
    .then(response => {
        // Use SweetAlert instead of alert
        Swal.fire({
            icon: response.includes('successfully') ? 'success' : 'error',
            title: response.includes('successfully') ? 'Success' : 'Error',
            text: response
        }).then(() => {
            if (response.includes('successfully')) {
                location.reload();
            }
        });
    });
});


document.querySelector('.cancel-btn').addEventListener('click', function () {
    // Clear inputs
    document.getElementById('selectedBookId').value = '';
    document.querySelectorAll('.form-row input, .form-row textarea').forEach(el => el.value = '');
    // Deselect book
    document.querySelectorAll('.book-item').forEach(el => el.classList.remove('selected'));
    selectedBookElement = null;
});

function showSection(sectionId, clickedLink) {
    // Hide all content sections
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(sec => sec.style.display = 'none');

    // Show selected section
    const targetSection = document.getElementById(sectionId);
    if (targetSection) {
        targetSection.style.display = 'block';
    }

    // Remove active from all links
    const links = document.querySelectorAll('.navbar a');
    links.forEach(link => link.classList.remove('active'));

    // Add active to clicked link
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