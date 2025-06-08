<?php
include 'archiver.php';
include 'db_connect.php';
include 'UNCLAIMED_BOOK_CHECKER.PHP';
include 'due_overdue_checkr.php';
include 'release_upcoming_books.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librasphere Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.min.css"> 
    <link href="https://cdn.jsdelivr.net/npm/ionicons@5.4.0/dist/css/ionicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="homepage.css"> 
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
                <li class="nav-item"><a class="nav-link" href="#homepage">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about-section">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact-us">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="#policies">Policies</a></li>
                <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
            </ul>
        </div>

        <!-- Login Button -->
        <div class="login-btn">
            <button class="btn btn-dark"><b> <a href="signin.php" style="color:white;text-decoration:none;"> SIGN IN </b></a></button>
        </div>
    </div>
    <!-- Image section (Hero Section) with Overlay Text -->
    <div class="landing-container" id="homepage">
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
            <a href="../Guest-side/GUEST_DASHBOARD.php"> <button class="btn btn-secondary">GUEST</button></a>
        </div>
        <div class="overlay-text3">
            <div class="hours-dropdown">
                <button class="hours-button">
                    <i class="bx bx-alarm"></i> HOURS 
                    <i class="bx bx-chevron-down"></i>
                </button>
                <div class="dropdown-content">
                    <ul>
                        <li><b>OPEN HOURS</b></li>
                        <li>9:00 AM - 5:00 PM</li>
                        <li><b> ( MON - FRI )</b></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

 <!--
    <div style="display: flex; align-items: center; justify-content: center; padding: 5%; gap: 20px; margin-top:5%;">

     
        <div style="flex: 1; text-align: center;">
            <img src="whatlibra.jpg" alt="Big Picture" style="width: 100%; height: auto; max-height: 500px; object-fit: cover; border-radius: 10px;">
        </div>

   
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

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; padding: 2% 5%;">

    
        <div style="background-color: #4B4A4A; border-radius: 10px; padding: 20px; text-align: center; color: white;">
            <ion-icon name="book" style="font-size: 50px; margin-bottom: 10px; color: white;"></ion-icon>
            <h4 style="font-weight: bold; margin-bottom: 10px;">CATALOGUING</h4>
            <p style="font-size: 0.9rem;">It is the process of creating a list of all bibliographic items such as short description, list of subjects, author name, and the classification.</p>
        </div>


        <div style="background-color: #4B4A4A; border-radius: 10px; padding: 20px; text-align: center; color: white;">
            <ion-icon name="shield-half" style="font-size: 50px; margin-bottom: 10px; color: white;"></ion-icon>
            <h4 style="font-weight: bold; margin-bottom: 10px;">ONE TIME PASSWORD (OTP)</h4>
            <p style="font-size: 0.9rem;">It is a type of security where a generated sequence of numbers can be used for a single time</p>
        </div>

  
        <div style="background-color: #4B4A4A; border-radius: 10px; padding: 20px; text-align: center; color: white;">
            <ion-icon name="albums" style="font-size: 50px; margin-bottom: 10px; color: white;"></ion-icon>
            <h4 style="font-weight: bold; margin-bottom: 10px;">PERSONAL COLLECTION</h4>
            <p style="font-size: 0.9rem;">A user can collect his/her favorite books that can be organized in his/her own account</p>
        </div>

        <div style="background-color: #4B4A4A; border-radius: 10px; padding: 20px; text-align: center; color: white;">
            <ion-icon name="people-circle" style="font-size: 50px; margin-bottom: 10px; color: white;"></ion-icon>
            <h4 style="font-weight: bold; margin-bottom: 10px;">GUEST ACCOUNT</h4>
            <p style="font-size: 0.9rem;">A user can view a some limited features for them to see the system without creating an account</p>
        </div>


        <div style="background-color: #4B4A4A; border-radius: 10px; padding: 20px; text-align: center; color: white;">
            <ion-icon name="time" style="font-size: 50px; margin-bottom: 10px; color: white;"></ion-icon>
            <h4 style="font-weight: bold; margin-bottom: 10px;"> MONITORING ACTIVITIES</h4>
            <p style="font-size: 0.9rem;">A user and librarian activities are monitored by admin keeping the system safe from suspicious activities or might be a unauthorized access </p>
        </div>


        <div style="background-color: #4B4A4A; border-radius: 10px; padding: 20px; text-align: center; color: white;">
            <ion-icon name="hourglass" style="font-size: 50px; margin-bottom: 10px; color: white;"></ion-icon>
            <h4 style="font-weight: bold; margin-bottom: 10px;">EASY, FAST AND EFFICIENT</h4>
            <p style="font-size: 0.9rem;">Easy booking, borrowing processes in just a few clicks !</p>
        </div>

    </div>
 
    <div style="display: flex; align-items: center; justify-content: space-between; padding: 5%; gap: 20px; margin-top: 5%; background-color:#F0F0F0;">


        <div style="flex: 1; padding-right: 20px; font-family: Arial, sans-serif; line-height: 1.6;">
            <h2 style="color: #1C2E5C; font-weight: bold; margin-bottom: 15px;">Benefits of Library Management System</h2>

      
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

   
        <div style="flex: 1; text-align: center;">
            <img src="benefitsr.png" alt="Benefits of Library Management System" style="width: 100%; height: auto; max-height: 500px; object-fit: cover; border-radius: 10px;">
        </div>
    </div>


    <div id="about-section" style="display: flex; align-items: flex-start; justify-content: space-between; padding: 5%; gap: 20px;">
      
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

            <p style="font-family:Arial, Helvetica, sans-serif; color:gray;"> <B> - Libraspehere Team (ARMFM) </B></p>
        </div>


  
        <div style="flex: 1; text-align: left; color: #4B4A4A; font-family: Arial, sans-serif; line-height: 1.6; border: 1px solid #AFAFAF; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); padding: 20px;">
     
            <img src="books.jpg" alt="About Us Image" style="width: 100%; height: auto; max-height: 300px; object-fit: cover; margin-top: 10px;">

       
            <div style="display: flex; gap: 20px; margin-top: 20px;">
         
                <div style="flex: 1; padding: 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); background-color:#F0F0F0;">
                    <h2 style="font-family: Arial, Helvetica, sans-serif;">3 Months of</h2>
                    <p style="font-family:Arial, Helvetica, sans-serif;font-size:small;color:gray;"> Giving People Fast, Efficient, and reliable system for managing books and booking books </p>
                </div>

           
                <div style="flex: 1; padding: 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); background-color:#F0F0F0;">
                    <h2 style="font-family: Arial, Helvetica, sans-serif;">Most Trusted by 100+ Users </h2>
                    <p style="color:gray;font-size:small;font-family:Arial, Helvetica, sans-serif;"> Trusted by Instructors and Students </p>
                </div>
            </div>
        </div>

    </div>

    <div class="header" id="policies">
        PRIVACY POLICY
        <h4 style="font-size: medium; font-weight:200; margin-top:1%;"> Rules and regulations about the library management system & process </h4>
    </div>

 
    <div class="container">
     
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


  
        <div class="right-content">
            <h2>Table of Contents</h2>
            <ul>
                <li><a href="#section1">Introduction</a></li>
                <li><a href="#section2">User Rights</a></li>
                <li><a href="#section4">Library Rules</a></li>
                <li><a href="#section3">Data Collection</a></li>
                <li><a href="#section4">Cookies</a></li>
      
            </ul>
        </div>
    </div>


    <div style="padding: 5%; background-color: #f9f9f9; border-top: 1px solid #e0e0e0;">
        <h2 style="text-align: center; font-family: Arial, sans-serif; font-weight: 700; margin-bottom: 20px;">Latest News</h2>
        <div style="display: flex; gap: 20px; justify-content: center;">
            <div style="flex: 1; padding: 20px; background-color: white; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                <h4 style="font-family: Arial, sans-serif; font-weight: bold;">New Books Added</h4>
                <p style="color: #333;">Explore our latest collection of books added this month. Visit the catalog to find your next read!</p>
            </div>
            <div style="flex: 1; padding: 20px; background-color: white; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                <h4 style="font-family: Arial, sans-serif; font-weight: bold;">Upcoming Events</h4>
                <p style="color: #333;">Join us for our upcoming book fair on January 15th. Don't miss out on exciting activities and giveaways!</p>
            </div>
        </div>
    </div>


    <div style="padding: 5%; background-color: #ffffff; border-top: 1px solid #e0e0e0;">
        <h2 style="text-align: center; font-family: Arial, sans-serif; font-weight: 700; margin-bottom: 20px;">What Our Users Say</h2>
        <div style="display: flex; gap: 20px; justify-content: center;">
            <div style="flex: 1; padding: 20px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                <p style="font-style: italic; color: #555;">"Librasphere has completely transformed the way I manage my library activities. It's fast, reliable, and user-friendly!"</p>
                <p style="text-align: right; font-weight: bold; color: #333;">- John Doe</p>
            </div>
            <div style="flex: 1; padding: 20px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                <p style="font-style: italic; color: #555;">"The personalized collection feature is a game-changer. I can now organize my favorite books effortlessly."</p>
                <p style="text-align: right; font-weight: bold; color: #333;">- Jane Smith</p>
            </div>
        </div>
    </div>


    <div class="contact-us" style="padding: 5%; background:rgb(240, 240, 240); border-top: 1px solid #e0e0e0; color: white; border:1px solid gray;" id="contact-us">
        <h2 style="font-family: Arial, sans-serif; font-weight: 700; margin-bottom: 20px; color: black;">Contact Us</h2>
        <div style="display: flex; gap: 20px;">
            <div style="flex: 1; padding: 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); background-color: rgba(255, 255, 255, 0.9); border-radius: 8px;">
                <h4 style="font-family: Arial, sans-serif; font-weight: bold; color: #1C2E5C;">Get in Touch</h4>
                <p style="color: #333;">If you have any questions or need support, feel free to reach out to us. We are here to assist you!</p>
                <ul style="color: #333;">
                    <li>Email: support@librasphere.com</li>
                    <li>Phone: +1 234 567 890</li>
                    <li>Address: 123 Library St., City, Country</li>
                </ul>
            </div>
            <div style="flex: 1; padding: 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); background-color: rgba(255, 255, 255, 0.9); border-radius: 8px;">
                <h4 style="font-family: Arial, sans-serif; font-weight: bold; color: #1C2E5C;">Contact Form</h4>
                <form action="#" method="POST">
                    <label for="name" style="font-weight: bold; color: #333;">Your Name:</label>
                    <input type="text" id="name" name="name" placeholder="Your Name"
                        style="width: 100%; padding: 12px 20px; margin: 10px 0; border-radius: 8px; 
                    background-color: #f0f4f7; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
                    font-size: 16px; color: #333; transition: all 0.3s ease;"
                        onfocus="this.style.borderColor='#1C2E5C'; this.style.boxShadow='0 0 8px rgba(28, 46, 92, 0.2)';"
                        onblur="this.style.borderColor='#ddd'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)';" />

                    <label for="email" style="font-weight: bold; color: #333;">Your Email:</label>
                    <input type="email" id="email" name="email" placeholder="Your Email"
                        style="width: 100%; padding: 12px 20px; margin: 10px 0; border-radius: 8px; 
                    background-color: #f0f4f7; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
                    font-size: 16px; color: #333; transition: all 0.3s ease;"
                        onfocus="this.style.borderColor='#1C2E5C'; this.style.boxShadow='0 0 8px rgba(28, 46, 92, 0.2)';"
                        onblur="this.style.borderColor='#ddd'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)';" />

                    <label for="inquiry" style="font-weight: bold; color: #333;">Inquiry Type:</label>
                    <select id="inquiry" name="inquiry"
                        style="width: 100%; padding: 12px 20px; margin: 10px 0; border-radius: 8px; 
                    background-color: #f0f4f7; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
                    font-size: 16px; color: #333; transition: all 0.3s ease;">
                        <option value="general">General Inquiry</option>
                        <option value="support">Support</option>
                        <option value="feedback">Feedback</option>
                    </select>

                    <label for="message" style="font-weight: bold; color: #333;">Message:</label>
                    <textarea id="message" name="message" placeholder="Your Message"
                        style="width: 100%; padding: 12px 20px; margin: 10px 0; height: 100px; border-radius: 8px; 
                    background-color: #f0f4f7; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
                    font-size: 16px; color: #333; transition: all 0.3s ease;"
                        onfocus="this.style.borderColor='#1C2E5C'; this.style.boxShadow='0 0 8px rgba(28, 46, 92, 0.2)';"
                        onblur="this.style.borderColor='#ddd'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)';"></textarea>

                    <button type="submit"
                        style="padding: 12px 24px; background-color: #343536; color: white; border-radius: 5px; border: none; 
                    font-size: 16px; cursor: pointer; transition: background-color 0.3s;">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>


    <div class="faq-container" style="padding: 40px; margin-top: 20px; height: 800px; overflow-y: auto;" id="faq">

   
        <div class="faq-title" style="text-align: center; margin-bottom: 20px;">
            <h4 style="font-size: 24px; color: #1C2E5C;">LIBRASPHERE'S</h4>
            <h2 style="font-size: 36px; font-weight: bold; color: #1C2E5C;">FREQUENTLY ASKED QUESTIONS</h2>
        </div>


        <div class="search-bar" style="text-align: center; margin-bottom: 20px;">
            <input
                type="text"
                id="faqSearch"
                placeholder="Search FAQs..."
                style="width: 60%; padding: 12px 20px; margin-top: 20px; 
            font-size: 16px; border-radius: 30px; 
            border: 1px solid #1C2E5C; 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
            outline: none; transition: all 0.3s ease;"
                onkeyup="searchFAQ()" />
        </div>
        <br> <Br> <br> <Br> <br> <Br>

        <div class="faq-grid" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">

 
            <div class="faq-section" id="general">
                <h3>General</h3>
                <div class="faq-item" style="padding: 20px;">
                    <button class="faq-question" onclick="toggleAnswer('gen1')" style="width: 100%; padding: 15px; text-align: left; background-color: #f4f4f4; border: 1px solid #ccc; margin: 10px 0; border-radius: 5px;">
                        What is Librasphere?
                    </button>
                    <div id="gen1" class="faq-answer" style="display: none; padding: 15px; background-color: #f9f9f9; border-left: 2px solid #1C2E5C;">
                        Librasphere is a library management system designed to streamline library operations, making them more efficient and user-friendly.
                    </div>
                </div>
                <div class="faq-item" style="padding: 20px;">
                    <button class="faq-question" onclick="toggleAnswer('gen2')" style="width: 100%; padding: 15px; text-align: left; background-color: #f4f4f4; border: 1px solid #ccc; margin: 10px 0; border-radius: 5px;">
                        How do I use Librasphere?
                    </button>
                    <div id="gen2" class="faq-answer" style="display: none; padding: 15px; background-color: #f9f9f9; border-left: 2px solid #1C2E5C;">
                        To use Librasphere, simply create an account and start browsing the library catalog. You can borrow, return, and reserve books seamlessly.
                    </div>
                </div>
            </div>

     
            <div class="faq-section" id="accounts">
                <h3>Accounts</h3>
                <div class="faq-item" style="padding: 20px;">
                    <button class="faq-question" onclick="toggleAnswer('acc1')" style="width: 100%; padding: 15px; text-align: left; background-color: #f4f4f4; border: 1px solid #ccc; margin: 10px 0; border-radius: 5px;">
                        How do I create an account?
                    </button>
                    <div id="acc1" class="faq-answer" style="display: none; padding: 15px; background-color: #f9f9f9; border-left: 2px solid #1C2E5C;">
                        You can create an account by clicking on the "Sign Up" button on the homepage and providing the required details.
                    </div>
                </div>
                <div class="faq-item" style="padding: 20px;">
                    <button class="faq-question" onclick="toggleAnswer('acc2')" style="width: 100%; padding: 15px; text-align: left; background-color: #f4f4f4; border: 1px solid #ccc; margin: 10px 0; border-radius: 5px;">
                        I forgot my password. What should I do?
                    </button>
                    <div id="acc2" class="faq-answer" style="display: none; padding: 15px; background-color: #f9f9f9; border-left: 2px solid #1C2E5C;">
                        If you've forgotten your password, click the "Forgot Password" link on the login page, and follow the instructions to reset your password.
                    </div>
                </div>
            </div>


            <div class="faq-section" id="transactions">
                <h3>Transactions</h3>
                <div class="faq-item" style="padding: 20px;">
                    <button class="faq-question" onclick="toggleAnswer('trans1')" style="width: 100%; padding: 15px; text-align: left; background-color: #f4f4f4; border: 1px solid #ccc; margin: 10px 0; border-radius: 5px;">
                        How do I borrow a book?
                    </button>
                    <div id="trans1" class="faq-answer" style="display: none; padding: 15px; background-color: #f9f9f9; border-left: 2px solid #1C2E5C;">
                        To borrow a book, simply browse the catalog, select the book you wish to borrow, and click "Borrow." You can then pick it up at the library.
                    </div>
                </div>
                <div class="faq-item" style="padding: 20px;">
                    <button class="faq-question" onclick="toggleAnswer('trans2')" style="width: 100%; padding: 15px; text-align: left; background-color: #f4f4f4; border: 1px solid #ccc; margin: 10px 0; border-radius: 5px;">
                        Can I cancel my reservation?
                    </button>
                    <div id="trans2" class="faq-answer" style="display: none; padding: 15px; background-color: #f9f9f9; border-left: 2px solid #1C2E5C;">
                        Yes, you can cancel your reservation by going to your account's reservation section and clicking the "Cancel" button next to the book.
                    </div>
                </div>
            </div>

        </div> 

    </div>

    <script>
        // Function to toggle the visibility of the answer
        function toggleAnswer(id) {
            var answer = document.getElementById(id);
            if (answer.style.display === "none") {
                answer.style.display = "block";
            } else {
                answer.style.display = "none";
            }
        }

        // Function to filter FAQ based on search input
        function searchFAQ() {
            var input, filter, sections, questions, question, i, txtValue;
            input = document.getElementById('searchInput');
            filter = input.value.toLowerCase();
            sections = document.getElementsByClassName('faq-section');

            for (i = 0; i < sections.length; i++) {
                questions = sections[i].getElementsByClassName('faq-item');
                for (var j = 0; j < questions.length; j++) {
                    question = questions[j].getElementsByClassName('faq-question')[0];
                    txtValue = question.textContent || question.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        questions[j].style.display = "";
                    } else {
                        questions[j].style.display = "none";
                    }
                }
            }
        }
    </script>

  
    <footer style="background-color: #1C2E5C; color: white; padding: 20px 0; text-align: center;">
        <p style="margin: 0; font-family: Arial, sans-serif;">&copy; 2025 Librasphere. All rights reserved.</p>
        <div style="margin-top: 10px;">
            <a href="#" style="color: white; text-decoration: none; margin: 0 10px;">Privacy Policy</a> |
            <a href="#" style="color: white; text-decoration: none; margin: 0 10px;">Terms of Service</a> |
            <a href="mailto:support@librasphere.com" style="color: white; text-decoration: none; margin: 0 10px;">Contact Us</a>
        </div>

    
        <div style="margin-top: 15px;">
            <a href="https://www.facebook.com" target="_blank" style="color: white; text-decoration: none; margin: 0 15px;">
                <ion-icon name="logo-facebook" style="font-size: 24px;"></ion-icon>
            </a>
            <a href="https://www.instagram.com" target="_blank" style="color: white; text-decoration: none; margin: 0 15px;">
                <ion-icon name="logo-instagram" style="font-size:24px;"></ion-icon>
            </a>
            <a href="mailto:example@gmail.com" style="color: white; text-decoration: none; margin: 0 15px;">
                <ion-icon name="mail-outline" style="font-size: 24px;"></ion-icon>
            </a>
            <a href="https://twitter.com" target="_blank" style="color: white; text-decoration: none; margin: 0 15px;">
                <ion-icon name="logo-twitter" style="font-size: 24px;"></ion-icon>
            </a>
        </div>

        <button id="goToTop" onclick="scrollToTop()" style="position: fixed; bottom: 20px; right: 20px; background-color: #f4f4f4; color: #1C2E5C; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; display: none;">
            ↑ Go to Top
        </button>
    </footer>

    <script>
 
        window.onscroll = function() {
            var button = document.getElementById("goToTop");
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                button.style.display = "block"; // Show the button when scrolled down
            } else {
                button.style.display = "none"; // Hide the button when at the top
            }
        };

        // Scroll to top function
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>




 
</body>

<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.5.4/dist/ionicons/ionicons.js"></script>

</html>
-->