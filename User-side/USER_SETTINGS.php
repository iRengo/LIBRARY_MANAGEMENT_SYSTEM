<?php

session_start();
include '../homepage/db_connect.php';

// Check if the admin session exists
if (!isset($_SESSION['acc_no'])) {
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
    exit();
}

$acc_no = $_SESSION['acc_no'];
$login_time = date("Y-m-d H:i:s");

// Update the last_login column
$stmt = $conn->prepare("UPDATE stud_acc SET last_logged_in = ? WHERE student_no = ?");
$stmt->bind_param("si", $login_time, $acc_no);
$stmt->execute();

// Assuming you've already connected to your database

$query = "SELECT student_no, email, last_name, first_name, contact FROM stud_acc WHERE acc_no = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $acc_no);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $student_no = $row['student_no'];
    $email = $row['email'];
    $last_name = $row['last_name'];
    $first_name = $row['first_name'];
    $contact = $row['contact'];
} else {
    $student_no = $email = $last_name = $first_name = $contact = "Not available";
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["save_password"])) {
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $update_query = "UPDATE stud_acc SET password = ? WHERE acc_no = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("si", $hashed_password, $acc_no);

        if ($stmt->execute()) {
            echo "<script>
                window.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Updated',
                        text: 'Your password has been changed successfully!',
                        confirmButtonColor: '#3085d6'
                    });
                });
            </script>";
        } else {
            echo "<script>
                window.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: 'There was an error updating your password.',
                        confirmButtonColor: '#d33'
                    });
                });
            </script>";
        }
    } else {
        // Just in case JS validation fails
        echo "<script>
            window.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'New password and confirmation do not match.',
                    confirmButtonColor: '#d33'
                });
            });
        </script>";
    }
}

$fines_query = "
    SELECT 
        sf.violation_id,
        b.book_title,
        bb.preferred_date,
        rb.return_date,
        ft.fine_name,
        ft.price,
        sf.proof,
        sf.date_issued,
        sf.status,
        sf.updated_by
    FROM student_fines sf
    JOIN fines_table ft ON sf.fine_id = ft.fine_id
    JOIN tbl_books b ON sf.book_id = b.book_id
    LEFT JOIN borrowed_books bb ON sf.book_id = bb.book_id AND sf.student_no = bb.student_no
    LEFT JOIN returned_books rb ON sf.book_id = rb.book_id AND sf.student_no = rb.student_no
    WHERE sf.student_no = ?
";

$fine_stmt = $conn->prepare($fines_query);
$fine_stmt->bind_param("s", $student_no);  // Use 's' if student_no is string
$fine_stmt->execute();
$fine_result = $fine_stmt->get_result();

