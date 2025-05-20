<?php
include 'release_upcoming_books.php';
include 'due_overdue_checkr.php';

// Retrieve error message if it exists
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : "";
unset($_SESSION['error_message']); // Clear error message after displaying


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Sigin </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="signin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <style>
        .recaptcha-container {
            width: 250px;
            height: 60px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: rgb(231, 231, 231);
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

</head>

<div class="topbar">
    <div class="logo-and-title">
        <div class="logo">
            <img src="../logosample1.png" alt="Logo" style="height: 60px; width:60px; padding:4px;">
        </div>
        <div class="title">
            <p style="font-family: viga; margin: 0; padding-right:2px;">LIBRA</p>
            <p style="font-family: zilla slab highlight; letter-spacing: 2px; margin: 0;">SPHERE</p>
        </div>
    </div>


    <div class="navbar-links">
        <ul class="nav">
            <li class="nav-item"><a class="nav-link" href="HOMEPAGE.PHP">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#">About</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Policies</a></li>
            <li class="nav-item"><a class="nav-link" href="#">FAQ</a></li>
        </ul>
    </div>


    <div class="login-btn">
        <button class="btn btn-dark"><b> SIGN IN </b></button>
    </div>
</div>

<div class="signup">
    <img src="signbacka.png" alt="Background Image">
    <div class="overlay-container">
        <div class="left-image">
            <img src="loginpic.png" alt="Left Side Image">
        </div>
        <form method="POST" action="login_handler.php" style="margin-right: -5%;">
            <div class="login-form-container">
                <h2>LOGIN TO YOUR ACCOUNT</h2>


                <div class="form-group">
                    <input type="text" id="user_no" name="user_no" class="form-control" placeholder="User Number" required>

                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <?php if (!empty($error_message)) : ?>
                    <div class="alert alert-danger">
                        <p style="color:red;"><?php echo $error_message; ?> </p>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="6LcbyK0qAAAAAD3K5wZbObRk5Z2_bbEVgir6thO7"></div>
                </div>

                <button type="submit" class="btn btn-primary">LOGIN</button>

                <div class="forgot-password">
                    <p><a href="forgot.php">Forgot your password?</a></p>
                </div>
                <div class="no-account">
                    <p>Don't have an account? <a href="signup.php">Create now!</a></p>
                </div>
            </div>
        </form>
    </div>
</div>
</div>


<div id="termsModal" class="modal" style="z-index: 999999; overflow: hidden;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 style="font-family: Arial, Helvetica, sans-serif; text-align: left;">Terms and Conditions</h2>
        <p style="font-family: Arial, Helvetica, sans-serif; text-align: left;">
            By accessing or using our Library Management System, you agree to comply with and be bound by the following terms and conditions.
        </p>

        <div style="font-family: Arial, Helvetica, sans-serif; text-align: left; line-height: 1.6;">
            <p><strong>1. User Responsibilities</strong></p>
            <p>Users are required to maintain the integrity of borrowed materials and ensure their timely return. Late returns may result in penalties, including fines or temporary suspension of borrowing privileges.</p>

            <p><strong>2. Borrowing Policies</strong></p>
            <p>Borrowing is limited to a maximum of five (5) items at any given time. Standard borrowing periods are two (2) weeks, subject to renewal based on item availability and user compliance.</p>

            <p><strong>3. Account Security</strong></p>
            <p>Users are responsible for safeguarding their account credentials. The library is not liable for any unauthorized access or misuse of user accounts resulting from user negligence.</p>

            <p><strong>4. Reservations and Cancellations</strong></p>
            <p>Reservations for unavailable materials can be made through the system. Cancellations must be completed at least twenty-four (24) hours prior to the scheduled pick-up time. Failure to cancel within this timeframe may result in penalties.</p>

            <p><strong>5. System Usage</strong></p>
            <p>Users must utilize the Library Management System solely for its intended purposes. Any misuse, including unauthorized access or attempts to manipulate system functionality, is strictly prohibited.</p>

            <p><strong>6. Amendments to Terms</strong></p>
            <p>The library reserves the right to amend these terms and conditions at its discretion. Users will be notified of significant changes, and continued use of the system constitutes acceptance of any updated terms.</p>

            <p><strong>7. Contact Information</strong></p>
            <p>For inquiries regarding these terms and conditions, please contact the library administration. Additional details are available on our official website or by reaching out to library staff.</p>
        </div>

        <!-- Accept and Decline Buttons -->
        <div style="text-align: center; margin-top: 20px;">
            <button id="acceptBtn" class="btn btn-success">Accept</button>
            <button id="declineBtn" class="btn btn-danger">Decline</button>
        </div>
    </div>
</div>


<script>
    // Get modal element
    var modal = document.getElementById("termsModal");

    // Get the link that opens the modal
    var termsLink = document.getElementById("termsLink");

    // Get the <span> element that closes the modal
    var closeBtn = document.getElementsByClassName("close")[0];

    // Get Accept and Decline buttons
    var acceptBtn = document.getElementById("acceptBtn");
    var declineBtn = document.getElementById("declineBtn");

    // Get the checkbox for terms
    var termsCheckbox = document.querySelector(".terms input[type='checkbox']");

    // When the user clicks the link, open the modal
    termsLink.onclick = function(event) {
        event.preventDefault(); // Prevent default link behavior
        modal.style.display = "block";
    };

    // When the user clicks the close button, close the modal
    closeBtn.onclick = function() {
        modal.style.display = "none";
    };

    // When the user clicks Accept
    acceptBtn.onclick = function() {
        modal.style.display = "none"; // Close the modal
        termsCheckbox.checked = true; // Check the checkbox
    };

    // When the user clicks Decline
    declineBtn.onclick = function() {
        modal.style.display = "none"; // Close the modal
        termsCheckbox.checked = false; // Ensure the checkbox is unchecked
    };

    // When the user clicks anywhere outside the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');

    if (message) {
      let toastOptions = {
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
      };

      switch (message) {
        case 'verified':
          Swal.fire({ ...toastOptions, icon: 'success', title: 'Email successfully verified!' });
          break;
        case 'already_verified':
          Swal.fire({ ...toastOptions, icon: 'info', title: 'Email already verified or invalid.' });
          break;
        case 'invalid':
          Swal.fire({ ...toastOptions, icon: 'error', title: 'Invalid verification request.' });
          break;
      }

      // Clean the URL after showing the toast
      const cleanUrl = window.location.origin + window.location.pathname;
      window.history.replaceState({}, document.title, cleanUrl);
    }
  });
</script>



<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.js"></script>

</body>

</html>