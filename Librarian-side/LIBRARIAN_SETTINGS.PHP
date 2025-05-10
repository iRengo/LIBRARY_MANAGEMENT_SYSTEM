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

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Librarian Catalog </title>
    <link rel="stylesheet" href="LIBRARIAN_SETTINGS.CSS">
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

                <div class="form-row">
                    <div class="form-group">
                        <label>Librarian ID</label>
                        <input type="number" inputmode="numeric" pattern="[0-9]*" value="<?php echo htmlspecialchars($librarian['librarian_no']); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" value="<?php echo htmlspecialchars($librarian['password']); ?>" readonly>
                    </div>
                </div>
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" value="<?php echo htmlspecialchars($librarian['first_name']); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" value="<?php echo htmlspecialchars($librarian['last_name']); ?>" readonly>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group full-width">
                            <label>Email</label>
                            <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" readonly value="<?php echo htmlspecialchars($librarian['email']); ?>">
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
                        <button class="primary" type="submit" name="update_password">Save</button>
                        <button class="secondary">Edit</button>
                    </div>
            </div>
            </form>
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
                                <td>Daily Fine</td>
                                <td contenteditable="true">₱5 per day</td>
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
                                <td>Minor Damage Fine</td>
                                <td contenteditable="true">₱100</td>
                            </tr>
                            <tr>
                                <td>Major Damage Fine</td>
                                <td contenteditable="true">₱300</td>
                            </tr>
                            <tr>
                                <td>Replacement Option</td>
                                <td contenteditable="true">Borrower can replace the book instead</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="notes">
                        <strong>Notes</strong>
                        <p><strong>Overdue:</strong> Start after a 3-day grace period</p>
                        <p><strong>Lost Book:</strong> Apply after 30 days of overdue, or if declared lost by the borrower</p>
                        <p><strong>Damage book:</strong> Librarian assesses damage severity</p>
                    </div>
                </div>
                <div class="action-buttons">
                    <button class="secondary back-to-account">Edit</button>
                    <button class="primary" onclick="saveFines()">Save</button>
                </div>
            </div>
        </div>


  
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_password'])) {
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if ($new_password !== $confirm_password) {
                echo " 
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'New password and confirm password do not match.'
            });
        </script>";
                exit; 
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                $update_query = "UPDATE librarian_acc SET password = ? WHERE librarian_no = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("si", $hashed_password, $librarian_no);

                if ($update_stmt->execute()) {
                    echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Password Updated',
                    text: 'Your password has been successfully changed.'
                });
            </script>";
                } else {
                    echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Update Failed',
                    text: 'Something went wrong. Please try again.'
                });
            </script>";
                }
            }
        }
        ?>

        <script>
            document.getElementById("editButton").addEventListener("click", function() {
                document.getElementById("first_name").readOnly = false;
                document.getElementById("last_name").readOnly = false;
            });


            document.addEventListener('DOMContentLoaded', function() {
                const tabs = document.querySelectorAll('.settings-buttons .tab');
                const sections = document.querySelectorAll('.settings-section');

                tabs.forEach(function(tab) {
                    tab.addEventListener('click', function() {
                        // Remove active class from all tabs
                        tabs.forEach(function(t) {
                            t.classList.remove('active');
                        });

                        // Add active class to the clicked tab
                        tab.classList.add('active');

                        // Show the corresponding section
                        sections.forEach(function(section) {
                            section.style.display = (section.getAttribute('data-tab') === tab.getAttribute('data-tab')) ? 'block' : 'none';
                        });
                    });
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