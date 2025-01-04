<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Sigin </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.min.css"> <!-- Ionicons -->
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="signin.css"> <!-- Link to your external CSS -->

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
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
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

    <!-- Navbar links -->
    <div class="navbar-links">
        <ul class="nav">
            <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#">About</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Policies</a></li>
            <li class="nav-item"><a class="nav-link" href="#">FAQ</a></li>
        </ul>
    </div>

    <!-- Login Button -->
    <div class="login-btn">
        <button class="btn btn-dark"><b> SIGN IN </b></button>
    </div>
</div>

<div class="signup">
    <img src="signbacka.png" alt="Background Image">
    <div class="overlay-container">
        <div class="left-image">
            <img src="loginpic.png" alt="Left Side Image" >
        </div>
        <div class="login-form-container">
            <h2>LOGIN TO YOUR ACCOUNT</h2>
            <form action="login_handler.php" method="POST">
                <div class="form-group">
                    <input type="text" id="username" name="username" class="form-control" placeholder=" " required>
                    <label for="username">Username</label>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder=" " required>
                    <label for="password">Password</label>
                </div>
                <div class="form-group">
                    <div class="recaptcha-container">
                        <div class="g-recaptcha" data-sitekey="6LcbyK0qAAAAAD3K5wZbObRk5Z2_bbEVgir6thO7"></div>
                    </div>
                </div>

                <!--Terms and Conditions and Checkbox here-->
                <div class="terms">
                    <input type="checkbox" required>
                    <p class="small-font"> &nbsp;&nbsp; I agree to the <a href="#" id="termsLink">Terms and Conditions </a></p>
                </div>


                <button type="submit" class="btn btn-primary"> LOGIN </button>
                <!-- Forgot Password Link -->
                <div class="forgot-password">
                    <p class="small-font"><a href="forgot_password.php">Forgot your password?</a></p>
                </div>

                <!-- No Account? Create now! -->
                <div class="no-account">
                    <p class="small-font">Don't have an account? <a href="signup.php">Create now!</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
 
<div id="termsModal" class="modal" style="z-index: 999999;overflow:hidden;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 style="font-family:Arial, Helvetica, sans-serif;">Terms and Conditions</h2>
        <p style="font-family:Arial, Helvetica, sans-serif;">By using our library management system, you agree to the following terms and conditions:</p>
        
        <h3 style="font-family:Arial, Helvetica, sans-serif;">1. User Responsibilities</h3>
        <p style="font-family:Arial, Helvetica, sans-serif;">You are responsible for the safe keeping of all borrowed materials and are expected to return them by the due date. Late returns may incur penalties.</p>
        
        <h3 style="font-family:Arial, Helvetica, sans-serif;">2. Borrowing Policy</h3>
        <p style="font-family:Arial, Helvetica, sans-serif;">Users are allowed to borrow a maximum of five books at a time. Borrowing periods are typically two weeks, with the option for renewals depending on availability.</p>

        <h3 style="font-family:Arial, Helvetica, sans-serif;">3. Account Security</h3>
        <p style="font-family:Arial, Helvetica, sans-serif;">Users must ensure that their account credentials are kept secure. The library is not responsible for unauthorized access to accounts.</p>

        <h3 style="font-family:Arial, Helvetica, sans-serif;">4. Reservation and Cancellation</h3>
        <p style="font-family:Arial, Helvetica, sans-serif;">Users may reserve books that are currently unavailable. Cancellations must be made at least 24 hours before the scheduled pick-up time to avoid penalties.</p>

        <h3 style="font-family:Arial, Helvetica, sans-serif;">5. Modifications to Terms</h3>
        <p style="font-family:Arial, Helvetica, sans-serif;">The library reserves the right to modify these terms at any time. Users will be notified of any changes, and continued use of the library system constitutes acceptance of those changes.</p>

        <p style="font-family:Arial, Helvetica, sans-serif;">For further details, please contact the library staff or refer to our website for full terms and conditions.</p>
    </div>
</div>


<script>
// Get modal element
var modal = document.getElementById("termsModal");

// Get the link that opens the modal
var termsLink = document.getElementById("termsLink");

// Get the <span> element that closes the modal
var closeBtn = document.getElementsByClassName("close")[0];

// When the user clicks the link, open the modal
termsLink.onclick = function(event) {
    event.preventDefault();  // Prevent default link behavior
    modal.style.display = "block";
}

// When the user clicks the close button, close the modal
closeBtn.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

</script>


<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.js"></script>

</body>

</html>