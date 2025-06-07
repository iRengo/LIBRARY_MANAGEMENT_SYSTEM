<?php
include '../Homepage/db_connect.php';
session_start();

$query = "SELECT * FROM lms_settings";
$result = $conn->query($query);

$max_books = '';
$borrow_duration = '';
$fine_per_day = '';

if ($result) {
    while ($row = $result->fetch_assoc()) {
        if ($row['setting_key'] == 'max_books_per_user') {
            $max_books = $row['setting_value'];
        } elseif ($row['setting_key'] == 'borrowing_period_days') {
            $borrow_duration = $row['setting_value'];
        } elseif ($row['setting_key'] == 'overdue_fine') {
            $fine_per_day = $row['setting_value'];
        }
    }
}


$settings = [
    4 => '0',
    5 => '0'
];

$sql = "SELECT setting_id, setting_value FROM lms_settings WHERE setting_id IN (4, 5)";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $settings[$row['setting_id']] = $row['setting_value'];
    }
} else {
    error_log("Failed to fetch settings: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Library Settings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ADMIN_SETTINGS.CSS">
    <style>

    </style>
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>
    <div class="container">
        <div class="library-settings">
            <h2>Library settings</h2>
            <ul>
                <li class="active" data-tab="user-management">User management</li>
                <li data-tab="library-policies">Library policies</li>
                <li data-tab="catalog-collection">Catalog & collection</li>
                <li data-tab="report-analytics">Report & analytics</li>
            </ul>
        </div>

        <main class="main-content">
            <form id="settings-form" method="post" action="admin_save_settings.php">
                <div class="settings-section" data-tab="user-management" style="display: block;">
                    <div class="box-shadow">
                        <h1>User management</h1>
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Role</th>
                                        <th>Permissions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-setting-id="4">
                                        <td>Librarian</td>
                                        <td>Add Book</td>
                                        <td>
                                            <select class="setting-toggle" name="setting_4">
                                                <option value="1" <?php if ($settings[4] === '1') echo 'selected'; ?>>Enabled</option>
                                                <option value="0" <?php if ($settings[4] === '0') echo 'selected'; ?>>Disabled</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr data-setting-id="5">
                                        <td>Librarian</td>
                                        <td>Edit Book</td>
                                        <td>
                                            <select class="setting-toggle" name="setting_5">
                                                <option value="1" <?php if ($settings[5] === '1') echo 'selected'; ?>>Enabled</option>
                                                <option value="0" <?php if ($settings[5] === '0') echo 'selected'; ?>>Disabled</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top: 20px;">
                            <button type="submit" name="save_settings" class="save-btn">Save</button>
                        </div>
                    </div>
                </div>
            </form>


            <div class="settings-section" data-tab="library-policies" style="display: none;">
                <h1>Library Policies</h1>
                <form method="POST" action="admin_save_settings.php">
                    <div class="settings-container">
                        <div class="card policy-card">
                            <div class="section-title">Borrowing Limits</div>
                            <div class="field-group">
                                <label for="max-books">Maximum Number of Books:</label>
                                <input type="number" id="max-books" name="max_books" min="1" value="<?php echo htmlspecialchars($max_books); ?>" required disabled>
                            </div>
                            <div class="field-group">
                                <label for="borrow-duration">Borrowing Duration (Days):</label>
                                <input type="number" id="borrow-duration" name="borrow_duration" min="1" value="<?php echo htmlspecialchars($borrow_duration); ?>" required disabled>
                            </div>

                            <div class="section-title">Overdue Fines</div>
                            <div class="field-group">
                                <label for="fine-per-day">Fine Amount per Day:</label>
                                <input type="number" id="fine-per-day" name="fine_per_day" min="0" value="<?php echo htmlspecialchars($fine_per_day); ?>" required disabled>
                            </div>

                            <div class="btn-group">
                                <button type="button" id="edit-btn">Edit</button>
                                <button type="submit" id="save-btn" style="display: none;">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="settings-section" data-tab="catalog-collection" style="display: none;">
                <div class="box-shadow">
                    <h1>Catalog & Collection</h1>
                    <div class="table-card">
                        <h3>Book Categories</h3>
                        <div class="table-wrapper">
                            <table id="category-table">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT DISTINCT book_category FROM tbl_books WHERE book_category IS NOT NULL AND book_category != ''";
                                    $result = $conn->query($query);
                                    while ($row = $result->fetch_assoc()) {
                                        $category = htmlspecialchars($row['book_category']);
                                        echo "<tr>
                                    <td><input type='text' value='{$category}' disabled></td>
                                    <td>
                                        <button class='btn edit' onclick='enableEdit(this)'>Edit</button>
                                        <button class='btn save' onclick='saveCategory(this, \"$category\")' style='display:none;'>Save</button>
                                        <button class='btn delete' onclick='deleteCategory(\"$category\")'>Delete</button>
                                    </td>
                                </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="settings-section" data-tab="report-analytics" style="display: none;">
                <div class="box-shadow">
                    <h1>Report & Analytics</h1>
                    <p>View reports and analytics here.</p>

                    <!-- Report Formats Card -->
                    <div class="card">
                        <h3>Report Formats</h3>
                        <div class="form-group">
                            <label for="report-format">Select Report Formats:</label>
                            <select id="report-format">
                                <option>PDF</option>
                            </select>
                        </div>
                    </div>

                   
                </div>
            </div>
        </main>
    </div>

    <script>
        function enableEdit(btn) {
            const row = btn.closest('tr');
            row.querySelector('input').disabled = false;
            btn.style.display = 'none';
            row.querySelector('.save').style.display = 'inline-block';
        }

        function saveCategory(btn, oldCategory) {
            const row = btn.closest('tr');
            const input = row.querySelector('input');
            const newCategory = input.value;

            fetch('admin_save_settings.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `action=update_category&old_category=${encodeURIComponent(oldCategory)}&new_category=${encodeURIComponent(newCategory)}`
                })
                .then(res => res.text())
                .then(response => {
                    Swal.fire('Updated!', 'Category successfully updated.', 'success');
                    input.disabled = true;
                    btn.style.display = 'none';
                    row.querySelector('.edit').style.display = 'inline-block';
                });
        }

        function deleteCategory(category) {
            Swal.fire({
                title: 'Are you sure?',
                text: `This will DELETE the category "${category}" AND ALL books under it permanently!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch('admin_save_settings.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `action=delete_category&category=${encodeURIComponent(category)}`
                        })
                        .then(res => res.text())
                        .then(response => {
                            Swal.fire('Deleted!', `Category "${category}" and all related books have been deleted.`, 'success')
                                .then(() => location.reload());
                        });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.library-settings li');
            const sections = document.querySelectorAll('.settings-section');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    sections.forEach(section => {
                        section.style.display = section.dataset.tab === tab.dataset.tab ? 'block' : 'none';
                    });
                });
            });
        });

        document.getElementById('edit-btn').addEventListener('click', function() {
            document.getElementById('max-books').disabled = false;
            document.getElementById('borrow-duration').disabled = false;
            document.getElementById('fine-per-day').disabled = false;

            document.getElementById('edit-btn').style.display = 'none';
            document.getElementById('save-btn').style.display = 'inline-block';
        });
    </script>

    <?php if (isset($_SESSION['success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?php echo $_SESSION["success"]; ?>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        </script>
    <?php unset($_SESSION['success']);
    endif; ?>
</body>

</html>