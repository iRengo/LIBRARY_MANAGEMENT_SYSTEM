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
                        <input type="number" inputmode="numeric" pattern="[0-9]*">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full-width">
                        <label>Email</label>
                        <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                    </div>
                </div>
            </div>

            <div class="settings-box">
                <h3 class="sub-heading">CHANGE PASSWORD</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label>New password</label>
                        <input type="password">
                    </div>
                    <div class="form-group">
                        <label>Confirm password</label>
                        <input type="password">
                    </div>
                </div>

                <div class="button-group">
                    <button class="primary">Change</button>
                    <button class="secondary">Cancel</button>
                </div>
            </div>

            <div class="action-buttons">
                <button class="secondary">Edit</button>
                <button class="primary">Save</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.settings-buttons .tab');
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