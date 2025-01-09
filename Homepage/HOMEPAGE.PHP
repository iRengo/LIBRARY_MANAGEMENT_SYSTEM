<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librasphere Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.min.css"> <!-- Ionicons -->
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="homepage.css"> <!-- Link to your external CSS -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">
</head>

<body>

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
                <li class="nav-item"><a class="nav-link" href="#about-section">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Policies</a></li>
                <li class="nav-item"><a class="nav-link" href="#">FAQ</a></li>
            </ul>
        </div>

        <!-- Login Button -->
        <div class="login-btn">
            <button class="btn btn-dark"><b> <a href="signin.php" style="color:white;text-decoration:none;"> SIGN IN </b></a></button>
        </div>
    </div>
    <!-- Image section (Hero Section) with Overlay Text -->
    <div class="landing-container">
        <img src="homebg.PNG" alt="Homepage Image" class="landing-img">
        <div class="overlay-text">
            <div class="line1">LIBRASPHERE'S LIBRARY</div>
            <div class="line2">MANAGEMENT</div>
            <div class="line3">SYSTEM</div>
        </div>
        <div class="overlay-text2">
            <div class="line4">We provide fast, reliable, secured transactions</div>
            <div class="line5">Read, search, reserve & borrow books today.</div>
        </div>
        <div class="button-container">
        <a href="signup.php" style="text-decoration: none;color:white;"> <button class="btn btn-primary">SIGN UP</button></a>
            <button class="btn btn-secondary">GUEST</button>
        </div>
        <div class="overlay-text3">
    <div class="hours-dropdown">
        <button class="hours-button">
            <i class="bx bx-alarm"></i> HOURS <!-- Boxicon clock icon -->
            <i class="bx bx-chevron-down"></i> <!-- Boxicon chevron down icon -->
        </button>
        <div class="dropdown-content">
            <ul>
                <li><b>OPEN HOURS</b></li>
                <li>9:00 AM - 5:00 PM</li>
                <li><b> (  MON - FRI )</b></li>
            </ul>
        </div>
    </div>
</div>
    </div>


<div style="display: flex; align-items: center; justify-content: center; padding: 5%; gap: 20px; margin-top:5%;">

    <!-- Big Picture -->
    <div style="flex: 1; text-align: center;">
        <img src="whatlibra.jpg" alt="Big Picture" style="width: 100%; height: auto; max-height: 500px; object-fit: cover; border-radius: 10px;">
    </div>

    <!-- Description -->
    <div id="about-section" style="flex: 1; text-align: left; color: #4B4A4A; font-family: Arial, sans-serif; line-height: 1.6;">
        <h2 style="font-weight: bold; margin-bottom: 15px;">What is Library Management System ?</h2>
        <p>The Library Management System is a tool that simplifies and streamlines the process of managing library operations. It enables librarians to organize, search, and catalog books, manage user accounts, and monitor borrowing activities. </p>
        <p>With advanced features like personalized collections, guest access, and monitoring activities, it ensures fast, reliable, and secure transactions for both users and librarians.</p>
        <p>is a digital tool designed to help libraries manage their operations efficiently. It typically includes features for cataloging books and other materials, managing checkouts and returns, tracking inventory, and facilitating patron accounts. </p>
    </div>

</div>



    <center>
    <h1 style="padding-top: 5%;">SYSTEM FEATURES</h1>
</center>
<center>
    <h3 style="font-weight: 300; padding: 1%;">These features will help you to manage accounts and process with ease and security</h3>
