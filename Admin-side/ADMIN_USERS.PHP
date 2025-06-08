<?php
include '../homepage/db_connect.php';
session_start();


// Check if the admin session exists
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
// Function to convert the last_logged_in timestamp into a human-readable relative time
function timeAgo($timestamp)
{
    // If the timestamp is empty or NULL, return "N/A"
    if (empty($timestamp)) {
        return "N/A"; // Return "N/A" if last_logged_in is null or empty
    }

    // Convert the timestamp into a Unix timestamp
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;

    // Seconds, minutes, hours, days, weeks, months, years
    $minutes      = round($seconds / 60);
    $hours        = round($seconds / 3600);
    $days         = round($seconds / 86400);
    $weeks        = round($seconds / 604800);
    $months       = round($seconds / 2629440);
    $years        = round($seconds / 31553280);

    // Now, we need to display appropriate relative time:
    if ($seconds <= 60) {
        return "Just Now";
    } else if ($minutes <= 60) {
        if ($minutes == 1) {
            return "one minute ago";
        } else {
            return "$minutes minutes ago";
        }
    } else if ($hours <= 24) {
        if ($hours == 1) {
            return "an hour ago";
        } else {
            return "$hours hours ago";
        }
    } else if ($days <= 7) {
        if ($days == 1) {
            return "yesterday";
        } else {
            return "$days days ago";
        }
    } else if ($weeks <= 4.3) { // 4.3 == 30/7
        if ($weeks == 1) {
            return "one week ago";
        } else {
            return "$weeks weeks ago";
        }
    } else if ($months <= 12) {
        if ($months == 1) {
            return "one month ago";
        } else {
            return "$months months ago";
        }
    } else {
        if ($years == 1) {
            return "one year ago";
        } else {
            return "$years years ago";
        }
    }
}

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
$totalUsers = $totalLibrarians + $totalStudents;

// Fetch Student Accounts
$sql_students = "SELECT acc_no, first_name, last_name, email, last_logged_in FROM stud_acc";
$result_students = $conn->query($sql_students);

// Fetch Librarian Accounts
$sql_librarian = "SELECT librarian_no, first_name, last_name, email, last_logged_in FROM librarian_acc";
$result_librarian = $conn->query($sql_librarian);

// Merge results into a unified array
$all_users = [];

if ($result_students->num_rows > 0) {
    while ($row = $result_students->fetch_assoc()) {
        $row['user_id'] = $row['acc_no'];
        $row['role'] = 'Student';
        $all_users[] = $row;
    }
}

