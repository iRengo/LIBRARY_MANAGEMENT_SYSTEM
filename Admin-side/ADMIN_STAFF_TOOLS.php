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
    <?PHP INCLUDE 'HEADER-NAVBAR.PHP' ?>
    
            <!-- Content HERE -->
<div class="navbar" id="navbar">
    <a href="#" onclick="showSection('book-cataloging', this)">Book Cataloging</a>
    <a href="#" onclick="showSection('generate-report', this)">Generate Report</a>
    <a href="#" onclick="showSection('library-inventory', this)">Library Inventory</a>
    <a href="#" onclick="showSection('circulation-records', this)">Circulation Records</a>
    <a href="#" onclick="showSection('manage-patrons', this)">Manage Users</a>
</div>




<div class="main-container">
    <div id="book-cataloging" class="content-section">
    <div class="book-details">
        <h2>BOOK DETAILS</h2>

        <div class="form-row">
            <input type="text" placeholder="Title">
            <input type="text" placeholder="Author">
            <input type="text" placeholder="ISBN">
            <input type="text" placeholder="Genre">
        </div>
        <div class="form-row">
            <input type="date" placeholder="Publication Date">
            <input type="text" placeholder="Publisher">
            <input type="file" placeholder="Cover Image">
            <input type="number" placeholder="Number Of Copies">
        </div>
        <div class="form-row">
            <textarea rows="4" placeholder="Description" style="width: 100%;"></textarea>
        </div>

   
        <div class="book-list">
            <h3>LIST OF BOOKS</h3>
            <div class="book-item">
                <img class="book-cover" src="cover1.jpg" alt="Cover">
                <div class="book-details-text">
                    <p><strong>Title:</strong> Soul</p>
                    <p><strong>Author:</strong> Chris Moore</p>
                    <p><strong>ISBN:</strong> 978-1987-2345</p>
                    <p><strong>Description:</strong> A captivating story about...</p>
                </div>
                <div class="book-actions">
                    <button>Edit</button>
                    <button>Publish</button>
                    <button>Archive</button>
                </div>
            </div>
            <!-- Add more book-item as needed -->
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
                <strong>MONTHLY RESERVATION OVERVIEW</strong><br>
                Date Generated: <?php echo date("m-d-Y"); ?>
            </div>
            <div class="filters">
                <select class="report-select">
                    <option value="">word/pdf...</option>
                    <option value="pdf">PDF</option>
                    <option value="word">Word</option>
                </select>
                <input type="date" class="report-date">
            </div>
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th>RESERVED BY</th>
                    <th>BOOK TITLE</th>
                    <th>AUTHOR</th>
                    <th>RESERVATION DATE</th>
                    <th>DUE DATE</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>John Reyes</td>
                <td>The Alchemist</td>
                <td>Paulo Coelho</td>
                <td>2025-05-15</td>
                <td>2025-05-30</td>
                <td>Returned</td>
            </tr>
            <tr>
                <td>Ana Dela Cruz</td>
                <td>To Kill a Mockingbird</td>
                <td>Harper Lee</td>
                <td>2025-05-10</td>
                <td>2025-05-25</td>
                <td>Still Borrowing</td>
            </tr>
            <tr>
                <td>Marco Santos</td>
                <td>1984</td>
                <td>George Orwell</td>
                <td>2025-05-05</td>
                <td>2025-05-20</td>
                <td>Overdue</td>
            </tr>
            <tr>
                <td>Ella Villanueva</td>
                <td>Pride and Prejudice</td>
                <td>Jane Austen</td>
                <td>2025-05-12</td>
                <td>2025-05-27</td>
                <td>Returned</td>
            </tr>
            <tr>
                <td>Brian Gomez</td>
                <td>The Great Gatsby</td>
                <td>F. Scott Fitzgerald</td>
                <td>2025-05-18</td>
                <td>2025-06-02</td>
                <td>Still Borrowing</td>
            </tr>
            <tr>
                <td>Samantha Cruz</td>
                <td>Harry Potter and the Sorcerer’s Stone</td>
                <td>J.K. Rowling</td>
                <td>2025-05-14</td>
                <td>2025-05-29</td>
                <td>Returned</td>
            </tr>
            <tr>
                <td>Luis Mercado</td>
                <td>The Catcher in the Rye</td>
                <td>J.D. Salinger</td>
                <td>2025-05-11</td>
                <td>2025-05-26</td>
                <td>Overdue</td>
            </tr>
            <tr>
                <td>Andrea Torres</td>
                <td>The Hobbit</td>
                <td>J.R.R. Tolkien</td>
                <td>2025-05-09</td>
                <td>2025-05-24</td>
                <td>Returned</td>
            </tr>
            <tr>
                <td>James Lim</td>
                <td>Animal Farm</td>
                <td>George Orwell</td>
                <td>2025-05-13</td>
                <td>2025-05-28</td>
                <td>Still Borrowing</td>
            </tr>
            <tr>
                <td>Nina Angeles</td>
                <td>Little Women</td>
                <td>Louisa May Alcott</td>
                <td>2025-05-16</td>
                <td>2025-05-31</td>
                <td>Returned</td>
            </tr>
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
<!-- Generate report -->


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
                <th>BOOK TITLE</th>
                <th>AUTHOR</th>
                <th>ISBN</th>
                <th>NO. OF BOOKS</th>
                <th>GENRE</th>
                <th>PUBLISHER</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>The Great Gatsby</td>
                <td>F. Scott Fitzgerald</td>
                <td>9780743273565</td>
                <td>5</td>
                <td>Fiction</td>
                <td>Scribner</td>
                <td>
                    <button class="action-btn edit-btn" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="action-btn delete-btn" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <button class="action-btn archived-btn" title="Archived">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>To Kill a Mockingbird</td>
                <td>Harper Lee</td>
                <td>9780060935467</td>
                <td>3</td>
                <td>Classic</td>
                <td>J.B. Lippincott & Co.</td>
                <td>
                    <button class="action-btn edit-btn" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="action-btn delete-btn" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <button class="action-btn archived-btn" title="Archived">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>1984</td>
                <td>George Orwell</td>
                <td>9780451524935</td>
                <td>7</td>
                <td>Dystopian</td>
                <td>Secker & Warburg</td>
                <td>
                    <button class="action-btn edit-btn" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="action-btn delete-btn" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <button class="action-btn archived-btn" title="Archived">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>Pride and Prejudice</td>
                <td>Jane Austen</td>
                <td>9780141040349</td>
                <td>4</td>
                <td>Romance</td>
                <td>Penguin Classics</td>
                <td>
                    <button class="action-btn edit-btn" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="action-btn delete-btn" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <button class="action-btn archived-btn" title="Archived">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>The Hobbit</td>
                <td>J.R.R. Tolkien</td>
                <td>9780547928227</td>
                <td>6</td>
                <td>Fantasy</td>
                <td>George Allen & Unwin</td>
                <td>
                    <button class="action-btn edit-btn" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="action-btn delete-btn" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <button class="action-btn archived-btn" title="Archived">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>The Catcher in the Rye</td>
                <td>J.D. Salinger</td>
                <td>9780316769488</td>
                <td>8</td>
                <td>Fiction</td>
                <td>Little, Brown and Company</td>
                <td>
                    <button class="action-btn edit-btn" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="action-btn delete-btn" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <button class="action-btn archived-btn" title="Archived">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>Brave New World</td>
                <td>Aldous Huxley</td>
                <td>9780060850524</td>
                <td>5</td>
                <td>Science Fiction</td>
                <td>Chatto & Windus</td>
                <td>
                    <button class="action-btn edit-btn" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="action-btn delete-btn" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <button class="action-btn archived-btn" title="Archived">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>Harry Potter and the Sorcerer's Stone</td>
                <td>J.K. Rowling</td>
                <td>9780590353427</td>
                <td>10</td>
                <td>Fantasy</td>
                <td>Bloomsbury</td>
                <td>
                    <button class="action-btn edit-btn" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="action-btn delete-btn" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <button class="action-btn archived-btn" title="Archived">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>Moby Dick</td>
                <td>Herman Melville</td>
                <td>9781503280786</td>
                <td>2</td>
                <td>Adventure</td>
                <td>Harper & Brothers</td>
                <td>
                    <button class="action-btn edit-btn" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="action-btn delete-btn" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <button class="action-btn archived-btn" title="Archived">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>The Odyssey</td>
                <td>Homer</td>
                <td>9780140268867</td>
                <td>5</td>
                <td>Epic</td>
                <td>Penguin Classics</td>
                <td>
                    <button class="action-btn edit-btn" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="action-btn delete-btn" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <button class="action-btn archived-btn" title="Archived">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                </td>
            </tr>
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
                    <th>RETURN DATE</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>The Great Gatsby</td>
                    <td>Jane Doe</td>
                    <td>2025-05-10</td>
                    <td>2025-05-20</td>
                    <td>2025-05-18</td>
                    <td>Returned</td>
                    <td>
                        <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="action-btn delete-btn"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>To Kill a Mockingbird</td>
                    <td>John Smith</td>
                    <td>2025-05-01</td>
                    <td>2025-05-10</td>
                    <td>2025-05-09</td>
                    <td>Returned</td>
                    <td>
                        <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="action-btn delete-btn"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>1984</td>
                    <td>Maria Clara</td>
                    <td>2025-05-05</td>
                    <td>2025-05-15</td>
                    <td>2025-05-20</td>
                    <td>Overdue</td>
                    <td>
                        <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="action-btn delete-btn"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>Harry Potter and the Sorcerer's Stone</td>
                    <td>Elijah Cruz</td>
                    <td>2025-05-15</td>
                    <td>2025-05-25</td>
                    <td>-</td>
                    <td>Borrowed</td>
                    <td>
                        <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="action-btn delete-btn"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>Pride and Prejudice</td>
                    <td>Grace Lee</td>
                    <td>2025-05-12</td>
                    <td>2025-05-22</td>
                    <td>2025-05-22</td>
                    <td>Returned</td>
                    <td>
                        <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="action-btn delete-btn"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>Little Women</td>
                    <td>Samuel Tan</td>
                    <td>2025-04-25</td>
                    <td>2025-05-05</td>
                    <td>2025-05-10</td>
                    <td>Overdue</td>
                    <td>
                        <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="action-btn delete-btn"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>The Hobbit</td>
                    <td>Andrea Ramos</td>
                    <td>2025-05-17</td>
                    <td>2025-05-27</td>
                    <td>-</td>
                    <td>Borrowed</td>
                    <td>
                        <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="action-btn delete-btn"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>Life of Pi</td>
                    <td>Kevin Yu</td>
                    <td>2025-04-20</td>
                    <td>2025-04-30</td>
                    <td>2025-05-02</td>
                    <td>Overdue</td>
                    <td>
                        <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="action-btn delete-btn"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>The Catcher in the Rye</td>
                    <td>Louise Navarro</td>
                    <td>2025-05-02</td>
                    <td>2025-05-12</td>
                    <td>2025-05-11</td>
                    <td>Returned</td>
                    <td>
                        <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="action-btn delete-btn"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>The Alchemist</td>
                    <td>Joshua Lim</td>
                    <td>2025-05-18</td>
                    <td>2025-05-28</td>
                    <td>-</td>
                    <td>Borrowed</td>
                    <td>
                        <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="action-btn delete-btn"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
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


    <!-- Manage Users -->
    <div id="manage-patrons" class="content-section" style="display: none;">
        <div class="book-details">
            <h2>Manage Users</h2>
            <div class="user-header">
                <div class="filters">
                    <input type="text" class="user-search" placeholder="Search Users">
                    <button class="user-filter-btn" title="Filter">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                </div>
                <button class="add-user-btn">Add new Users</button>
            </div>

            <table class="user-table">
                <thead>
                    <tr>
                        <th>USERNAME</th>
                        <th>USER ID</th>
                        <th>STATUS</th>
                        <th>FINES</th>
                        <th>LAST BORROWED DATE</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
            <tr>
                <td>Garcia, Juan D.</td>
                <td>2025-0001-0001</td>
                <td>Active</td>
                <td>₱0.00</td>
                <td>01/05/2025</td>
                <td>
                    <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="action-btn view-btn"><i class="fa-solid fa-address-card"></i></button>
                </td>
            </tr>
            <tr>
                <td>Santos, Maria L.</td>
                <td>2025-0001-0002</td>
                <td>Inactive</td>
                <td>₱100.00</td>
                <td>15/03/2025</td>
                <td>
                    <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="action-btn view-btn"><i class="fa-solid fa-address-card"></i></button>
                </td>
            </tr>
            <tr>
                <td>Reyes, Carlos M.</td>
                <td>2025-0001-0003</td>
                <td>Active</td>
                <td>₱10.00</td>
                <td>22/04/2025</td>
                <td>
                    <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="action-btn view-btn"><i class="fa-solid fa-address-card"></i></button>
                </td>
            </tr>
            <tr>
                <td>Dela Cruz, Ana B.</td>
                <td>2025-0001-0004</td>
                <td>Active</td>
                <td>₱0.00</td>
                <td>10/05/2025</td>
                <td>
                    <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="action-btn view-btn"><i class="fa-solid fa-address-card"></i></button>
                </td>
            </tr>
            <tr>
                <td>Lopez, Mark C.</td>
                <td>2025-0001-0005</td>
                <td>Inactive</td>
                <td>₱100.00</td>
                <td>05/02/2025</td>
                <td>
                    <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="action-btn view-btn"><i class="fa-solid fa-address-card"></i></button>
                </td>
            </tr>
            <tr>
                <td>Mendoza, Paula E.</td>
                <td>2025-0001-0006</td>
                <td>Active</td>
                <td>₱0.00</td>
                <td>12/05/2025</td>
                <td>
                    <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="action-btn view-btn"><i class="fa-solid fa-address-card"></i></button>
                </td>
            </tr>
            <tr>
                <td>Torres, Elijah F.</td>
                <td>2025-0001-0007</td>
                <td>Active</td>
                <td>₱100.00</td>
                <td>20/04/2025</td>
                <td>
                    <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="action-btn view-btn"><i class="fa-solid fa-address-card"></i></button>
                </td>
            </tr>
            <tr>
                <td>Fernandez, Rica G.</td>
                <td>2025-0001-0008</td>
                <td>Inactive</td>
                <td>₱15.00</td>
                <td>18/01/2025</td>
                <td>
                    <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="action-btn view-btn"><i class="fa-solid fa-address-card"></i></button>
                </td>
            </tr>
            <tr>
                <td>Ramos, Kevin H.</td>
                <td>2025-0001-0009</td>
                <td>Active</td>
                <td>₱0.00</td>
                <td>02/05/2025</td>
                <td>
                    <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="action-btn view-btn"><i class="fa-solid fa-address-card"></i></button>
                </td>
            </tr>
            <tr>
                <td>Villanueva, Grace I.</td>
                <td>2025-0001-0010</td>
                <td>Active</td>
                <td>₱0.00</td>
                <td>11/05/2025</td>
                <td>
                    <button class="action-btn edit-btn"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="action-btn view-btn"><i class="fa-solid fa-address-card"></i></button>
                </td>
            </tr>
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
    <!-- Manage Users -->


</div>

            <!-- Content HERE -->

        <!-- ========================= Main END ==================== -->


        <script>
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
        </script>



</body>
</html>