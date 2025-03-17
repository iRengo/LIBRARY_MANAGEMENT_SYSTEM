<?php
include '../homepage/db_connect.php';

// Initialize counts
$totalAdmins = $totalLibrarians = $totalStudents = 0;

// Get total Admins
$adminQuery = "SELECT COUNT(*) AS totalAdmins FROM admin_acc";
$adminResult = $conn->query($adminQuery);
if ($adminResult && $adminRow = $adminResult->fetch_assoc()) {
    $totalAdmins = $adminRow['totalAdmins'];
}

// Get total Librarians
$librarianQuery = "SELECT COUNT(*) AS totalLibrarians FROM librarian_acc";
$librarianResult = $conn->query($librarianQuery);
if ($librarianResult && $librarianRow = $librarianResult->fetch_assoc()) {
    $totalLibrarians = $librarianRow['totalLibrarians'];
}

// Get total Students
$studentQuery = "SELECT COUNT(*) AS totalStudents FROM stud_acc";
$studentResult = $conn->query($studentQuery);
if ($studentResult && $studentRow = $studentResult->fetch_assoc()) {
    $totalStudents = $studentRow['totalStudents'];
}

// Total Users
$totalUsers = $totalAdmins + $totalLibrarians + $totalStudents;

// Fetch Student Accounts
$sql_students = "SELECT student_no AS user_id, first_name, last_name, email, last_logged_in, 'Student' AS role FROM stud_acc";
$result_students = $conn->query($sql_students);

// Fetch Librarian Accounts
$sql_librarian = "SELECT librarian_no AS user_id, first_name, last_name, email, last_logged_in, 'Librarian' AS role FROM librarian_acc";
$result_librarian = $conn->query($sql_librarian);

// Fetch Admin Accounts
$sql_admin = "SELECT admin_no AS user_id, first_name, last_name, email, last_logged_in, 'Admin' AS role FROM admin_acc";
$result_admin = $conn->query($sql_admin);

// Merge results into a unified array
$all_users = [];

if ($result_students->num_rows > 0) {
    while ($row = $result_students->fetch_assoc()) {
        $all_users[] = $row;
    }
}

if ($result_librarian->num_rows > 0) {
    while ($row = $result_librarian->fetch_assoc()) {
        $all_users[] = $row;
    }
}

if ($result_admin->num_rows > 0) {
    while ($row = $result_admin->fetch_assoc()) {
        $all_users[] = $row;
    }
}

$conn->close();

// Pagination settings
$users_per_page = 4;
$total_users = count($all_users);
$total_pages = ceil($total_users / $users_per_page);

// Get current page number
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, min($current_page, $total_pages));

// Slice users for the current page
$start_index = ($current_page - 1) * $users_per_page;
$users_on_page = array_slice($all_users, $start_index, $users_per_page);
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
    <link rel="stylesheet" href="ADMIN_USERS.CSS">
    <link rel="stylesheet" href="ADMIN_MODAL.css">
    <link rel="stylesheet" href="../User-side/USER_STYLE2.CSS">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ======= Scripts ====== -->


    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Previous/Next button styling */
        .pagination .page-item.disabled .page-link {
            background-color: #ccc;
            cursor: not-allowed;
            color: #666;
        }

        /* Pagination Styling */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .custom-pagination {
            display: flex;
            gap: 8px;
        }

        .pagination-btn {
            padding: 8px 12px;
            background-color: rgb(255, 255, 255);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
            border: 2px solid gray;
            color: #16264b;
        }

        .pagination-btn:hover {
            background-color: #16264b;
            color: white;
        }

        .pagination-btn.active {
            background-color: rgb(99, 95, 95);
            color:white;

        }
    </style>

