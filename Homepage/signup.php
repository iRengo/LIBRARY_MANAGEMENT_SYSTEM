<?php
session_start();
include 'db_connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = ""; // Initialize an error message variable

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_no = trim($_POST['student_no']);

    // Check if the student number already exists in stud_acc (registered students)
    $stmt_check = $conn->prepare("SELECT * FROM stud_acc WHERE student_no = ?");
    $stmt_check->bind_param("s", $student_no);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $error = "This student number is already registered. Please log in instead.";
    } else {
        // If student number is not registered, check if it exists in tbl_students
        $stmt = $conn->prepare("SELECT * FROM tbl_students WHERE student_number = ?");
        $stmt->bind_param("s", $student_no);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Store data in session
            $_SESSION['student_no'] = $row['student_number']; // Ensure column name is correct
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['email'] = $row['email'];

            // Redirect to register.php
            header("Location: register.php");
            exit();
        } else {
            $error = "Student number not found. Please contact the library.";
        }
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Signup </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="signup.css">

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


    <a href="signin.php" class="login-btn">
        <button class="btn btn-dark"><b> SIGN IN </b></button></a>
</div>
</div>

<div class="signup">
    <img src="signbacka.png" alt="Background Image">
    <div class="overlay-container">
        <div class="left-image">
            <img src="loginpic.png" alt="Left Side Image">
        </div>
        <div class="login-form-container">
            <h2>CREATE YOUR ACCOUNT</h2>
            <h4 class="small-font"> Let's get started by verifying your student number </h4> <br>

            <form action="signup.php" method="POST">
                <div class="form-group">
                    <input type="text" id="student_no" name="student_no" class="form-control" placeholder=" " required>
                    <label for="student_no">Enter your Student Number</label>
                </div>
                <button type="submit" class="btn btn-primary">SUBMIT</button>
            </form>

            <!-- Error Message -->
            <?php if (!empty($error)) { ?>
                <p style="color: red; margin-top: 10px;"><?php echo $error; ?></p>
            <?php } ?>

            <p class="small-font" style="margin-top:3%;">Already have an account? <a href="signin.php" style="color:black;">Login now!</a></p>
        </div>
    </div>
</div>





<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.js"></script>

</body>

</html>