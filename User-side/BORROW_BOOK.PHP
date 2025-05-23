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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $form_type = $_POST['form_type'] ?? 'borrow'; // Default to borrow

    // Common fields
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
    $acc_no = $_SESSION['acc_no'] ?? null;

    if (!$student_no || !$book_id || !$book_title || !$preferred_date) {
        echo '<script>
            alert("Error: Missing required fields. Please try again.");
            window.location.href = "book-details.php?book_id=' . htmlspecialchars($book_id) . '";
        </script>';
        exit();
    }

    if ($form_type === "reserve") {
        // === RESERVE LOGIC ===
        $check_sql = "SELECT * FROM reserved_books WHERE book_id = ? AND student_no = ?";
        $stmt_check = $conn->prepare($check_sql);
        $stmt_check->bind_param("ii", $book_id, $student_no);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // Already reserved
            echo '<script>
                alert("You have already reserved this book.");
                window.location.href = "book-details.php?book_id=' . htmlspecialchars($book_id) . '";
            </script>';
            exit();
        }

        $insert_sql = "INSERT INTO reserved_books 
            (student_no, first_name, last_name, email, contact, book_id, ISBN, book_title, preferred_date, due_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("issssissss", $student_no, $first_name, $last_name, $email, $contact, $book_id, $ISBN, $book_title, $preferred_date, $due_date);

        if ($stmt->execute()) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
            window.onload = function() {
                Swal.fire({
                    title: "Reserved!",
                    text: "Your reservation request has been submitted.",
                    icon: "success",
                    confirmButtonText: "OK",
                    backdrop: "rgba(187, 184, 184, 0.4)" 
                }).then(() => {
                    window.location.href = "book-details.php?book_id=' . htmlspecialchars($book_id) . '";
                });
            }
            </script>';
        } else {
            echo '<script>alert("Reservation failed: ' . $stmt->error . '");</script>';
        }

        $stmt->close();
        $stmt_check->close();

    } else {
        // === BORROW LOGIC ===
        $borrow_date = date('Y-m-d');
        $status = "Pending";

        $insert_query = "INSERT INTO borrowed_books 
            (student_no, first_name, last_name, email, contact, book_id, ISBN, book_title, preferred_date, due_date, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sssssssssss", $student_no, $first_name, $last_name, $email, $contact, $book_id, $ISBN, $book_title, $preferred_date, $due_date, $status);

        if ($stmt->execute()) {
            // Decrease book stock
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
        } else {
            echo '<script>alert("Borrowing failed: ' . $stmt->error . '");</script>';
        }

        $stmt->close();
    }

    $conn->close();
}
?>