if ($result_librarian->num_rows > 0) {
    while ($row = $result_librarian->fetch_assoc()) {
        $row['user_id'] = $row['librarian_no'];
        $row['role'] = 'Librarian';
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

    <link rel="stylesheet" href="ADMIN_USERS.CSS">
    <link rel="icon" type="image/png" href="../logosample1.png">
    <title> Admin User Management </title>

</head>

<body>

    <?php include 'HEADER-NAVBAR.PHP'; ?>

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
                            <td><?= timeAgo($user['last_logged_in']); ?></td>
                            <td>
                                <button class="btn-action delete" data-id="<?= $user['user_id']; ?>" data-role="<?= $user['role']; ?>">Delete</button>
                                <button class="btn-action archive"
                                    data-id="<?= htmlspecialchars($user['user_id'] ?? ''); ?>"
                                    data-role="<?= htmlspecialchars($user['role'] ?? ''); ?>">
                                    Archive
                                </button>
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



                <!-- New Archived Button -->
                <button style="background-color: #ff5733; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; font-size: 0.95rem; width: 100%; margin-top: 15px; border:2px solid gray; color:black; background-color:white;" id="viewArchivedBtn">View Archived</button>
            </div>
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




    <script>
        document.getElementById("viewArchivedBtn").addEventListener("click", function() {
            console.log('View Archived button clicked');
            fetchArchivedUsers();
        });

        function fetchArchivedUsers() {
            fetch("fetched_archived.php")
                .then(response => {
                    console.log('Response:', response); // Log the response to the console
                    return response.json();
                })
                .then(data => {
                    console.log('Data:', data); // Log the data to check the structure

                    // If no archived users, show an info message
                    if (data.length === 0) {
                        Swal.fire({
                            title: 'No Archived Users',
                            text: 'There are no archived users to display.',
                            icon: 'info',
                            confirmButtonText: 'Close'
                        });
                        return;
                    }

                    // Create the table HTML structure to display the archived users
                    let tableContent = "<table class='archived-users-table'>";
                    tableContent += "<thead><tr><th>Archived ID</th><th>User ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Role</th><th>Archived At</th><th>Actions</th></tr></thead>";
                    tableContent += "<tbody>";

                    // Loop through each archived user and add a row to the table
                    data.forEach(user => {
                        tableContent += `
                        <tr>
                            <td>${user.archived_id}</td>
                            <td>${user.user_id}</td>
                            <td>${user.first_name}</td>
                            <td>${user.last_name}</td>
                            <td>${user.email}</td>
                            <td>${user.role}</td>
                            <td>${user.archived_at}</td>
                            <td>
                            <button class="restoreBtn" data-id="${user.archived_id}" data-user-id="${user.user_id}" data-role="${user.role}">Restore</button>
<button class="deleteBtn" data-id="${user.archived_id}">Delete</button>
                            
                        </tr>
                    `;
                    });

                    tableContent += "</tbody></table>";

                    Swal.fire({
                        title: 'Archived Users',
                        html: tableContent, // Insert the table into the modal
                        showCloseButton: true,
                        showCancelButton: false,
                        confirmButtonText: 'Close',
                        confirmButtonColor: '#1C2E5C',
                        width: '80%',
                        heightAuto: true,
                        didOpen: () => {
                            // Add event listeners for the buttons in the modal
                            document.querySelectorAll('.restoreBtn').forEach(button => {
                                button.addEventListener('click', function() {
                                    const archivedId = this.dataset.id;
                                    const userId = this.dataset.userId;
                                    const role = this.dataset.role;
                                    restoreUser(archivedId, userId, role);
                                });
                            });

                            document.querySelectorAll('.deleteBtn').forEach(button => {
                                button.addEventListener('click', function() {
                                    const archivedId = this.dataset.id;
                                    deleteUser(archivedId);
                                });
                            });
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching archived users:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'There was an error fetching the archived users.',
                        icon: 'error',
                        confirmButtonText: 'Close'
                    });
                });
        }

        function restoreUser(archivedId, userId, role) {
            fetch('restore_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        archived_id: archivedId,
                        user_id: userId, // Pass the primary key for the archived user
                        role: role // Pass the role (Admin, Librarian, or Student)
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Restore user response:', data); // Log the response for debugging
                    if (data.success) {
                        Swal.fire({
                            title: 'Restored Successfully',
                            text: 'The user has been restored to their original table.',
                            icon: 'success',
                            confirmButtonText: 'Close'
                        }).then(() => {
                            location.reload(); // Reload the page to reflect changes
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'There was an error restoring the user.',
                            icon: 'error',
                            confirmButtonText: 'Close'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'There was an error restoring the user.',
                        icon: 'error',
                        confirmButtonText: 'Close'
                    });
                });
        }

        // Function to delete the archived user permanently
        function deleteUser(archivedId) {
            fetch('delete_user_arc.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        archived_id: archivedId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Deleted Successfully',
                            text: 'The user has been permanently deleted from the archive.',
                            icon: 'success',
                            confirmButtonText: 'Close'
                        }).then(() => {
                            location.reload(); // Reload the page to reflect changes
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'There was an error deleting the user.',
                            icon: 'error',
                            confirmButtonText: 'Close'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'There was an error deleting the user.',
                        icon: 'error',
                        confirmButtonText: 'Close'
                    });
                });
        }

        document.querySelectorAll('.btn-action.archive').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                const role = this.getAttribute('data-role');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This account will be archived!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, archive it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('archive_user.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: `user_id=${userId}&role=${role}`
                            })
                            .then(response => response.text())
                            .then(result => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Archived!',
                                    text: result,
                                    confirmButtonText: 'OK' // Enables OK button
                                }).then(() => {
                                    location.reload(); // Refresh after user clicks OK
                                });
                            })
                            .catch(error => {
                                console.error('Error archiving user:', error);
                                Swal.fire('Error', 'An error occurred while archiving the user.', 'error');
                            });
                    }
                });
            });
        });
    </script>


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

        function filterUsers() {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = userTableBody.getElementsByTagName('tr');
            let noResultsFound = true;

            const showLibrarian = filterLibrarian.checked;
            const showStudent = filterStudent.checked;

            for (const row of rows) {
                const cells = row.getElementsByTagName('td');
                const role = (cells.length >= 4) ? cells[3].textContent.trim() : '';
                const text = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');

                const matchesSearch = text.includes(searchTerm);
                const matchesRole = (!showLibrarian && !showStudent) ||
                    (showLibrarian && role === 'Librarian') ||
                    (showStudent && role === 'Student');

                if (matchesSearch && matchesRole) {
                    row.style.display = '';
                    noResultsFound = false;
                } else {
                    row.style.display = 'none';
                }
            }

            // Handle "No results found"
            const noResultsRow = document.getElementById('noResultsRow');
            if (noResultsFound) {
                if (!noResultsRow) {
                    const row = document.createElement('tr');
                    row.id = 'noResultsRow';
                    const cell = document.createElement('td');
                    cell.colSpan = 7;
                    cell.style.textAlign = 'center';
                    cell.textContent = 'No results found';
                    row.appendChild(cell);
                    userTableBody.appendChild(row);
                }
            } else {
                if (noResultsRow) {
                    noResultsRow.remove();
                }
            }
        }

        searchInput.addEventListener('input', filterUsers);
        filterLibrarian.addEventListener('change', filterUsers);
        filterStudent.addEventListener('change', filterUsers);
    </script>

</body>

</html>