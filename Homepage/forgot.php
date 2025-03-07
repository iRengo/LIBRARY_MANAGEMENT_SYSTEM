<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Check if the email exists
    $stmt = $conn->prepare("SELECT * FROM stud_acc WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $_SESSION['error'] = "Email not found!";
        header("Location: forgot.php");
        exit();
    }

    // Store email in session and redirect to otp.php
    $_SESSION["email"] = $email;
    header("Location: otp.php"); // Redirect first
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Forgot Password </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="forgot.css">

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


    <div class="navbar-links">
        <ul class="nav">
            <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
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
        <div class="login-form-container">
            <h2>FORGOT YOUR PASSWORD</h2>
            <h4 class="small-font"> Enter your Email : </h4> <br>

            <form action="send_otp.php" method="POST">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter your Email" required>
                </div>
                <?php
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger" style="color:red;">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']); // Clear the error after displaying
                }
                ?>
                <Br>

                <button type="submit" class="btn btn-primary">Send OTP</button>
            </form>


            <p class="small-font" style="margin-top:3%;">Already have an account? <a href="signin.php" style="color:black;">Login now!</a></p>
        </div>
    </div>
</div>






<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.js"></script>

</body>

</html>