$fines_data = [];
while ($fine_row = $fine_result->fetch_assoc()) {
    $fines_data[] = $fine_row;
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel='stylesheet' href="USER_SETTINGS.CSS">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- =============== Navigation ================ -->
    <?php include 'HEADER-NAVBAR.PHP' ?>
    <BR><BR><BR><BR>


    <!-- Main Settings Wrapper -->
    <div class="settings-container">
        <div class="settings-box">

            <!-- Header and Tabs Group -->
            <div class="settings-header-wrapper">
                <div class="settings-header-left">
                    <h2>Settings</h2>
                    <p class="description">Manage Your Account Settings and Preferences</p>
                </div>

                <div class="settings-header-right">
                    <div class="settings-buttons">
                        <button id="account-btn" class="tab active" onclick="showContent('account')">Account</button>
                        <button id="notifications-btn" class="tab" onclick="showContent('notifications')">Notifications</button>
                        <button id="fines-btn" class="tab" onclick="showContent('fines')">Fines</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Account Section -->
        <div id="account" class="content content-section active">
            <h2 class="sub-heading">Profile</h2>
            <p class="description">Your account details</p>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" value="<?= htmlspecialchars($email) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="user-id">Student Number</label>
                    <input type="text" id="user-id" value="<?= htmlspecialchars($student_no) ?>" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="lastname">Lastname</label>
                    <input type="text" id="lastname" value="<?= htmlspecialchars($last_name) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="firstname">Firstname</label>
                    <input type="text" id="firstname" value="<?= htmlspecialchars($first_name) ?>" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group full-width">
                    <label for="contact">Contact</label>
                    <input type="text" id="contact" value="<?= htmlspecialchars($contact) ?>" readonly>
                </div>
            </div>


            <form method="POST" action="" id="password-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" name="new_password" placeholder="Enter new password" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm new password" disabled required>
                    </div>
                </div>

                <div class="form-row">
                    <button type="button" id="edit-password-btn" class="edit-button">Edit</button>
                    <button type="submit" id="save-password-btn" name="save_password" class="save-button" style="display: none;">Save</button>
                </div>
            </form>



        </div>

        <!-- Notifications Section -->
        <div id="notifications" class="content content-section" style="display:none;">
            <h2 class="sub-heading">Notification Preferences</h2>
            <div class="notification-preferences">
                <br>
                <div class="notify-options">
                    <label class="notify-button">
                        <span class="icon email-icon">
                            <ion-icon name="mail-unread" style="font-size:20px;"></ion-icon>
                        </span>
                        Email
                        <input type="radio" name="notify" checked>
                    </label>

                    <label class="notify-button">
                        <span class="icon app-icon">
                            <img src="logo.png" alt="App Icon" style="width: 16px;" />
                        </span>
                        In-app notifications Only
                        <input type="radio" name="notify">
                    </label>

                    <label class="notify-button">
                        Both
                        <input type="radio" name="notify">
                    </label>
                </div>

                <br>
                <div class="actions">
                    <button class="save-button">Save Changes</button>
                    <button class="edit-button">Edit</button>
                </div>
            </div>
        </div>

        <!-- Fines Section -->
        <div id="fines" class="content content-section" style="display:none;">
            <h2 class="sub-heading">Fines Information</h2>
            <table class="fines_table">
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Borrow Date</th>
                        <th>Remark</th>
                        <th>Fine Amount</th>
                        <th>Proof</th>
                        <th>Date Issued</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($fines_data)): ?>
                        <tr>
                            <td colspan="8">No fines found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($fines_data as $fine): ?>
                            <tr>
                                <td><?= htmlspecialchars($fine['book_title']) ?></td>
                                <td><?= htmlspecialchars(date("F d, Y", strtotime($fine['preferred_date']))) ?></td>
                                <td><?= htmlspecialchars($fine['fine_name']) ?></td>
                                <td>$<?= number_format($fine['price'], 2) ?></td>
                                <td>
                                    <?php if (!empty($fine['proof'])): ?>
                                        <button class="view-proof-btn" data-img-src="../public/proofs/<?= htmlspecialchars($fine['proof']) ?>">
                                            View
                                        </button>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>



                                <td><?= htmlspecialchars(date("F d, Y", strtotime($fine['date_issued']))) ?></td>
                                <?php
                                $status = strtolower($fine['status']);
                                $class = '';
                                if ($status === 'paid') {
                                    $class = 'status-paid';
                                } else if ($status === 'unpaid' || $status === 'pending' || $status === 'due') {
                                    $class = 'status-unpaid';
                                }
                                ?>
                                <td class="<?= $class ?>">
                                    <?= htmlspecialchars(ucfirst($status)) ?>
                                </td>


                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>

    </div>


    <script>
        function showContent(sectionId) {

            const tabs = document.querySelectorAll('.settings-buttons .tab');
            const contents = document.querySelectorAll('.content-section');


            contents.forEach(content => {
                content.style.display = 'none';
                content.classList.remove('active');
            });


            tabs.forEach(tab => tab.classList.remove('active'));


            const activeContent = document.getElementById(sectionId);
            if (activeContent) {
                activeContent.style.display = 'block';
                activeContent.classList.add('active');
            }


            const activeTab = document.getElementById(sectionId + '-btn');
            if (activeTab) {
                activeTab.classList.add('active');
            }
        }


        window.onload = () => {
            showContent('account');
        };
        // Handle "Edit" button click
        document.getElementById("edit-password-btn").addEventListener("click", function() {
            document.getElementById("new-password").disabled = false;
            document.getElementById("confirm-password").disabled = false;
            document.getElementById("save-password-btn").style.display = "inline-block";
            this.style.display = "none";
        });

        // Handle form submission and validate passwords
        document.getElementById("password-form").addEventListener("submit", function(e) {
            const pw1 = document.getElementById("new-password").value;
            const pw2 = document.getElementById("confirm-password").value;

            if (pw1 !== pw2) {
                e.preventDefault(); // stop the form from submitting
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'New password and confirm password do not match!',
                    confirmButtonColor: '#d33'
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const proofButtons = document.querySelectorAll('.view-proof-btn');

            proofButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const imgSrc = this.getAttribute('data-img-src');

                    Swal.fire({
                        title: 'Proof of Fine',
                        imageUrl: imgSrc,
                        imageAlt: 'Proof image',
                        imageWidth: 500,
                        imageHeight: 'auto',
                        confirmButtonText: 'Close'
                    });
                });
            });
        });
    </script>


</body>

</html>