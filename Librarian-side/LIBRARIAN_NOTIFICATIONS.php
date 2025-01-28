<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <title> Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="LIBRARIAN_NOTIFICATIONS.css">

  

    <!-- ======= Scripts ====== -->


    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <div class="admin-gradient">
                        <a href="#">
                            <span class="icon">
                                <ion-icon name="person-circle" class="admin-icon"></ion-icon>
                            </span>
                            <span class="title1">LIBRARIAN</span>
                        </a>
                    </div>
                </li>

                <li>
                    <a href="">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>

                        </span>
                        <span class="title">Catalog</span>
                    </a>
                </li>

                <li>
                    <a href="">
                        <span class="icon">
                            <i class='bx bx-history' style="font-size:35px;"></i>
                        </span>
                        <span class="title">History</span>
                    </a>
                </li>

                <li>
                    <a href="">
                        <span class="icon">
                            <ion-icon name="person-add-outline" style="font-size: 30px;"></ion-icon>
                        </span>
                        <span class="title">Reservations</span>
                    </a>
                </li>

                <li>
                    <a href="">
                        <span class="icon">
                            <ion-icon name="notifications-outline"></ion-icon>
                        </span>
                        <span class="title">Notifications</span>
                    </a>
                </li>

                <li>
                    <a href="">
                        <span class="icon">
                            <ion-icon name="file-tray-stacked-outline"></ion-icon>
                        </span>
                        <span class="title">User Management</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="icon">
                            <ion-icon name="trending-up-outline"></ion-icon>
                        </span>
                        <span class="title">Reports</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="icon">
                            <ion-icon name="cog-outline"></ion-icon>
                        </span>
                        <span class="title">Settings</span>
                    </a>
                </li>
                <div class="time-container" style="width: 150%;">
                    <p style="font-size: 10px; color:white;">
                        <?php echo date("l, F j, Y h:i:s"); // Full date and time format 
                        ?>
                    </p>
                </div>
            </ul>

        </div>


        <!-- ========================= Main ==================== -->
        <div class="main">
    <div class="topbar">
        <div class="toggle">
            <ion-icon name="menu-outline"></ion-icon>
        </div>
        <div class="logo">
            <img src="../logosample1.png" style="height: 60px; width:60px; padding:4px;">
        </div>
        <div style="float:left; margin-right:75%; display: flex; align-items: baseline;">
            <p style="font-family: viga; margin: 0; padding-right:2px;">LIBRA</p>
            <p style="font-family: zilla slab highlight; letter-spacing: 2px; margin: 0;">SPHERE</p>
        </div>
        <div class="logo" title="LOGOUT YOUR ACCOUNT" style="margin-right: 1%; display: flex; align-items: center;">
            <a href="" id="logoutIcon" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                <p style="margin: 0; font-size: 18px; margin-right: 8px;">LOGOUT</p>
                <i class='bx bx-log-in-circle' style="font-size:35px; color:#da1b1b;"></i>
            </a>
        </div>
    </div>

