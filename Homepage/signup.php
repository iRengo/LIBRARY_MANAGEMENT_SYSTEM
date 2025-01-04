<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Signup </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.min.css"> <!-- Ionicons -->
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="signup.css"> <!-- Link to your external CSS -->

    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">
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
            <h2>CREATE YOUR ACCOUNT</h2>
            <h4 class="small-font"> Let's get started by verifying your student number </h4> <br>
            <form action="login_handler.php" method="POST">
                <div class="form-group">
                    <input type="text" id="username" name="username" class="form-control" placeholder=" " required>
                    <label for="username">Enter your Student Number</label>
                </div>
               <button type="submit" class="btn btn-primary"> SUBMIT </button>

               <p class="small-font" style="margin-top:3%;"> You already have account ? <a href="#" style="color:black; "> Login now ! </a> </p> 
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