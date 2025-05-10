<!DOCTYPE html>
<html lang="en">

<head>
    <title>Librarian Catalog</title>
    <link rel="stylesheet" href="LIBRARIAN_SETTINGS_FINE.CSS">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Add responsive meta tag -->
</head>

<body class="fines-settings">
    <?php include 'HEADER-NAVBAR.PHP'; ?>
    
    <!-- Main Content -->
    <div class="settings-container">
        <div class="settings-box">
            <!-- Header Section -->
            <div class="settings-header">
                <h2>SETTINGS</h2>
                <div class="settings-buttons">
                    <button class="tab" data-tab="account" onclick="window.location.href='LIBRARIAN_SETTINGS.PHP'" aria-label="Go to Account Settings">Account</button>
                    <button class="tab active" data-tab="fines" onclick="window.location.href='LIBRARIAN_SETTINGS_FINE.PHP'" aria-label="Go to Fines Settings">Fines</button>
                </div>
            </div>
            
            <p class="description">Manage your account settings and preferences</p><br>

            <!-- Fines Section -->
            <h3 style="color: #234078;">Fines</h3>
            <p class="subtitle">Set amount on fines</p>

            <!-- Fines Table -->
            <table>
                <thead>
                    <tr>
                        <th scope="col">FINE TYPE</th>
                        <th scope="col">CATEGORY</th>
                        <th scope="col">FINE AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Overdue</strong></td>
                        <td>Daily Fine</td>
                        <td>₱5 per day</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Maximum Fine</td>
                        <td>₱200 per book</td>
                    </tr>
                    <tr>
                        <td><strong>Lost</strong></td>
                        <td>Fixed Fine</td>
                        <td>₱500 per lost book</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Book Value Percentage</td>
                        <td>100% of book’s value</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Replacement Option</td>
                        <td>Borrower can replace the book instead</td>
                    </tr>
                    <tr>
                        <td><strong>Damage</strong></td>
                        <td>Minor Damage Fine</td>
                        <td>₱100</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Major Damage Fine</td>
                        <td>₱300</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Replacement Option</td>
                        <td>Borrower can replace the book instead</td>
                    </tr>
                </tbody>
            </table>

            <!-- Notes Section -->
            <div class="notes">
                <p><b>Notes:</b></p>
                <p><b>Overdue:</b> Start after a 3-day grace period</p>
                <p><b>Lost Book:</b> Apply after 30 days of overdue, or if declared lost by the borrower</p>
                <p><b>Damage book:</b> Librarian assesses damage severity</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="secondary" aria-label="Edit Fines">Edit</button>
            <button class="primary" aria-label="Save Fines">Save</button>
        </div>
    </div>
</body>

</html>