<!-- Content Section -->
<div class="content-container">
    <div class="button-container">
        <a href="#borrowed-content" class="action-button">BORROWED</a>
        <a href="#declined-borrow-content" class="action-button">DECLINED BORROWED</a>
        <a href="#returned-books-content" class="action-button">RETURNED BOOKS</a>
    </div>

    <!-- Borrowed Content Box -->
    <div id="borrowed-content" class="content-box"> 
        <h2>BORROWED BOOKS</h2>
        <div style="margin-top: 20px;">
        <div class="borrowed-content-header">
            <div>User ID</div>
            <div>Username</div>
            <div>Book Title</div>
            <div>Borrow Date</div>
            <div>Due Date</div>
            <div>Status</div>
        </div>
        <div class="borrowed-content">
            <div class="borrowed-content-row">
                <div>100101</div>
                <div>Carlos Garcia</div>
                <div>The Return</div>
                <div>2025-01-10</div>
                <div>2025-01-24</div>
                <div>Overdue</div>
            </div>
            <div class="borrowed-content-row">
                <div>100102</div>
                <div>Maria Santos</div>
                <div>The Return</div>
                <div>2025-01-15</div>
                <div>2025-01-30</div>
                <div>Ongoing</div>
            </div>
            <div class="borrowed-content-row">
                <div>100103</div>
                <div>Jose Fernandez</div>
                <div>The Return</div>
                <div>2025-01-18</div>
                <div>2025-02-01</div>
                <div>Ongoing</div>
            </div>
            <div class="borrowed-content-row">
                <div>100104</div>
                <div>Ana Reyes</div>
                <div>The Return</div>
                <div>2025-01-05</div>
                <div>2025-01-20</div>
                <div>Ongoing</div>
            </div>
            <div class="borrowed-content-row">
                <div>100105</div>
                <div>Michael Cruz</div>
                <div>The Return</div>
                <div>2025-01-12</div>
                <div>2025-01-26</div>
                <div>Pending</div>
            </div>
            <div class="borrowed-content-row">
                <div>100106</div>
                <div>Olivia Delgado</div>
                <div>The Return</div>
                <div>2025-01-20</div>
                <div>2025-02-03</div>
                <div>Ongoing</div>
            </div>
            <div class="borrowed-content-row">
                <div>100107</div>
                <div>James Rivera</div>
                <div>The Return</div>
                <div>2025-01-25</div>
                <div>2025-02-08</div>
                <div>Ongoing</div>
            </div>
            <div class="borrowed-content-row">
                <div>100108</div>
                <div>Emma Mendoza</div>
                <div>The Return</div>
                <div>2025-01-13</div>
                <div>2025-01-27</div>
                <div>Pending</div>
            </div>
            <div class="borrowed-content-row">
                <div>100109</div>
                <div>Lucas Bautista</div>
                <div>The Return</div>
                <div>2025-01-22</div>
                <div>2025-02-05</div>
                <div>Overdue</div>
            </div>
            <div class="borrowed-content-row">
                <div>100110</div>
                <div>Isabella Morales</div>
                <div>The Return</div>
                <div>2025-01-28</div>
                <div>2025-02-11</div>
                <div>Overdue</div>
            </div>
        </div>
        </div>
    </div>

        <!-- Declined Borrowed Content Box -->
    <div id="declined-borrow-content" class="content-box">
        <h2>DECLINED BORROWED BOOKS</h2>
        <div style="margin-top: 20px;">
        <div class="borrowed-content-header">
            <div>User ID</div>
            <div>Username</div>
            <div>Book Title</div>
            <div>Request Date</div>
            <div>Reason</div>
        </div>
        <div class="borrowed-content">
            <div class="borrowed-content-row">
                <div>100201</div>
                <div>Maria Lopez</div>
                <div>The Return</div>
                <div>2025-01-12</div>
                <div>User Cancellation</div>
            </div>
            <div class="borrowed-content-row">
                <div>100202</div>
                <div>Antonio Garcia</div>
                <div>The Return</div>
                <div>2025-01-15</div>
                <div>Librarian Cancellation</div>
            </div>
            <div class="borrowed-content-row">
                <div>100203</div>
                <div>Rosa Perez</div>
                <div>The Return</div>
                <div>2025-01-17</div>
                <div>User Cancellation</div>
            </div>
            <div class="borrowed-content-row">
                <div>100204</div>
                <div>Carlos Torres</div>
                <div>The Return</div>
                <div>2025-01-20</div>
                <div>Librarian Cancellation</div>
            </div>
            <div class="borrowed-content-row">
                <div>100205</div>
                <div>Fiona Morales</div>
                <div>The Return</div>
                <div>2025-01-18</div>
                <div>User Cancellation</div>
            </div>
            <div class="borrowed-content-row">
                <div>100206</div>
                <div>Andres Navarro</div>
                <div>The Return</div>
                <div>2025-01-19</div>
                <div>Librarian Cancellation</div>
            </div>
            <div class="borrowed-content-row">
                <div>100207</div>
                <div>Lucia Ramos</div>
                <div>The Return</div>
                <div>2025-01-22</div>
                <div>User Cancellation</div>
            </div>
            <div class="borrowed-content-row">
                <div>100208</div>
                <div>Hector Morales</div>
                <div>The Return</div>
                <div>2025-01-23</div>
                <div>Librarian Cancellation</div>
            </div>
            <div class="borrowed-content-row">
                <div>100209</div>
                <div>Beatriz Santos</div>
                <div>The Return</div>
                <div>2025-01-24</div>
                <div>User Cancellation</div>
            </div>
            <div class="borrowed-content-row">
                <div>100210</div>
                <div>Samuel Cruz</div>
                <div>The Return</div>
                <div>2025-01-26</div>
                <div>Librarian Cancellation</div>
            </div>
        </div>
        </div>
    </div>


