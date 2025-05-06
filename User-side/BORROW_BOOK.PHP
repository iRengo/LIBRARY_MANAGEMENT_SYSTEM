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
    $preferred_date = $_POST['preferred_date'] ?? null;
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
    $insert_query = "INSERT INTO borrowed_books 
(student_no, first_name, last_name, email, contact, book_id, ISBN, book_title, preferred_date, due_date, status)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($insert_query);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $acc_no = $_SESSION['acc_no'];
    $reserved_date = date('Y-m-d'); // Current date for reservation
    $status = "Pending"; // Assuming default status

    $stmt->bind_param(
        "sssssssssss",
        $student_no,
        $first_name,
        $last_name,
        $email,
        $contact,
        $book_id,
        $ISBN,
        $book_title,
        $preferred_date,
        $due_date,
        $status
    );
    if ($stmt->execute()) {
        // Decrease book stock by 1
        $update_stock = $conn->prepare("UPDATE tbl_books SET book_stocks = book_stocks - 1 WHERE book_id = ?");
        $update_stock->bind_param("i", $book_id);
        $update_stock->execute();
        $update_stock->close();

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
                window.location.href = "book-details.php?book_id=' . htmlspecialchars($book_id) . '";
            });
        }
        </script>';
    } 

    $stmt->close();
    $conn->close();
}
