<?php
session_start();
include '../homepage/db_connect.php';

$librarian_no = $_SESSION['librarian_no'] ?? null;

$librarian = [
    'librarian_no' => '',
    'email' => '',
    'first_name' => '',
    'last_name' => '',
    'password' => ''
];

if ($librarian_no) {
    $query = "SELECT librarian_no, email,first_name, last_name, password FROM librarian_acc WHERE librarian_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $librarian_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $librarian = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_profile'])) {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Update the librarian's first and last name
    $update_query = "UPDATE librarian_acc SET first_name = ?, last_name = ? WHERE librarian_no = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssi", $first_name, $last_name, $librarian_no);

    $isUpdated = $update_stmt->execute();

    // If password is provided and matches confirm password, update it
    if (!empty($new_password) && $new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $password_query = "UPDATE librarian_acc SET password = ? WHERE librarian_no = ?";
        $password_stmt = $conn->prepare($password_query);
        $password_stmt->bind_param("si", $hashed_password, $librarian_no);
        $isUpdated = $isUpdated && $password_stmt->execute();
    } elseif (!empty($new_password)) {
        echo " <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'New password and confirm password do not match.'
            });
        </script>";
    }

    if ($isUpdated) {
        echo " <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated',
                text: 'Your profile has been successfully updated.'
            });
        </script>";
       header("Location: LIBRARIAN_SETTINGS.php?status=success");
        exit;
    } else {
        echo " <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Update Failed',
                text: 'Something went wrong. Please try again.'
            });
        </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Librarian Catalog</title>
    <link rel="stylesheet" href="LIBRARIAN_SETTINGS.CSS">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="account-settings">
    <?php include 'HEADER-NAVBAR.PHP' ?>

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

                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Librarian ID</label>
                            <input type="number" inputmode="numeric" value="<?php echo htmlspecialchars($librarian['librarian_no']); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" value="<?php echo htmlspecialchars($librarian['password']); ?>" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($librarian['first_name']); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($librarian['last_name']); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label>Email</label>
                            <input type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="<?php echo htmlspecialchars($librarian['email']); ?>" readonly>
                        </div>
                    </div>

                    <h3 class="sub-heading">CHANGE PASSWORD</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>New password</label>
                            <input type="password" name="new_password">
                        </div>
                        <div class="form-group">
                            <label>Confirm password</label>
                            <input type="password" name="confirm_password">
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
                <table class="fines-table">
                    <thead>
                        <tr>
                            <th>FINE TYPE</th>
                            <th>CATEGORY</th>
                            <th>FINE AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="2">Overdue</td>
                            
                        </tr>
                        <tr>
                            <td>Maximum Fine</td>
                            <td contenteditable="true">₱200 per book</td>
                        </tr>
                        <tr>
                            <td rowspan="3">Lost</td>
                            <td>Fixed Fine</td>
                            <td contenteditable="true">₱500 per lost book</td>
                        </tr>
                        <tr>
                            <td>Book Value Percentage</td>
                            <td contenteditable="true">100% of book’s value</td>
                        </tr>
                        <tr>
                            <td>Replacement Option</td>
                            <td contenteditable="true">Borrower can replace the book instead</td>
                        </tr>
                        <tr>
                            <td rowspan="3">Damage</td>
                            <td>Damaged Low</td>
                            <td contenteditable="true">₱100</td>
                        </tr>
                        <tr>
                            <td>Damaged Medium</td>
                            <td contenteditable="true">₱200</td>
                        </tr>
                        <tr>
                            <td>Damaged High</td>
                            <td contenteditable="true">₱300</td>
                        </tr>
                    </tbody>
                </table>
                <div class="notes">
                    <strong>Notes</strong>
      
                    <p><strong>Damage book:</strong> Librarian assesses damage severity</p>
                </div>
            </div>
            <!-- 
            <div class="action-buttons">
                <button class="secondary back-to-account">Edit</button>
                <button class="primary" onclick="saveFines()">Save</button>
            </div> -->
        </div>
    </div>

<?php

?>

<?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Profile Updated',
        text: 'Your profile has been successfully updated.'
    });
</script>
<?php endif; ?>

<script>

document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.settings-buttons .tab');
    const sections = document.querySelectorAll('.settings-section');

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            sections.forEach(section => {
                section.style.display = (section.getAttribute('data-tab') === tab.getAttribute('data-tab')) ? 'block' : 'none';
            });
        });
    });
    document.getElementById("editButton").addEventListener("click", function () {
        document.getElementById("first_name").readOnly = false;
        document.getElementById("last_name").readOnly = false;
        document.getElementById("email").readOnly = false;
    });

});

function saveFines() {
    const finesTable = document.querySelector('.fines-table tbody');
    const fines = [];
    finesTable.querySelectorAll('tr').forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length === 3) {
            fines.push({
                type: cells[0].innerText.trim(),
                category: cells[1].innerText.trim(),
                amount: cells[2].innerText.trim()
            });
        }
    });
    console.log('Fines updated:', fines);
    alert('Fines have been updated successfully!');
    
}
</script>
</body>
</html>
