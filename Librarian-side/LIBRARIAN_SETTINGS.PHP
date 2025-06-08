<?php
session_start();
include '../homepage/db_connect.php';

$librarian_no = $_SESSION['librarian_no'] ?? null;

if (!$librarian_no) {
    header("Location: login.php");
    exit;
}



// Fetch librarian details
$query = "SELECT librarian_no, email, first_name, last_name, password FROM librarian_acc WHERE librarian_no = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $librarian_no);
$stmt->execute();
$result = $stmt->get_result();
$librarian = $result->fetch_assoc();
$current_password_hash = $librarian['password'] ?? '';

?>

<?php if (isset($_GET['status'])): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.onload = function() {
        <?php if ($_GET['status'] === 'success'): ?>
            Swal.fire('Success', 'Your profile has been updated.', 'success');
        <?php elseif ($_GET['status'] === 'failed'): ?>
            Swal.fire('Error', 'There was a problem updating your profile.', 'error');
        <?php elseif ($_GET['status'] === 'incorrect_password'): ?>
            Swal.fire('Incorrect Password', 'Your current password is incorrect.', 'error');
        <?php elseif ($_GET['status'] === 'password_mismatch'): ?>
            Swal.fire('Password Mismatch', 'New passwords do not match.', 'error');
        <?php elseif ($_GET['status'] === 'weak_password'): ?>
            Swal.fire('Weak Password', 'Password must be at least 8 characters with a number and special character.', 'error');
        <?php endif; ?>
    };
</script>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Librarian Settings</title>
    <link rel="stylesheet" href="LIBRARIAN_SETTINGS.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="account-settings">
<?php include 'HEADER-NAVBAR.php'; ?>

<div class="settings-container">
    <div class="settings-box">
        <div class="settings-header">
            <h2>SETTINGS</h2>
            <div class="settings-buttons">
                <button class="tab active" data-tab="account">Account</button>
                <button class="tab" data-tab="fines">Fines</button>
            </div>
        </div>
    </div>

    <!-- Account Section -->
    <div class="settings-section" data-tab="account" style="display: block;">
        <div class="settings-box">
            <p class="description">Manage your account settings and preferences</p>

            <h3 class="sub-heading">Profile</h3>
            <p class="description">Set your account details</p>

            <form method="POST" action="LIBRARIAN_SETTINGS_UPDATE.php">
                <div class="form-row">
                    <div class="form-group">
                        <label>Librarian ID</label>
                        <input type="number" value="<?= htmlspecialchars($librarian['librarian_no']) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" value="********" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($librarian['first_name']) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($librarian['last_name']) ?>" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full-width">
                        <label>Email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($librarian['email']) ?>" readonly>
                    </div>
                </div>

                <h3 class="sub-heading">CHANGE PASSWORD</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" placeholder="Leave blank if not changing">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group full-width">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_password" placeholder="Leave blank if not changing">
                    </div>
                </div>

                <div class="button-group">
                    <button class="primary" type="submit" name="update_profile">Save Changes</button>
                    <button class="secondary" type="button" id="editButton">Edit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Fines Section -->
    <div class="settings-section" data-tab="fines" style="display: none;">
        <div class="settings-box">
            <h3 class="sub-heading">Fines</h3>
            <p class="description">Set amount on fines</p>
            <!-- Table of fines here -->
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.settings-buttons .tab');
        const sections = document.querySelectorAll('.settings-section');

        tabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                sections.forEach(section => {
                    section.style.display = (section.getAttribute('data-tab') === tab.getAttribute('data-tab')) ? 'block' : 'none';
                });
            });
        });

        document.getElementById("editButton").addEventListener("click", function() {
            document.getElementById("first_name").readOnly = false;
            document.getElementById("last_name").readOnly = false;
            document.getElementById("email").readOnly = false;
        });
    });
</script>
</body>
</html>