</center>
<!-- System Features Section -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; padding: 2% 5%;">

    <!-- Div 1 -->
    <div style="background-color: #4B4A4A; border-radius: 10px; padding: 20px; text-align: center; color: white;">
        <ion-icon name="book" style="font-size: 50px; margin-bottom: 10px; color: white;"></ion-icon>
        <h4 style="font-weight: bold; margin-bottom: 10px;">CATALOGUING</h4>
        <p style="font-size: 0.9rem;">It is the process of creating a list of all bibliographic items such as short description, list of subjects, author name, and the classification.</p>
    </div>

    <!-- Div 2 -->
    <div style="background-color: #4B4A4A; border-radius: 10px; padding: 20px; text-align: center; color: white;">
        <ion-icon name="shield-half" style="font-size: 50px; margin-bottom: 10px; color: white;"></ion-icon>
        <h4 style="font-weight: bold; margin-bottom: 10px;">ONE TIME PASSWORD (OTP)</h4>
        <p style="font-size: 0.9rem;">It is a type of security where a generated sequence of numbers can be used for a single time</p>
    </div>

    <!-- Div 3 -->
    <div style="background-color: #4B4A4A; border-radius: 10px; padding: 20px; text-align: center; color: white;">
        <ion-icon name="albums" style="font-size: 50px; margin-bottom: 10px; color: white;"></ion-icon>
        <h4 style="font-weight: bold; margin-bottom: 10px;">PERSONAL COLLECTION</h4>
        <p style="font-size: 0.9rem;">A user can collect his/her favorite books that can be organized in his/her own account</p>
    </div>

    <!-- Div 4 -->
    <div style="background-color: #4B4A4A; border-radius: 10px; padding: 20px; text-align: center; color: white;">
        <ion-icon name="people-circle" style="font-size: 50px; margin-bottom: 10px; color: white;"></ion-icon>
        <h4 style="font-weight: bold; margin-bottom: 10px;">GUEST ACCOUNT</h4>
        <p style="font-size: 0.9rem;">A user can view a some limited features for them to see the system without creating an account</p>
    </div>

    <!-- Div 5 -->
    <div style="background-color: #4B4A4A; border-radius: 10px; padding: 20px; text-align: center; color: white;">
        <ion-icon name="time" style="font-size: 50px; margin-bottom: 10px; color: white;"></ion-icon>
        <h4 style="font-weight: bold; margin-bottom: 10px;"> MONITORING ACTIVITIES</h4>
        <p style="font-size: 0.9rem;">A user and librarian activities are monitored by admin keeping the system safe from suspicious activities or might be a unauthorized access </p>
    </div>

    <!-- Div 6 -->
    <div style="background-color: #4B4A4A; border-radius: 10px; padding: 20px; text-align: center; color: white;">
        <ion-icon name="hourglass" style="font-size: 50px; margin-bottom: 10px; color: white;"></ion-icon>
        <h4 style="font-weight: bold; margin-bottom: 10px;">EASY, FAST AND EFFICIENT</h4>
        <p style="font-size: 0.9rem;">Easy booking, borrowing processes in just a few clicks !</p>
    </div>

</div>
<!-- Benefits Section -->
<div style="display: flex; align-items: center; justify-content: space-between; padding: 5%; gap: 20px; margin-top: 5%; background-color:#F0F0F0;">

    <!-- Left Section: Checkboxes and Descriptions -->
    <div style="flex: 1; padding-right: 20px; font-family: Arial, sans-serif; line-height: 1.6;">
        <h2 style="color: #1C2E5C; font-weight: bold; margin-bottom: 15px;">Benefits of Library Management System</h2>
        
        <!-- Original 5 Benefits -->
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <ion-icon name="checkbox" style="font-size: 25px; color: blue; margin-right: 10px;"></ion-icon>
            <p>Improved catalog management for faster access to resources.</p>
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <ion-icon name="checkbox" style="font-size: 25px; color: blue; margin-right: 10px;"></ion-icon>
            <p>Efficient monitoring of user and librarian activities.</p>
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <ion-icon name="checkbox" style="font-size: 25px; color: blue; margin-right: 10px;"></ion-icon>
            <p>Secure borrowing process through OTP and user authentication.</p>
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <ion-icon name="checkbox" style="font-size: 25px; color: blue; margin-right: 10px;"></ion-icon>
            <p>Streamlined borrowing and returning processes.</p>
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <ion-icon name="checkbox" style="font-size: 25px; color: blue; margin-right: 10px;"></ion-icon>
            <p>Easy tracking of overdue books and timely notifications.</p>
        </div>

        <!-- 5 Additional Benefits -->
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <ion-icon name="checkbox" style="font-size: 25px; color: blue; margin-right: 10px;"></ion-icon>
            <p>Supports digital and physical book management seamlessly.</p>
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <ion-icon name="checkbox" style="font-size: 25px; color: blue; margin-right: 10px;"></ion-icon>
            <p>Reduces administrative workload for librarians.</p>
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <ion-icon name="checkbox" style="font-size: 25px; color: blue; margin-right: 10px;"></ion-icon>
            <p>Generates detailed reports for better resource planning.</p>
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <ion-icon name="checkbox" style="font-size: 25px; color: blue; margin-right: 10px;"></ion-icon>
            <p>Enhances collaboration between users and librarians.</p>
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <ion-icon name="checkbox" style="font-size: 25px; color: blue; margin-right: 10px;"></ion-icon>
            <p>Eco-friendly with reduced reliance on paper-based processes.</p>
        </div>
    </div>

    <!-- Right Section: Big Picture -->
    <div style="flex: 1; text-align: center;">
        <img src="benefitsr.png" alt="Benefits of Library Management System" style="width: 100%; height: auto; max-height: 500px; object-fit: cover; border-radius: 10px;">
    </div>
</div>

  <!-- About Us Section -->
