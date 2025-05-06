<?php

session_start();
include '../homepage/db_connect.php';

if (!isset($_SESSION['acc_no'])) {
    echo '<script>
        alert("You are not logged in!");
        window.location.href = "../homepage/homepage.php";
    </script>';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_no = $_POST['student_no'] ?? null;
    $first_name = $_POST['first_name'] ?? null;
    $last_name = $_POST['last_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $contact = $_POST['contact'] ?? null;
    $book_id = $_POST['book_id'] ?? null;
    $ISBN = $_POST['isbn'] ?? null;
    $book_title = $_POST['book_title'] ?? null;
    $preferred_date = $_POST['borrow_date'] ?? null;
    $due_date = $_POST['due_date'] ?? null;
    $status = "Pending";
    $acc_no = $_SESSION['acc_no'];
    $author = $_POST['author'] ?? 'Unknown'; // Make sure to pass author too

    // Validate required fields
    if (!$student_no || !$book_id || !$book_title || !$preferred_date) {
        echo '<script>
            alert("Error: Missing required fields. Please try again.");
            window.location.href = "book-details.php?book_id=' . htmlspecialchars($book_id) . '";
        </script>';
        exit();
    }

// Insert into `reserved_books` table
$insert_query = "INSERT INTO reserved_books 
(book_title, author, reserved_date, status, acc_no, book_id, student_no, first_name, last_name, ISBN, borrow_date, due_date, email)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($insert_query);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$acc_no = $_SESSION['acc_no'];
$reserved_date = date('Y-m-d'); // Current date for reservation
$status = "Pending"; // Assuming default status

$stmt->bind_param(
    "sssssssssssss",
    $book_title,        // 1
    $author,            // 2
    $reserved_date,     // 3
    $status,            // 4
    $acc_no,            // 5
    $book_id,           // 6
    $student_no,        // 7
    $first_name,        // 8
    $last_name,         // 9
    $ISBN,              // 10
    $preferred_date,    // 11
    $due_date,          // 12
    $email              // 13
);

    if ($stmt->execute()) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
            window.onload = function() {
                Swal.fire({
                    title: "Success!",
                    text: "Your borrowing request has been submitted. Please wait for approval.",
                    icon: "success",
                    confirmButtonText: "OK",
                    backdrop: "rgba(187, 184, 184, 0.4)" 
                }).then(() => {
                    window.location.href = "user_catalog.php";
                });
            }
            </script>';
    } else {
        echo '<script>
            alert("Error submitting request: ' . $stmt->error . '");
            window.location.href = "book-details.php?book_id=' . htmlspecialchars($book_id) . '";
        </script>';
    }

    $stmt->close();
    $conn->close();
}
