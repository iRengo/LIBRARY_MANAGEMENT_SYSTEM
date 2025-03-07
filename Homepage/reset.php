<?php
session_start();
include 'db_connect.php';

$error = ""; // Initialize an error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_SESSION['email'];

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match! Please try again.";
    } else {
        // Hash the password and update the database
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE stud_acc SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);

        if ($stmt->execute()) {
            header("Location: signin.php?reset=success");
            exit();
        } else {
            $error = "Error resetting password! Please try again.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Reset Password </title>
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
            <h2>RESET YOUR PASSWORD</h2>
            <h4 class="small-font"> Change your password : </h4> <br>

            <form action="reset.php" method="POST">
                <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
                <Br> <Br>
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                <Br>
                <!-- Display error message if exists -->
                <?php if (!empty($error)) : ?>
                    <div class="alert alert-danger" style="color:red;"><?php echo $error; ?></div>
                <?php endif; ?>
                 <br> 

                <button type="submit" class="btn btn-primary">Confirm</button>
            </form>


            <p class="small-font" style="margin-top:3%;"> You already have account ? <a href="signin.php" style="color:black; "> Login now ! </a> </p>
            </form>
        </div>
    </div>
</div>





<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.js"></script>

</body>

</html>