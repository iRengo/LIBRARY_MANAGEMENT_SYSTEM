<?php
session_start();
include '../homepage/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Librarian - User Management</title>
    <link rel="stylesheet" href="librarian_user_management.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>

    <div class="librarian-user-management">
        <!-- Header Section -->
        <div class="management-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2>USER MANAGEMENT</h2>
                    <p class="description">Manage and monitor students</p>
                </div>
                <button onclick="toggleView()" class="archive-toggle-btn">View Archived Students</button>
            </div>
        </div>

        <!-- Active Students Table -->
        <div id="activeStudents" class="user-box">
            <?php
            $activeQuery = mysqli_query($conn, "SELECT student_no, first_name, last_name, email, contact, last_logged_in FROM stud_acc");
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Last Logged In</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($activeQuery) > 0) {
                        while ($row = mysqli_fetch_assoc($activeQuery)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['student_no']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['last_logged_in']) . "</td>";
                            echo "<td>
                                <button class='icon-button archive' title='Archive' onclick=\"promptArchiveStudent('{$row['student_no']}')\">
                                    <ion-icon name='archive-outline'></ion-icon>
                                </button>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No student records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Archived Students Table -->
        <div id="archivedStudents" style="display: none;" class="user-box">
            <?php
            $archivedQuery = mysqli_query($conn, "SELECT * FROM archived_acc WHERE role = 'student'");
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Archive ID</th>
                        <th>Student no</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Archived at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($archivedQuery) > 0) {
                        while ($archived = mysqli_fetch_assoc($archivedQuery)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($archived['archived_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($archived['user_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($archived['first_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($archived['last_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($archived['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($archived['archived_at']) . "</td>";
                            echo "<td>
                                <button class='icon-button restore' title='Restore' onclick=\"promptRestoreStudent('{$archived['archived_id']}')\">
                                    <ion-icon name='refresh-outline'></ion-icon>
                                </button>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No archived students found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Scripts -->
        <script>
            function toggleView() {
                const active = document.getElementById("activeStudents");
                const archived = document.getElementById("archivedStudents");
                const button = document.querySelector(".archive-toggle-btn");

                if (active.style.display === "none") {
                    active.style.display = "block";
                    archived.style.display = "none";
                    button.textContent = "View Archived Students";
                } else {
                    active.style.display = "none";
                    archived.style.display = "block";
                    button.textContent = "Back to Active Students";
                }
            }

            function promptArchiveStudent(studentNo) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to archive this student?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, archive it!',
                    cancelButtonColor: '#d33',
                    confirmButtonColor: '#3085d6'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'LIBRARIAN_ARCHIVE_STUDENT.php',
                            type: 'POST',
                            data: { student_no: studentNo },
                            success: function(response) {
                                if (response == 'success') {
                                    Swal.fire('Archived!', 'The student has been archived.', 'success').then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('Error!', 'Failed to archive the student.', 'error');
                                }
                            }
                        });
                    }
                });
            }

            function promptRestoreStudent(archivedId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to restore this student?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, restore it!',
                    cancelButtonColor: '#d33',
                    confirmButtonColor: '#3085d6'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'LIBRARIAN_RESTORE_STUDENT.php',
                            type: 'POST',
                            data: { archived_id: archivedId },
                            success: function(response) {
                                if (response == 'success') {
                                    Swal.fire('Restored!', 'The student has been restored.', 'success').then(() => {
                                       location.reload();
                                    });
                                } else {
                                    Swal.fire('Error!', 'Failed to restore the student.', 'error');
                                }
                            }
                        });
                    }
                });
            }
        </script>
</body>
</html>
