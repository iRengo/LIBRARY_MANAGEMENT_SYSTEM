<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ADMIN_SETTINGS.CSS">
</head>
<body>
    <?PHP INCLUDE 'HEADER-NAVBAR.PHP' ?>
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
                                <tr>
                                    <td>User</td>
                                    <td>Full Access</td>
                                    <td>
                                        <button class="edit">Edit</button>
                                        <button class="clear">Clear</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Librarian</td>
                                    <td>Manage Books, Users, Circulation</td>
                                    <td>
                                        <button class="edit">Edit</button>
                                        <button class="clear">Clear</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="settings-section" data-tab="library-policies" style="display: none;">
                <h1>Library Policies</h1>
                <div class="container">
                    <!-- Left Card -->
                    <div class="card">
                        <div class="section-title">Borrowing Limits</div>
                        <div class="field-group">
                            <label for="max-books">Maximum Number of Books:</label>
                            <input type="number" id="max-books" placeholder="Enter max books" min="1" required>
                        </div>
                        <div class="field-group">
                            <label for="borrow-duration">Borrowing Duration (Days):</label>
                            <input type="number" id="borrow-duration" placeholder="Enter duration in days" min="1" required>
                        </div>

                        <div class="section-title">Overdue Fines</div>
                        <div class="field-group">
                            <label for="fine-per-day">Fine Amount per Day:</label>
                            <input type="number" id="fine-per-day" placeholder="Enter fine amount" min="0" required>
                        </div>
                        <div class="field-group">
                            <label for="grace-period">Grace Period (Days):</label>
                            <input type="number" id="grace-period" placeholder="Enter grace period in days" min="0" required>
                        </div>
                    </div>

                    <!-- Right Card -->
                    <div class="card">
                        <div class="section-title">Renewal Options</div>
                        <div class="field-group">
                            <label for="max-renewals">Maximum Renewals:</label>
                            <input type="number" id="max-renewals" placeholder="Enter max renewals" min="0" required>
                        </div>
                        <div class="field-group">
                            <label for="renewal-duration">Renewal Duration (Days):</label>
                            <input type="number" id="renewal-duration" placeholder="Enter duration in days" min="1" required>
                        </div>

                        <div class="section-title">Reservation Timeframes</div>
                        <div class="field-group">
                            <label for="reservation-duration">Reservation Duration (Days):</label>
                            <input type="number" id="reservation-duration" placeholder="Enter duration in days" min="1" required>
                        </div>
                        <div class="field-group">
                            <label for="reservation-notice">Reservation Notice (Days):</label>
                            <input type="number" id="reservation-notice" placeholder="Enter notice period in days" min="0" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="settings-section" data-tab="catalog-collection" style="display: none;">
                <div class="box-shadow">
                    <h1>Catalog & Collection</h1>

                    <!-- Book Categories Table -->
                    <div class="table-card">
                        <h3>Book Categories</h3>
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Fiction</td>
                                        <td>
                                            <button class="btn edit">Edit</button>
                                            <button class="btn delete">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Non-Fiction</td>
                                        <td>
                                            <button class="btn edit">Edit</button>
                                            <button class="btn delete">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Children's Books</td>
                                        <td>
                                            <button class="btn edit">Edit</button>
                                            <button class="btn delete">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Book Genres Table -->
                    <div class="table-card">
                        <h3>Book Genres</h3>
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Genre</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Fantasy</td>
                                        <td>
                                            <button class="btn edit">Edit</button>
                                            <button class="btn delete">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mystery</td>
                                        <td>
                                            <button class="btn edit">Edit</button>
                                            <button class="btn delete">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Romance</td>
                                        <td>
                                            <button class="btn edit">Edit</button>
                                            <button class="btn delete">Delete</button>
                                        </td>
                                    </tr>
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

                    <!-- Report Scheduling Card -->
                    <div class="card">
                        <h3>Report Scheduling</h3>
                        <div class="form-group">
                            <label for="report-frequency">Report Frequency:</label>
                            <select id="report-frequency">
                                <option>Daily</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="delivery-method">Report Delivery Method:</label>
                            <select id="delivery-method">
                                <option>Email</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
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
    </script>
</body>
</html>