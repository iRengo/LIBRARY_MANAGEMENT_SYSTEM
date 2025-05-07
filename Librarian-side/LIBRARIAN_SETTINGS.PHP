<!DOCTYPE html>
<html lang="en">

<head>
    <title>Librarian Catalog </title>
    <link rel="stylesheet" href="LIBRARIAN_SETTINGS.CSS">



</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP' ?>

            

            <!-- Content HERE -->

            <!-- Settings Start -->
            
<div class="Settings_content">
    <div class="top_text">
        <h2>Settings</h2>
        <div class="subtext">
            <h3>Manage Your Account Settings and Preferences</h3>
            <div class="sub_buttons">
                <button id="account-btn" onclick="showContent('account')">Account</button>
                <button id="fines-btn" onclick="showContent('fines')">Fines</button>
            </div>
        </div>
    </div>

    <!-- Content Sections -->

            <!-- Accounts Information Start... -->
<div id="account" class="content content-section">
    <div class="container_profile">
        <!-- Profile Section -->
        <section class="profile-section">
            <h2 class="user_profile">Profile</h2>
            <img src="https://thumbs.dreamstime.com/b/librarian-icon-trendy-flat-vector-white-backg-background-professions-collection-illustration-can-be-use-web-mobile-130325032.jpg" 
     alt="Profile Icon" 
     style="width: 150px; height: auto; border-radius: 15px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease-in-out;">

            <h3 class="user_profile_sub">Set your account details</h3>
            <div class="profile-form">
                <div class="form-group">
                    <label for="username">Librarian ID</label>
                    <input type="text" id="username" placeholder="Enter ID" value="45671" readonly>
                </div>
                <div class="form-group">
                    <label for="user-id">Password</label>
                    <input type="text" id="user-id" placeholder="Enter Password" value="**********" readonly>
                </div>
                <div class="form-group full-width">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="Enter email" value="Librarian@gmail.com" readonly>
                </div>
        </section>



        <!-- Personal Information Section -->
        <section class="personal-info-section">
                <h2>Change Password</h2>
                <div class="personal-info-form">
                    <div class="form-group">
                        <label for="lastname">New Password</label>
                        <input type="text" id="lastname" placeholder="Enter New Password">
                    </div>
                    <div class="form-group">
                        <label for="firstname">Confirm Password</label>
                        <input type="text" id="firstname" placeholder="Confirm Password">
                    </div>
                </div>
            </section>
        </div>
    </div>

            <!-- Accounts Information End... -->


            <!-- Notifications Information Start... -->

<div id="notifications" class="content content-section settings-container" style="display:none;">
    <h2>Notification Preferences</h2>
    <div class="line"></div>
    <br>
    <div class="notification-preferences">
        <div class="notification-toggle">
            <label for="turn-off-notifications">Turn off Notification Temporarily</label>
            <select id="turn-off-notifications">
                <option value="off">Off</option>
                <option value="1-day">1 Day</option>
                <option value="1-week">1 Week</option>
            </select>
        </div>
        <div class="via_notifs">
            <h4>Notify Via</h4>
        </div>
        <div class="notify-options">
            <label class="notify-button">
                <span>
                    <span class="icon email-icon"><ion-icon name="mail-unread" style="font-size:50px;"></ion-icon></span>
                    Email
                </span>
                <span class="radio-container"><input type="radio" name="notify" checked></span>
            </label>
            <label class="notify-button">
                <span>
                    <span class="icon app-icon"><img src="logo.png" alt=""></span>
                    In-app notifications Only
                </span>
                <span class="radio-container"><input type="radio" name="notify"></span>
            </label>
            <label class="notify-button">
                <span>Both</span>
                <span class="radio-container"><input type="radio" name="notify"></span>
            </label>
        </div>

        <div class="actions">
            <button class="edit-button">Edit</button>
            <button class="save-button">Save</button>
        </div>
    </div>
</div>

            <!-- Notifications Information End... -->
                    

            <!-- Fines Information Start... -->

    <div id="fines" class="content content-section" style="display:none;">
        <h3>Fines </h3>
        <table class="fines_table">
            <thead>
                <tr>
                    <th>FINE TYPE</th>
                    <th>CATEGORY</th>
                    <th>FINE AMMOUNT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>Overdue</b></td>
                    <td>Daily Fine</td>
                    <td>₱5 per day</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Maximum Fine</td>
                    <td>₱200 per book</td>
                </tr>
                <tr>
                    <td><b>Lost</b></td>
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
                    <td><b>Damage</b></td>
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
                
                <!-- Add other fines here -->
            </tbody>
            <tfoot>
    <tr>
        <td colspan="3">
            <strong>Notes:</strong> <br>
            <ul>
                <strong>Overdue:</strong> Start after a 3-day grace period<br>
                <strong>Lost Book:</strong> Apply after 30 days of overdue, or if declared lost by the borrower<br>
                <strong>Damaged Book:</strong> Librarian assesses damage severity
            </ul>
        </td>
    </tr>
</tfoot>
        </table>
            <!-- Pagination -->
            <div class="pagination">
    <button class="edit-btn">Edit</button>
    <button class="save-btn">Save</button>
</div>
    </div>

            <!-- Fines Information End... -->
</div>

            <!-- Settings End -->
</div>
        <!-- ========================= Main END ==================== -->
   
<!-- =========== Scripts =========  -->
<script src="LIBRA.js"></script>
    <script src="LIBRARIAN.js"></script>



<!-- ====== ionicons ======= -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>