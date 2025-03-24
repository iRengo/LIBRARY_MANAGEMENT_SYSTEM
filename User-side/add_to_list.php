<?php
session_start();
$servername = "localhost";
$username = "root"; // Change if needed
$password = "";     // Change if needed
$dbname = "db_library_management_system"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['acc_no'])) {
    die("Access Denied. Please log in.");
}

$acc_no = $_SESSION['acc_no']; // Get logged-in user's acc_no

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST); // Debugging: Check received data

    if (!isset($_POST['book_title'])) {
        die("Missing book title.");
    }

    $book_title = $_POST['book_title'];
    $action = $_POST['action'];

    if ($action === "reserve") {
        $reservation_date = date("Y-m-d"); // Capture the reservation date

        // Insert into reserved_books
        $sql_reserved = "INSERT INTO reserved_books (acc_no, book_title) VALUES (?, ?)";
        $stmt_reserved = $conn->prepare($sql_reserved);
        $stmt_reserved->bind_param("is", $acc_no, $book_title);

        // Insert into reservation_history
        $sql_history = "INSERT INTO reservation_history (acc_no, book_title, reservation_date) 
                        VALUES (?, ?, ?)";
        $stmt_history = $conn->prepare($sql_history);
        $stmt_history->bind_param("iss", $acc_no, $book_title, $reservation_date);

        $stmt_reserved->close();
        $stmt_history->close();
    }
}

$conn->close();
?>