</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <div class="admin-gradient">
                        <a href="#">
                            <span class="icon">
                                <ion-icon name="person-circle" class="admin-icon"></ion-icon>
                            </span>
                            <span class="title1">ANGELO MHYR</span>
                        </a>
                    </div>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Catalog</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Users</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Staff Tools</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="notifications-outline"></ion-icon>
                        </span>
                        <span class="title">Notifications</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Settings</span>
                    </a>
                </li>
                <div class="time-container" style="width: 150%;">
                    <p style="font-size: 10px; color:white;">
                        <?php echo date("l, F j, Y h:i:s"); // Full date and time format 
                        ?>
                    </p>
                </div>
            </ul>

        </div>


        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <div class="logo">
                    <img src="../logosample1.png" style="height: 60px; width:60px; padding:4px;">
                </div>
                <div style="float:left; margin-right:75%; display: flex; align-items: baseline;">
                    <p style="font-family: viga; margin: 0; padding-right:2px;">LIBRA</p>
                    <p style="font-family: zilla slab highlight; letter-spacing: 2px; margin: 0;">SPHERE</p>
                </div>
                <div class="logo" title="LOGOUT YOUR ACCOUNT" style="margin-right: 1%;">
                    <a href="#" id="logoutIcon">
                        <i class='bx bx-log-in-circle' style="font-size:35px;color:#da1b1b"></i>
                    </a>
                </div>
            </div>

            <!-- Modal Structure -->
            <div id="logoutModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Confirm Logout</h2>
                    <p>Are you sure you want to logout?</p>
                    <div class="modal-actions">
                        <a href="#" class="btn-action btn-yes">Yes</a>
                        <button class="btn-action btn-no" id="cancelLogout">No</button>
                    </div>
                </div>
            </div>

            <!-- Content HERE -->
            <div class="content" style="display: flex; align-items: flex-start;">
                <div class="table-container" style="flex: 2; margin-right: 20px;">
                    <h2 class="table-title">User Management</h2>
                    <h4 style="margin-top: -0.5%; font-weight:200; color:gray;"> Manage overall Users </h4>
                    <Br>
                    <div style="margin-top" style="margin-top: 3%;"> Total Accounts : <b> <?php echo $totalUsers ?> </b></div>
                    <br>

                    <!-- Search Bar -->
                    <div class="search-container" style="margin-bottom: 20px; display: flex; align-items: center;">
                        <input type="text" id="searchInput" placeholder="Search users..." style="padding: 8px; width: 100%; border-radius: 5px; border: 1px solid #ddd; font-size: 0.95rem;">
                        <button type="button" style="background-color: #1C2E5C; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; margin-left: 5px;">
                            <ion-icon name="search-outline" style="color: white; font-size: 1.2rem;"></ion-icon>
                        </button>
                    </div>
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Last Logged In</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <?php foreach ($users_on_page as $user): ?>

                                <tr>
                                    <td><?= htmlspecialchars($user['user_id'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($user['first_name'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($user['last_name'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($user['role'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($user['email'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($user['last_logged_in'] ?? 'N/A'); ?></td>
                                    <td>
                                        <button class="btn-action delete" data-id="<?= $user['user_id']; ?>" data-role="<?= $user['role']; ?>">Delete</button>
                                        <button class="btn-action archive">Archive</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>


                    <!-- Pagination Controls -->
                    <div class="pagination-container">
                        <p style="color:gray;">Page <?= $current_page ?> of <?= $total_pages ?></p>
                        <div class="custom-pagination">
                            <?php if ($current_page > 1): ?>
                                <a class="pagination-btn" href="?page=<?= $current_page - 1 ?>">Previous</a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a class="pagination-btn <?= ($i == $current_page) ? 'active' : '' ?>" href="?page=<?= $i ?>"><?= $i ?></a>
                            <?php endfor; ?>

                            <?php if ($current_page < $total_pages): ?>
                                <a class="pagination-btn" href="?page=<?= $current_page + 1 ?>">Next</a>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
                <!-- Sidebar for Actions -->
                <div class="sidebar" style="flex: 1; max-width: 250px;">
                    <div class="sidebar-tools" style="background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                        <h4 style="margin-bottom: 15px; color: #333;">Actions</h4>
                        <button style="background-color: #1C2E5C; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; font-size: 0.95rem; width: 100%; margin-bottom: 15px;" id="addUserBtn" class="btn-action">Add New User</button>
                        <hr>
                        <h5 style="margin-bottom: 10px;">Filter by Role:</h5>
                        <div>
                            <input type="checkbox" id="filterLibrarian" name="role" value="Librarian">
                            <label for="filterLibrarian">Librarian</label>
                        </div>

                        <div>
                            <input type="checkbox" id="filterUser" name="role" value="Student">
                            <label for="filterUser">Student</label>
                        </div>

                        <div>
                            <input type="checkbox" id="filterAdmin" name="role" value="Admin">
                            <label for="filterAdmin">Admin</label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="addUserModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h2>Add New User</h2>
            <form id="addUserForm">
                <label>Email:</label>
                <input type="email" id="userEmail" name="userEmail" required>

                <label>Role:</label><br>
                <input type="radio" id="librarian" name="role" value="Librarian" required>
                <label for="librarian">Add as Librarian</label><br>
                <input type="radio" id="admin" name="role" value="Admin" required>
                <label for="admin">Add as Admin</label><br>

                <div class="modal-actions">
                    <button type="submit">Send Invitation</button>
                    <button type="button" id="closeModal">Cancel</button>
                </div>
            </form>
        </div>
    </div>



    </div>
    <!-- ========================= Main END ==================== -->



    <!-- =========== Scripts =========  -->
    <script src="admin.js"></script>
    <script src="ADMIN_MODAL.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const deleteButtons = document.querySelectorAll('.delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.closest('tr').querySelector('td').textContent.trim();
                    const userRole = this.closest('tr').querySelector('td:nth-child(4)').textContent.trim();

                    // SweetAlert2 Confirmation
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Send AJAX request to delete user
                            fetch('delete_user.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: `user_id=${userId}&role=${userRole}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire("Deleted!", "User has been deleted.", "success")
                                            .then(() => location.reload());
                                    } else {
                                        Swal.fire("Error!", data.error, "error");
                                    }
                                })
                                .catch(() => {
                                    Swal.fire("Oops!", "Something went wrong.", "error");
                                });
                        }
                    });
                });
            });
        });
    </script>
    <script>
        // Open SweetAlert2 Modal for Adding a New User
        document.getElementById('addUserBtn').addEventListener('click', () => {
            Swal.fire({
                title: 'Add New User',
                html: `
           <div style="text-align: center;">

    <input type="email" id="userEmail" class="swal2-input" placeholder="Enter user email" required><br><br>

    <label><b>ADD THIS USER AS:</b></label><br>
    <div style="display: flex; justify-content: center; gap: 20px; padding: 10px 0;">
        <label>
            <input type="radio" id="admin" name="role" value="Admin"> ADMIN
        </label>

        <label>
            <input type="radio" id="librarian" name="role" value="Librarian"> LIBRARIAN
        </label>
    </div>

</div>
        `,
                confirmButtonText: 'Send Invitation',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const email = Swal.getPopup().querySelector('#userEmail').value;
                    const role = Swal.getPopup().querySelector('input[name="role"]:checked')?.value;

                    if (!email || !role) {
                        Swal.showValidationMessage('Please fill in all fields.');
                    }

                    return {
                        email,
                        role
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const {
                        email,
                        role
                    } = result.value;

                    // Send data to backend
                    fetch('invite_user.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `email=${encodeURIComponent(email)}&role=${encodeURIComponent(role)}` // ✅ Updated keys
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Sent!', 'User invitation has been sent.', 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Error!', data.message || 'Unknown error occurred.', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Oops!', 'Something went wrong.', 'error');
                        });
                }
            });
        });
    </script>



    <script>
        const searchInput = document.getElementById('searchInput');
        const userTableBody = document.getElementById('userTableBody');
        const filterLibrarian = document.getElementById('filterLibrarian');
        const filterStudent = document.getElementById('filterUser');
        const filterAdmin = document.getElementById('filterAdmin'); // Admin filter

        function filterUsers() {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = userTableBody.getElementsByTagName('tr');

            // Capture checkbox states
            const showLibrarian = filterLibrarian.checked;
            const showStudent = filterStudent.checked;
            const showAdmin = filterAdmin.checked; // Admin filter

            for (const row of rows) {
                const cells = row.getElementsByTagName('td');

                // Ensure we have the right index for the role
                const role = (cells.length >= 4) ? cells[3].textContent.trim() : '';

                // Get all cell contents for search matching
                const text = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');

                // Check if the row matches search and the selected roles
                const matchesSearch = text.includes(searchTerm);
                const matchesRole = (!showLibrarian && !showStudent && !showAdmin) ||
                    (showLibrarian && role === 'Librarian') ||
                    (showStudent && role === 'Student') ||
                    (showAdmin && role === 'Admin'); // Added Admin check

                // Display the row if both search and role match
                row.style.display = (matchesSearch && matchesRole) ? '' : 'none';
            }
        }

        // Attach event listeners for live search and role filters
        searchInput.addEventListener('input', filterUsers);
        filterLibrarian.addEventListener('change', filterUsers);
        filterStudent.addEventListener('change', filterUsers);
        filterAdmin.addEventListener('change', filterUsers); // Admin checkbox
    </script>



    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>