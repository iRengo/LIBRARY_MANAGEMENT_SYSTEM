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
    <link rel="stylesheet" href="USER_STYLE2.CSS">
    <link rel="stylesheet" href="USER_HELP&SUPPORT.CSS">
    <style>
        .submit-ticket-section .row {
            display: flex;
            gap: 15px;
        }

        .submit-ticket-section .col {
            flex: 1;
        }
    </style>

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
                            <span class="title1">USER</span>
                        </a>
                    </div>
                </li>

                <li>
                    <a href="USER_DASHBOARD.PHP">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="file-tray-stacked-outline"></ion-icon>

                        </span>
                        <span class="title">Collection</span>
                    </a>
                </li>

                <li>
                <a href="USER_CATALOG.PHP">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Catalog</span>
                    </a>
                </li>

                <li>
                    <a href="USER_HISTORY.PHP">
                        <span class="icon">
                            <i class='bx bx-history' style="font-size:35px;"></i>
                        </span>
                        <span class="title">History</span>
                    </a>
                </li>

                <li>
                    <a href="USER_HELP&SUPPORT.PHP">
                        <span class="icon">
                            <ion-icon name="layers-outline"></ion-icon>
                        </span>
                        <span class="title">Help & Support</span>
                    </a>
                </li>

                <li>
                    <a href="USER_NOTIFICATION.PHP">
                        <span class="icon">
                            <ion-icon name="notifications-outline"></ion-icon>
                        </span>
                        <span class="title">Notifications</span>
                    </a>
                </li>
                <li>
                    <a href="USER_TRENDING.php">
                        <span class="icon">
                            <ion-icon name="trending-up-outline"></ion-icon>
                        </span>
                        <span class="title">Trending</span>
                    </a>
                </li>
                <li>
                    <a href="USER_SETTINGS.php">
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
                    <a href="#" id="logoutIcon" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                        <p style="margin: 0; font-size: 18px; margin-right: 8px;">LOGOUT</p>
                        <i class='bx bx-log-in-circle' style="font-size:35px; color:#da1b1b;"></i>
                    </a>
                </div>
            </div>

            <!-- Content HERE -->

            <div style="display: flex; justify-content: space-between; margin-top: 5%; border: 1px solid #ccc; padding: 20px; border-radius: 10px;">
                <div style="margin: auto;">
                    <img src="helpsup1.png" alt="Left Image" style="max-width: 200px;max-height:200px;">
                </div>
                <div class="center" style="text-align: center;">
                    <div style="margin-bottom: 10px;margin-top:8%;">
                        <h3 style="margin: 0; font-size: 1.5rem; color: #333;">HELP CENTER</h3>
                        <p style="margin: 5px 0; font-size: 0.9rem; color: gray;">How can we assist you today?</p>
                    </div>
                    <input type="text" placeholder="Search..." style="border-radius: 20px; max-height: 100%; width: 500px; height: 40px; padding: 10px; font-size: 16px; border: 1px solid #ccc;">
                </div>
                <div style="margin: auto;">
                    <img src="helpsup2.png" alt="Right Image" style="max-width:300px;max-height:250px;">
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="help-support-container">
                <div class="faq-section">
                    <h2>Frequently Asked Questions</h2>
                    <div class="faq-items">
                        <div class="faq-item">
                            <h3 class="faq-question">How do I borrow books?</h3>
                            <div class="faq-answer">
                                <p>To borrow books, navigate to the "Collection" section, choose the book you wish to borrow, and click on "Borrow". You will need to be logged in to borrow books.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <h3 class="faq-question">How do I return a book?</h3>
                            <div class="faq-answer">
                                <p>To return a book, visit your "History" section and click on the "Return" option next to the borrowed book.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <h3 class="faq-question">What if I lose a book?</h3>
                            <div class="faq-answer">
                                <p>If a book is lost, please contact support immediately. We will guide you through the process of reporting the loss and any potential fines.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <h3 class="faq-question">What if I damaged a book ?</h3>
                            <div class="faq-answer">
                                <p>If a book is damaged, please contact support immediately. We will guide you through the process of reporting the loss and any potential fines.</p>
                            </div>
                        </div>
                        <div class="faq-item">
                            <h3 class="faq-question">Do you accept e wallet ?</h3>
                            <div class="faq-answer">
                                <p>If a book is damaged, please contact support immediately. We will guide you through the process of reporting the loss and any potential fines.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="submit-ticket-section">
                    <Br>
                    <h2>Submit a Ticket</h2>
                    <p>Contact us and send a message. We’re here to help you out!</p>
                    <br><BR><BR>
                    <form>
                        <!-- First Name and Last Name on the same line -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="first-name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first-name" required>
                            </div>
                            <div class="col">
                                <label for="last-name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last-name" required>
                            </div>
                        </div>
                        <!-- Contact Number -->
                        <div class="mb-3">
                            <label for="contact-number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact-number" required>
                        </div>
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <!-- Message -->
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="4" required></textarea>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

            </div>

             <!-- continue here-->
             <div class="grid-container">
            <div class="grid-item">
                <ion-icon name="card-outline"></ion-icon>
                <p>Transactions</p>
            </div>
            <div class="grid-item">
                <ion-icon name="person-outline"></ion-icon>
                <p>Account</p>
            </div>
            <div class="grid-item">
                <ion-icon name="book-outline"></ion-icon>
                <p>Collection</p>
            </div>
            <div class="grid-item">
                <ion-icon name="time-outline"></ion-icon>
                <p>History</p>
            </div>

            <div class="grid-item">
                <ion-icon name="warning-outline"></ion-icon>
                <p>Violations</p>
            </div>

            <div class="grid-item">
                <ion-icon name="settings-outline"></ion-icon>
                <p>Settings</p>
            </div>
        </div>



       
         

    </div>


    <!-- ========================= Main END ==================== -->



    <!-- =========== Scripts =========  -->
    <script src="USER.js"></script>
    <script>
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            const faqQuestion = item.querySelector('.faq-question');
            faqQuestion.addEventListener('click', () => {
                item.classList.toggle('active');
            });
        });
    </script>




    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>