<div style="display: flex; align-items: flex-start; justify-content: space-between; padding: 5%; gap: 20px;">
    <!-- Left Section: About Us Title -->
    <div style="flex: 1; padding: 20px; border: 1px solid #AFAFAF; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">

        <h2 style="font-family: Arial, sans-serif; color: #1C2E5C; font-weight: 700; margin-bottom: 15px;">ABOUT US</h2>
        <h5 style="color: GRAY; font-weight: bold; margin-top:5%;">LIBRASPHERE</h5>
        <h1 style="color: BLACK; font-weight: bold;">HOW</h1>
        <h1 style="color: BLACK; font-weight: bold;">WE</h1>
        <h1 style="color: BLACK; font-weight: bold;">STARTED</h1>

        <p style="font-family:Arial, Helvetica, sans-serif; margin-top:5%; color:gray"> Welcome to Librasphere, a revolutionary library management system designed to streamline and simplify the management of library operations. </p> <Br>
        <p style="font-family:Arial, Helvetica, sans-serif; color:gray"> Our system is tailored to provide an efficient and user-friendly interface for both librarians and library patrons. With a focus on automation, security, and personalized user experience, Librasphere ensures smooth library processes from book cataloging to borrowing and return management. </p> <bR>
        <p style="font-family:Arial, Helvetica, sans-serif; color:gray"> At Librasphere, we are committed to creating a better library experience that is both fast and reliable, while also keeping user data secure and providing real-time notifications for a seamless user experience. </p>
        <br>

        <p style="font-family:Arial, Helvetica, sans-serif; color:gray;"> <B> - Libraspehere Team (ARMFM)  </B></p>
    </div>
    

    <!-- Right Section: About Us Description and Picture -->
    <div style="flex: 1; text-align: left; color: #4B4A4A; font-family: Arial, sans-serif; line-height: 1.6; border: 1px solid #AFAFAF; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); padding: 20px;">
    <!-- Image Section -->
    <img src="books.jpg" alt="About Us Image" style="width: 100%; height: auto; max-height: 300px; object-fit: cover; margin-top: 10px;">
    
    <!-- New Section with two Divs -->
    <div style="display: flex; gap: 20px; margin-top: 20px;">
        <!-- Div 1 -->
        <div style="flex: 1; padding: 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); background-color:#F0F0F0;">
            <h2 style="font-family: Arial, Helvetica, sans-serif;">3 Months of</h2>
                <p style="font-family:Arial, Helvetica, sans-serif;font-size:small;color:gray;"> Giving People Fast, Efficient, and reliable system for managing books and booking books </p>
        </div>

        <!-- Div 2 -->
        <div style="flex: 1; padding: 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); background-color:#F0F0F0;">
            <h2 style="font-family: Arial, Helvetica, sans-serif;">Most Trusted by 100+ Users </h2>
            <p style="color:gray;font-size:small;font-family:Arial, Helvetica, sans-serif;"> Trusted by Instructors and Students </p>
        </div>
    </div>
</div>

</div>
    <!-- Header Section -->
    <div class="header">
    PRIVACY POLICY 
    <h4 style="font-size: medium; font-weight:200; margin-top:1%;"> Rules and regulations about the library management system & process </h4>
</div>

<!-- Content Section -->
<div class="container">
    <!-- Left Side Content -->
    <div class="left-content">
        <h2>Privacy Introduction & Effective Date</h2>
        <p><strong>Effective January, 2024</strong></p>
        <p><strong>Your Privacy Matters</strong></p>
        <p>Librasphere ("we," "our," "us") is committed to protecting your privacy. This Privacy Policy outlines how we collect, use, and protect the personal information you provide when using our Library Management System ("LMS").</p>

        <h3>Introduction</h3>
        <p><strong>Privacy Policy for Library Management System</strong></p>
        <p>Effective as of January 2024, Librasphere is dedicated to ensuring the privacy and security of our users' personal information. This privacy policy explains how we collect, use, share, and protect the information provided by users of our Library Management System (LMS). By using our LMS, you agree to the practices outlined in this document.</p>
        <p>To provide library services effectively, we may collect several types of information. Personal information, such as your name, contact details, library membership ID, address, and date of birth, is essential for maintaining your account and facilitating services. Additionally, system-generated data, including borrowing and reservation history, as well as login credentials, help streamline operations. We also collect usage data, like your IP address and access times, to ensure the system functions efficiently and securely.</p>
    </div>  


        <!-- Right Side Content (Table of Contents) -->
        <div class="right-content">
            <h2>Table of Contents</h2>
            <ul>
                <li><a href="#section1">Introduction</a></li>
                <li><a href="#section2">User Rights</a></li>
                <li><a href="#section4">Library Rules</a></li>
                <li><a href="#section3">Data Collection</a></li>
                <li><a href="#section4">Cookies</a></li>
                <!-- Add more sections as needed -->
            </ul>
        </div>
    </div>



  
</body> 
<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.js"></script>

</html>