<!-- Returned Books Content Box -->
<div id="returned-books-content" class="content-box">
    <h2>RETURNED BOOKS</h2>
    <div style="margin-top: 20px;">
        <div class="borrowed-content-header">
            <div>User ID</div>
            <div>Username</div>
            <div>Book Title</div>
            <div>Returned Date</div>
            <div>Remarks</div>
        </div>
        <div class="borrowed-content">
            <!-- Row 1 -->
            <div class="borrowed-content-row">
                <div>100301</div>
                <div>Sarah Santos</div>
                <div>The Return</div>
                <div>2025-01-25</div>
                <div class="remarks">
                    <button class="remark-button good" onclick="updateRemark(this, 'GOOD')">GOOD</button>
                    <button class="remark-button damaged" onclick="updateRemark(this, 'DAMAGE')">DAMAGE</button>
                    <button class="remark-button lost" onclick="updateRemark(this, 'LOST')">LOST</button>
                    <input type="button" value="UPDATE" class="update-button" onclick="enableRemarkButtons(this)" />
                    <span class="selected-remark"></span>
                </div>
            </div>
            <!-- Row 2 -->
            <div class="borrowed-content-row">
                <div>100302</div>
                <div>John Doe</div>
                <div>The Awakening</div>
                <div>2025-01-22</div>
                <div class="remarks">
                    <button class="remark-button good" onclick="updateRemark(this, 'GOOD')">GOOD</button>
                    <button class="remark-button damaged" onclick="updateRemark(this, 'DAMAGE')">DAMAGE</button>
                    <button class="remark-button lost" onclick="updateRemark(this, 'LOST')">LOST</button>
                    <input type="button" value="UPDATE" class="update-button" onclick="enableRemarkButtons(this)" />
                    <span class="selected-remark"></span>
                </div>
            </div>
            <!-- Row 3 -->
            <div class="borrowed-content-row">
                <div>100303</div>
                <div>Emily Clark</div>
                <div>The Storm</div>
                <div>2025-01-20</div>
                <div class="remarks">
                    <button class="remark-button good" onclick="updateRemark(this, 'GOOD')">GOOD</button>
                    <button class="remark-button damaged" onclick="updateRemark(this, 'DAMAGE')">DAMAGE</button>
                    <button class="remark-button lost" onclick="updateRemark(this, 'LOST')">LOST</button>
                    <input type="button" value="UPDATE" class="update-button" onclick="enableRemarkButtons(this)" />
                    <span class="selected-remark"></span>
                </div>
            </div>
            <!-- Row 4 -->
            <div class="borrowed-content-row">
                <div>100304</div>
                <div>Michael Brown</div>
                <div>Beyond the Horizon</div>
                <div>2025-01-18</div>
                <div class="remarks">
                    <button class="remark-button good" onclick="updateRemark(this, 'GOOD')">GOOD</button>
                    <button class="remark-button damaged" onclick="updateRemark(this, 'DAMAGE')">DAMAGE</button>
                    <button class="remark-button lost" onclick="updateRemark(this, 'LOST')">LOST</button>
                    <input type="button" value="UPDATE" class="update-button" onclick="enableRemarkButtons(this)" />
                    <span class="selected-remark"></span>
                </div>
            </div>
            <!-- Row 5 -->
            <div class="borrowed-content-row">
                <div>100305</div>
                <div>Olivia Smith</div>
                <div>The Lighthouse</div>
                <div>2025-01-15</div>
                <div class="remarks">
                    <button class="remark-button good" onclick="updateRemark(this, 'GOOD')">GOOD</button>
                    <button class="remark-button damaged" onclick="updateRemark(this, 'DAMAGE')">DAMAGE</button>
                    <button class="remark-button lost" onclick="updateRemark(this, 'LOST')">LOST</button>
                    <input type="button" value="UPDATE" class="update-button" onclick="enableRemarkButtons(this)" />
                    <span class="selected-remark"></span>
                </div>
            </div>
            <!-- Row 6 -->
            <div class="borrowed-content-row">
                <div>100306</div>
                <div>Ava Johnson</div>
                <div>Silent Night</div>
                <div>2025-01-10</div>
                <div class="remarks">
                    <button class="remark-button good" onclick="updateRemark(this, 'GOOD')">GOOD</button>
                    <button class="remark-button damaged" onclick="updateRemark(this, 'DAMAGE')">DAMAGE</button>
                    <button class="remark-button lost" onclick="updateRemark(this, 'LOST')">LOST</button>
                    <input type="button" value="UPDATE" class="update-button" onclick="enableRemarkButtons(this)" />
                    <span class="selected-remark"></span>
                </div>
            </div>
            <!-- Row 7 -->
            <div class="borrowed-content-row">
                <div>100307</div>
                <div>James Lee</div>
                <div>The Hunter</div>
                <div>2025-01-05</div>
                <div class="remarks">
                    <button class="remark-button good" onclick="updateRemark(this, 'GOOD')">GOOD</button>
                    <button class="remark-button damaged" onclick="updateRemark(this, 'DAMAGE')">DAMAGE</button>
                    <button class="remark-button lost" onclick="updateRemark(this, 'LOST')">LOST</button>
                    <input type="button" value="UPDATE" class="update-button" onclick="enableRemarkButtons(this)" />
                    <span class="selected-remark"></span>
                </div>
            </div>
            <!-- Row 8 -->
            <div class="borrowed-content-row">
                <div>100308</div>
                <div>Charlotte White</div>
                <div>The River</div>
                <div>2025-01-02</div>
                <div class="remarks">
                    <button class="remark-button good" onclick="updateRemark(this, 'GOOD')">GOOD</button>
                    <button class="remark-button damaged" onclick="updateRemark(this, 'DAMAGE')">DAMAGE</button>
                    <button class="remark-button lost" onclick="updateRemark(this, 'LOST')">LOST</button>
                    <input type="button" value="UPDATE" class="update-button" onclick="enableRemarkButtons(this)" />
                    <span class="selected-remark"></span>
                </div>
            </div>
            <!-- Row 9 -->
            <div class="borrowed-content-row">
                <div>100309</div>
                <div>Amelia Taylor</div>
                <div>The Ocean</div>
                <div>2025-01-01</div>
                <div class="remarks">
                    <button class="remark-button good" onclick="updateRemark(this, 'GOOD')">GOOD</button>
                    <button class="remark-button damaged" onclick="updateRemark(this, 'DAMAGE')">DAMAGE</button>
                    <button class="remark-button lost" onclick="updateRemark(this, 'LOST')">LOST</button>
                    <input type="button" value="UPDATE" class="update-button" onclick="enableRemarkButtons(this)" />
                    <span class="selected-remark"></span>
                </div>
            </div>
            <!-- Row 10 -->
            <div class="borrowed-content-row">
                <div>100310</div>
                <div>Benjamin Harris</div>
                <div>The Shadow</div>
                <div>2024-12-30</div>
                <div class="remarks">
                    <button class="remark-button good" onclick="updateRemark(this, 'GOOD')">GOOD</button>
                    <button class="remark-button damaged" onclick="updateRemark(this, 'DAMAGE')">DAMAGE</button>
                    <button class="remark-button lost" onclick="updateRemark(this, 'LOST')">LOST</button>
                    <input type="button" value="UPDATE" class="update-button" onclick="enableRemarkButtons(this)" />
                    <span class="selected-remark"></span>
                </div>
            </div>
        </div>
    </div>
