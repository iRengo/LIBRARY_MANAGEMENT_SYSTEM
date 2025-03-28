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
            color: white;


        }

        .archived-users-table th,
        .archived-users-table td {
            padding: 10px;
            border: 1px solid #ddd;
            /* Light gray border */
            text-align: center;
        }

        .archived-users-table th {
            background-color: rgb(62, 79, 120);
            /* Dark color for the header */
            color: white;
            /* White text for the header */
        }

        .archived-users-table {
            width: 100%;
            /* Set the width of the table */
            margin: 0 auto;
            /* This will horizontally center the table */
            border-collapse: collapse;
        }

        .archived-users-table tr:nth-child(even) {
            background-color: #f2f2f2;
            /* Alternate row color */
        }

        .archived-users-table tr:hover {
            background-color: #ddd;
            /* Hover effect for rows */
        }

        /* General Button Styling */
        button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s ease;
            color: white;
            font-weight: bold;
            text-align: center;
            margin: 5px;
        }

        /* Restore Button Styling */
        .restoreBtn {
            background-color: #4CAF50;
            /* Green for restore */
            box-shadow: 0 4px 6px rgba(0, 255, 0, 0.2);
            /* Light green shadow for a 3D effect */
        }

        .restoreBtn:hover {
            background-color: #45a049;
            box-shadow: 0 6px 12px rgba(0, 255, 0, 0.3);
            /* Darker shadow on hover */
        }

        .restoreBtn:focus {
            outline: none;
        }

        /* Delete Button Styling */
        .deleteBtn {
            background-color: #f44336;
            /* Red for delete */
            box-shadow: 0 4px 6px rgba(255, 0, 0, 0.2);
            /* Light red shadow for 3D effect */
        }

        .deleteBtn:hover {
            background-color: #e53935;
            box-shadow: 0 6px 12px rgba(255, 0, 0, 0.3);
            /* Darker shadow on hover */
        }

        .deleteBtn:focus {
            outline: none;
        }

        /* Responsive Styling for Buttons */
        button {
            width: 150px;
            /* Ensure buttons have a consistent size */
            font-size: 14px;
            /* Reduce font size for smaller screens */
        }

        @media (max-width: 600px) {
            button {
                width: 100%;
                /* Full width for buttons on mobile */
                font-size: 16px;
            }
        }

        /* Hover/Focus State */
        button:hover,
        button:focus {
            transform: translateY(-2px);
            /* Slightly lift the button */
        }

        button:active {
            transform: translateY(2px);
            /* Move the button slightly down on click */
        }

        /* Optional: Add some space between the buttons if needed */
        button+button {
            margin-left: 10px;
        }
    </style>

</head>

<body>
 <Br><Br><br><Br><Br>
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
                                    <td>
                                        <?php
                                        // Convert last_logged_in to relative time format
                                        echo timeAgo($user['last_logged_in']);
                                        ?>
                                    </td>
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



    <!-- =========== Scripts =========  -->
    <script src="admin.js"></script>
    <script src="ADMIN_MODAL.js"></script>
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
        const filterAdmin = document.getElementById('filterAdmin'); // Admin filter

        function filterUsers() {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = userTableBody.getElementsByTagName('tr');
            let noResultsFound = true; // Flag to track if there are any results

            // Capture checkbox states
            const showLibrarian = filterLibrarian.checked;
            const showStudent = filterStudent.checked;
            const showAdmin = filterAdmin.checked; // Admin filter

            // Loop through each row
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
                if (matchesSearch && matchesRole) {
                    row.style.display = ''; // Show row
                    noResultsFound = false; // At least one row is visible
                } else {
                    row.style.display = 'none'; // Hide row
                }
            }

            // Check if no rows are visible
            if (noResultsFound) {
                // Create a new row for "No results found" message
                const noResultsRow = document.createElement('tr');
                const noResultsCell = document.createElement('td');
                noResultsCell.colSpan = 7; // Adjust colspan based on the number of columns in your table
                noResultsCell.style.textAlign = 'center';
                noResultsCell.textContent = 'No results found';
                noResultsRow.appendChild(noResultsCell);

                // If there isn't already a "No results" row, add it
                if (!document.getElementById('noResultsRow')) {
                    noResultsRow.id = 'noResultsRow';
                    userTableBody.appendChild(noResultsRow);
                }
            } else {
                // If there are results, remove the "No results" row if it exists
                const noResultsRow = document.getElementById('noResultsRow');
                if (noResultsRow) {
                    noResultsRow.remove();
                }
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