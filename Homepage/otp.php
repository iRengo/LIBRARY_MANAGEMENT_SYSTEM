<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION["email"])) {
    $_SESSION["error"] = "Unauthorized access!";
    header("Location: forgot.php");
    exit();
}

$email = $_SESSION["email"];
$error = "";

// If OTP is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = trim($_POST["otp"]);

    // Fetch OTP from the database
    $stmt = $conn->prepare("SELECT otp, otp_expiry FROM stud_acc WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $stored_otp = $row["otp"];
        $otp_expiry = $row["otp_expiry"];

        // Validate OTP and check expiration
        if ($entered_otp == $stored_otp && time() < $otp_expiry) {
            $_SESSION["verified"] = true; // Allow password reset
            header("Location: reset.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid or expired OTP!";
            header("Location: otp.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again.";
        header("Location: otp.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Verify OTP </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="otp.css">

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
            <h2>ENTER YOUR OTP</h2>
            <h4 class="small-font">Enter the OTP sent to your email</h4> <br>

            <form action="otp.php" method="POST">
            <input type="text" name="otp" class="form-control" placeholder="Enter OTP" required>
            <Br>
            <br>
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger" style="color:red">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']); // Clear error after displaying
            }
            ?>
            <br>

            <button type="submit" class="btn btn-primary">Verify OTP</button>
        </form>

        <p class="small-font" style="margin-top: 3%;">Didn't receive an OTP? <a href="forgot.php" style="color: black;">Resend OTP</a></p>
    </div>
</div>
</div>





<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.js"></script>

</body>

</html>