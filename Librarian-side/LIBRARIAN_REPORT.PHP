<?php 
session_start();
include '../homepage/db_connect.php' 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Librarian Report </title>
    <link rel="stylesheet" href="LIBRARIAN_REPORT.CSS">



</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP' ?>
    <!-- Content HERE -->
<div class="receipt-container">
    <h2>LIBRARY FINE RECEIPT</h2>
    <form class="receipt-form">
        <div class="form-row">
            <div class="form-group">
                <label>Borrower Name:</label>
                <input type="text" name="borrower_name">
            </div>
            <div class="form-group">
                <label>Borrower ID:</label>
                <input type="number" name="borrower_id">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Book Title:</label>
                <input type="text" name="book_title">
            </div>
            <div class="form-group">
                <label>Book ID:</label>
                <input type="number" name="book_id">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Check Out Date:</label>
                <input type="date" name="checkout_date">
            </div>
            <div class="form-group">
                <label>Due Date:</label>
                <input type="date" name="due_date">
            </div>
            <div class="form-group">
                <label>Date Returned:</label>
                <input type="date" name="date_returned">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Book Condition: Damaged/Lost</label>
                <select name="book_condition">
                    <option value="Damaged">Damaged</option>
                    <option value="Lost">Lost</option>
                </select>
            </div>
            <div class="form-group">
                <label>Book overdue by day:</label>
                <input type="number" name="overdue_days">
            </div>
            <div class="form-group">
                <label>Total Amount:</label>
                <input type="number" name="total_amount">
            </div>
        </div>
    </form>
</div>


    <!-- Content HERE -->
</body>

</html>