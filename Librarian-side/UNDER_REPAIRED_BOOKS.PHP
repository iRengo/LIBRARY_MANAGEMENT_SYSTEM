<?php
session_start();
include '../Homepage/db_connect.php';

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
                <div class="total-borrowed-text">
                    Total Borrowed: <?php echo $total_borrowed; ?>
                </div>
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