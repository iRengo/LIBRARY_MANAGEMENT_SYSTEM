<?php
include '../Homepage/db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Handle category update or delete
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'update_category' && isset($_POST['old_category'], $_POST['new_category'])) {
            $old = $conn->real_escape_string($_POST['old_category']);
            $new = $conn->real_escape_string($_POST['new_category']);

            $conn->query("UPDATE tbl_books SET book_category = '$new' WHERE book_category = '$old'");
            echo "updated";
            exit();

        } elseif ($action === 'delete_category' && isset($_POST['category'])) {
            $category = $conn->real_escape_string($_POST['category']);

            $conn->query("
                DELETE rb FROM returned_books rb
                JOIN tbl_books b ON rb.book_id = b.book_id
                WHERE b.book_category = '$category'
            ");

            $conn->query("
                DELETE bb FROM borrowed_books bb
                JOIN tbl_books b ON bb.book_id = b.book_id
                WHERE b.book_category = '$category'
            ");

            $conn->query("DELETE FROM tbl_books WHERE book_category = '$category'");

            echo "deleted";
            exit();
        }
    }

    // === Librarian Permissions Update ===
    if (isset($_POST['setting_4']) || isset($_POST['setting_5'])) {
        if (isset($_POST['setting_4'])) {
            $value4 = intval($_POST['setting_4']);
            $conn->query("UPDATE lms_settings SET setting_value = '$value4' WHERE setting_id = 4");
        }

        if (isset($_POST['setting_5'])) {
            $value5 = intval($_POST['setting_5']);
            $conn->query("UPDATE lms_settings SET setting_value = '$value5' WHERE setting_id = 5");
        }

        $_SESSION['success'] = "Librarian permissions updated successfully!";
        header("Location: admin_settings.php");
        exit();
    }

    // === General Settings Update ===
    if (isset($_POST['max_books']) && isset($_POST['borrow_duration']) && isset($_POST['fine_per_day'])) {
        $max_books = $conn->real_escape_string($_POST['max_books']);
        $borrow_duration = $conn->real_escape_string($_POST['borrow_duration']);
        $fine_per_day = $conn->real_escape_string($_POST['fine_per_day']);

        $conn->query("UPDATE lms_settings SET setting_value = '$max_books' WHERE setting_key = 'max_books_per_user'");
        $conn->query("UPDATE lms_settings SET setting_value = '$borrow_duration' WHERE setting_key = 'borrowing_period_days'");
        $conn->query("UPDATE lms_settings SET setting_value = '$fine_per_day' WHERE setting_key = 'overdue_fine'");

        $_SESSION['success'] = "General settings updated successfully!";
        header("Location: admin_settings.php");
        exit();
    }

    // If no known action matched
    $_SESSION['error'] = "No settings were updated.";
    header("Location: admin_settings.php");
    exit();
}
?>
