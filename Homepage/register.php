<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/vendor/autoload.php';
include 'db_connect.php';

// Redirect if session is not set
if (!isset($_SESSION['student_no'])) {
    header("Location: signup.php");
    exit();
}

// Retrieve session data
$student_no = $_SESSION['student_no'];
$firstname = $_SESSION['first_name'];
$lastname = $_SESSION['last_name'];
$email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);

    // Check password strength
    if (!preg_match('/^(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/', $password)) {
        $error_message = "Password must be at least 8 characters long and include at least one number and one special character.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new account
        $sql = "INSERT INTO stud_acc (student_no, password, first_name, last_name, contact, email) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $student_no, $hashed_password, $firstname, $lastname, $contact, $email);

        if ($stmt->execute()) {

            $update = $conn->prepare("UPDATE stud_acc SET verified = 0 WHERE student_no = ?");
            $update->bind_param("s", $student_no);
            $update->execute();

            // Send verification email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'systemlibrarymanagement8@gmail.com';
                $mail->Password = 'ndur otbh aalt vicl'; // Use Gmail app password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('no-reply@librasphere.com', 'LibraSphere Support');
                $mail->addAddress($email, "$firstname $lastname");
                $mail->isHTML(true);
                $mail->Subject = 'Verify Your Email';
                $mail->Body = "Hi $firstname, <br><br>
                    Please click the link below to verify your email:<br>
                    <a href='http://localhost:3000/Homepage/verify.php?email=$email'>Verify Account</a><br><br>
                    This link will expire in 15 minutes.";

                $mail->send();
            } catch (Exception $e) {
                $error_message = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Registration Successful</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
        .swal2-popup {
        font-family: "Poppins", sans-serif;
    }
        </style>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: "success",
                title: "Registration Successful!",
                text: "Please check your email to verify your account.",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "signin.php";
            });
        </script>
    </body>
    </html>';


            // Redirect after success
            header("Location: signin.php");
            exit();
        } else {
            $error_message = "Error: " . $stmt->error;
        }
    }
}
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
    <link rel="stylesheet" href="register.css">
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">

    <style>
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
            <form method="POST" action="register.php">
                <h2>CREATE YOUR ACCOUNT</h2>


                <div class="form-group">
                    <input type="text" id="student_no" name="student_no" style=" font-size:16px;" class="form-control" value="<?php echo htmlspecialchars($student_no); ?>" readonly>
                    <label for="student_no">Student Number</label>
                </div>

                <!-- First Name and Last Name -->
                <div class="form-group-row">
                    <div class="form-group" style="flex: 1; margin-right: 10px;">
                        <input type="text" id="firstname" name="firstname" style=" font-size:16px;" class="form-control" placeholder=" " required value="<?php echo isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : ''; ?>">
                        <label for="firstname">First Name</label>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <input type="text" id="lastname" name="lastname" style=" font-size:16px;" class="form-control" placeholder=" " required value="<?php echo isset($_SESSION['last_name']) ? htmlspecialchars($_SESSION['last_name']) : ''; ?>">
                        <label for="lastname">Last Name</label>
                    </div>
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <input type="email" id="email" name="email" style=" font-size:16px;" class="form-control" placeholder=" " required value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>">
                    <label for="email">Email Address</label>
                </div>

                <div class="form-group-row" style="display: flex; gap: 10px; margin-bottom: 1rem;">
    <div class="form-group" style="flex: 1;">
        <label for="password">Password</label>
        <input 
            type="password" 
            id="password" 
            name="password" 
            class="form-control" 
            style="font-size:16px;" 
            placeholder=" " 
            required 
            oninput="validatePassword()">
        <small id="passwordHelp" style="color: red; display: none;">
            Password must be at least 8 characters long and include a number and a special character.
        </small>
    </div>
    <div class="form-group" style="flex: 1;">
        <label for="confirm_password">Confirm Password</label>
        <input 
            type="password" 
            id="confirm_password" 
            name="confirm_password" 
            class="form-control" 
            style="font-size:16px;" 
            placeholder=" " 
            required 
            oninput="checkPasswordMatch()">
        <small id="confirmHelp" style="color: red; display: none;">
            Passwords do not match.
        </small>
    </div>
</div>


                <!-- Contact Number -->
                <div class="form-group">
                    <input type="text" id="contact" name="contact" style=" font-size:16px;" class="form-control" placeholder=" " required>
                    <label for="contact">Contact Number</label>
                </div>

                <!-- Display error message -->
                <?php if (isset($error_message)) { ?>
                    <div class="alert alert-danger" style="margin-top: 10px; font-size: 14px; color:red;">
                        <?php echo $error_message; ?>
                    </div>
                <?php } ?>

                <div class="terms">
                    <input type="checkbox" required>
                    <p class="small-font"> &nbsp;&nbsp; I agree to the <a href="#" id="termsLink">Terms and Conditions </a></p>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">SUBMIT</button>



                <p class="small-font" style="margin-top:3%;">Already have an account? <a href="signin.php" style="color:black;">Login now!</a></p>
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
     function validatePassword() {
        const password = document.getElementById("password").value;
        const passwordHelp = document.getElementById("passwordHelp");

        const isValid = /^(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/.test(password);
        
        if (!isValid) {
            passwordHelp.style.display = "block";
        } else {
            passwordHelp.style.display = "none";
        }

        return isValid;
    }

    function checkPasswordMatch() {
        const password = document.getElementById("password").value;
        const confirm = document.getElementById("confirm_password").value;
        const confirmHelp = document.getElementById("confirmHelp");

        if (password !== confirm) {
            confirmHelp.style.display = "block";
        } else {
            confirmHelp.style.display = "none";
        }

        return password === confirm;
    }

    // Prevent form submission if validations fail
    document.querySelector("form").addEventListener("submit", function (e) {
        const isPasswordValid = validatePassword();
        const isMatch = checkPasswordMatch();

        if (!isPasswordValid || !isMatch) {
            e.preventDefault(); // stop submission
        }
    });
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



<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.js"></script>

</body>

</html>