</div>





    </div>


        <!-- ========================= Main END ==================== -->



        <!-- =========== Scripts =========  -->
        <script src="/User-side/USER.JS"></script>
        <script>
            // Add event listener to all action buttons
document.querySelectorAll('.action-button').forEach(button => {
    button.addEventListener('click', function() {
        // Remove the 'active' class from all buttons
        document.querySelectorAll('.action-button').forEach(btn => btn.classList.remove('active'));
        
        // Add the 'active' class to the clicked button
        this.classList.add('active');
    });
});



// Function to handle the remark button clicks
function updateRemark(button, remark) {
    // Hide all remark buttons
    var allButtons = button.parentElement.querySelectorAll('.remark-button');
    allButtons.forEach(function(btn) {
        btn.classList.add('hidden'); // Hide the unselected buttons
    });

    // Show the selected button as active
    button.style.backgroundColor = button.classList.contains('good') ? '#f1c40f' :
                                  button.classList.contains('damaged') ? '#e74c3c' :
                                  button.classList.contains('lost') ? '#e67e22' : '';

    // Display the selected remark text next to the button
    const selectedRemarkText = button.textContent;
    const remarkTextDisplay = button.parentElement.querySelector('.selected-remark');
    remarkTextDisplay.textContent = selectedRemarkText;
}

// Function to enable remark buttons again and remove the selected remark text when the UPDATE button is clicked
function enableRemarkButtons(updateButton) {
    // Get all the remark buttons in the same row
    var remarkButtons = updateButton.parentElement.querySelectorAll('.remark-button');
    remarkButtons.forEach(function(button) {
        // Make the buttons visible again
        button.classList.remove('hidden');
        // Reset the background color of each button (retain original color)
        if (button.classList.contains('good')) {
            button.style.backgroundColor = '#f1c40f'; // Yellow for GOOD
        } else if (button.classList.contains('damaged')) {
            button.style.backgroundColor = '#e74c3c'; // Red for DAMAGE
        } else if (button.classList.contains('lost')) {
            button.style.backgroundColor = '#e67e22'; // Orange for LOST
        }
    });

    // Remove the remark text
    const remarkTextDisplay = updateButton.parentElement.querySelector('.selected-remark');
    remarkTextDisplay.textContent = ''; // Clear the remark text

    // Reset the "UPDATE" button background color to its original color
    updateButton.style.backgroundColor = '#2ecc71'; // Original color
}

        </script>




        <!-- ====== ionicons ======= -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>