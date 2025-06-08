<?php
session_start();
include '../Homepage/db_connect.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/vendor/autoload.php';

$repair_sql = "SELECT * FROM under_repair_books WHERE status = 'Under Repair' ORDER BY date_reported DESC";
$repair_result = mysqli_query($conn, $repair_sql);


$total_borrowed_sql = "SELECT COUNT(*) AS total FROM borrowed_books WHERE status = 'Borrowed'";
$total_borrowed_result = mysqli_query($conn, $total_borrowed_sql);
$total_borrowed = 0;
if ($total_borrowed_result && mysqli_num_rows($total_borrowed_result) > 0) {
    $row_total = mysqli_fetch_assoc($total_borrowed_result);
    $total_borrowed = $row_total['total'];
}

$repairedSuccess = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_repaired'])) {
    $repairId = intval($_POST['repair_id']);

    // First, get the book_id from under_repair_books
    $book_query = "SELECT book_id FROM under_repair_books WHERE repair_id = $repairId";
    $book_result = mysqli_query($conn, $book_query);

    if ($book_result && mysqli_num_rows($book_result) > 0) {
        $book_row = mysqli_fetch_assoc($book_result);
        $bookId = intval($book_row['book_id']);


        $update_sql = "UPDATE under_repair_books SET status = 'Repaired' WHERE repair_id = $repairId";
        $update_result = mysqli_query($conn, $update_sql);


        $stock_update_sql = "UPDATE tbl_books SET book_stocks = book_stocks + 1 WHERE book_id = $bookId";
        $stock_update_result = mysqli_query($conn, $stock_update_sql);

        if ($update_result && $stock_update_result) {
            $repairedSuccess = true;

            // Check for reservations for this book
            $res_stmt = $conn->prepare("SELECT * FROM reserved_books WHERE book_id = ? ORDER BY reserve_id ASC LIMIT 1");
            $res_stmt->bind_param("i", $bookId);
            $res_stmt->execute();
            $res_result = $res_stmt->get_result();

            if ($res_result->num_rows > 0) {
                $reservation = $res_result->fetch_assoc();

                // Fetch ISBN
                $isbn_stmt = $conn->prepare("SELECT book_title, ISBN FROM tbl_books WHERE book_id = ?");
                $isbn_stmt->bind_param("i", $bookId);
                $isbn_stmt->execute();
                $isbn_result = $isbn_stmt->get_result();
                $book_data = $isbn_result->fetch_assoc();

                $book_title = $book_data['book_title'];
                $isbn = $book_data['ISBN'];

                // Get max borrowing period
                $setting_query = $conn->prepare("SELECT setting_value FROM lms_settings WHERE setting_key = 'max_period days'");
                $setting_query->execute();
                $setting_result = $setting_query->get_result();
                $setting_row = $setting_result->fetch_assoc();
                $max_period_days = isset($setting_row['setting_value']) ? (int)$setting_row['setting_value'] : 7;

                $preferred_date = $reservation['preferred_date'];
                $due_date = date('Y-m-d', strtotime($preferred_date . " +$max_period_days days"));
                $now = date('Y-m-d H:i:s');
                $new_borrow_id = uniqid('BRW-');
                $handled_by = $_SESSION['username'] ?? 'System';

                // Insert into borrowed_books
                $insert_borrow = $conn->prepare("INSERT INTO borrowed_books 
        (borrow_id, student_no, first_name, last_name, email, contact, book_id, ISBN, book_title, preferred_date, due_date, status, update_datetime, updated_by)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Approved', ?, ?)");
                $insert_borrow->bind_param(
                    "ssssssissssss",
                    $new_borrow_id,
                    $reservation['student_no'],
                    $reservation['first_name'],
                    $reservation['last_name'],
                    $reservation['email'],
                    $reservation['contact'],
                    $bookId,
                    $isbn,
                    $book_title,
                    $preferred_date,
                    $due_date,
                    $now,
                    $handled_by
                );
                $insert_borrow->execute();

                // Delete from reserved_books
                $delete_res = $conn->prepare("DELETE FROM reserved_books WHERE reserve_id = ?");
                $delete_res->bind_param("i", $reservation['reserve_id']);
                $delete_res->execute();

                // Decrease book stock since it's auto-borrowed
                $dec_stock = $conn->prepare("UPDATE tbl_books SET book_stocks = book_stocks - 1 WHERE book_id = ?");
                $dec_stock->bind_param("i", $bookId);
                $dec_stock->execute();



                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'systemlibrarymanagement8@gmail.com';
                    $mail->Password = 'ndur otbh aalt vicl';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('no-reply@librasphere.com', 'LibraSphere Support');
                    $mail->addAddress($reservation['email'], $reservation['first_name'] . ' ' . $reservation['last_name']);
                    $mail->isHTML(true);
                    $mail->Subject = 'Reserved Book Now Available';
                    $mail->Body = "Hello {$reservation['first_name']},<br><br>
            Your reserved book <strong>{$book_title}</strong> has been repaired and is now available.<br>
            It has been automatically borrowed for you. Please pick it up by <strong>{$preferred_date}</strong>. 
            You have <strong>24 hours</strong> to claim it, or it will be automatically cancelled.<br><br>
            Thank you,<br>Library Team";

                    $mail->send();
                } catch (Exception $e) {
                    error_log("Mailer Error: " . $mail->ErrorInfo);
                }

                // Insert user notification
                $notif_msg = "Your reserved book '{$book_title}' has been repaired and auto-borrowed for you. Please claim it by {$preferred_date}.";
                $notif_type = "borrowed";

                $notif_stmt = $conn->prepare("INSERT INTO tbl_user_notifications (student_no, book_id, message, type, created_at, is_read)
        VALUES (?, ?, ?, ?, NOW(), 0)");
                $notif_stmt->bind_param("siss", $reservation['student_no'], $bookId, $notif_msg, $notif_type);
                $notif_stmt->execute();
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Manage Under Repair Books</title>
    <link rel="icon" type="image/png" href="../logosample1.png">
    <link rel='stylesheet' href="LIBRARIAN_NOTIFICATIONS.CSS">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>


    <div class="page-header">
        <h2>Under Repair Books</h2>
        <p class="page-subtitle">Manage & Update Damaged Books</p>

        <div class="search-bar-container">
            <div class="search-input-wrapper">
                <input type="text" id="searchInput" placeholder="Search damaged books..." />
                <ion-icon name="search-outline" class="search-icon"></ion-icon>
            </div>
        </div>

    </div>
    <div class="notifications-container">


        <div id="borrow" class="tab-content active-tab">
            <table>
                <thead>
                    <tr>
                        <th>BOOK COVER</th>
                        <th>BOOK ID </th>
                        <th>BOOK TITLE </th>
                        <th>BOOK AUTHOR</th>
                        <th>DATE REPORTED</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if ($repair_result && mysqli_num_rows($repair_result) > 0) {
                        while ($row = mysqli_fetch_assoc($repair_result)) {
                            $imageURL = htmlspecialchars($row['book_cover']);
                            $bookTitle = htmlspecialchars($row['book_title']);
                            $author = htmlspecialchars($row['book_author']);
                            $repairId = $row['repair_id'];

                            echo "<tr>
            <td class='book-icon-cell'>
                <img src='{$imageURL}' alt='Cover' style='height: 60px; width: auto;' />
            </td>
            <td>{$row['book_id']}</td>
            <td>{$bookTitle}</td>
            <td>{$author}</td>
            <td>{$row['date_reported']}</td>
            <td>{$row['status']}</td>
            <td class='action-icons'>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='repair_id' value='{$repairId}'>
                    <button type='submit' name='mark_repaired' style='
                        padding: 6px 12px; 
                        background-color: #28a745; 
                        color: white; 
                        border: none; 
                        border-radius: 4px; 
                        cursor: pointer; 
                        display: inline-flex; 
                        align-items: center; 
                        gap: 6px;
                        font-size: 14px;
                    ' title='Mark as Repaired'>
                        <ion-icon name='checkmark-done-outline' style='font-size: 18px;'></ion-icon>
                        Repaired
                    </button>
                </form>
            </td>
        </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center; color:#666; font-style: italic;'>No books under repair found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>


            <div class="pagination-container">
               
                <button id="prevPage" class="styled-btn">Previous</button>
                <span id="pageIndicator">Page 1</span>
                <button id="nextPage" class="styled-btn">Next</button>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                <?php if ($repairedSuccess): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Book Updated',
                        text: 'The book has been successfully marked as repaired.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'UNDER_REPAIRED_BOOKS.PHP';
                    });
                <?php endif; ?>
            });
        </script>

</body>

</html>