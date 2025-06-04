<?php
include '../homepage/db_connect.php'; // adjust if needed

if (isset($_POST['inventory_search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['inventory_search']);

    $sql = "SELECT book_id, book_title, book_author, book_stocks, ISBN, book_category, publisher 
            FROM tbl_books 
            WHERE 
                book_title LIKE '%$search%' OR 
                book_author LIKE '%$search%' OR 
                ISBN LIKE '%$search%' OR 
                book_category LIKE '%$search%' OR 
                publisher LIKE '%$search%'";

    $fetch_book = mysqli_query($conn, $sql);

    if (mysqli_num_rows($fetch_book) > 0) {
        while ($row = mysqli_fetch_assoc($fetch_book)) {
            echo '<tr>
                <td>' . htmlspecialchars($row['ISBN']) . '</td>
                <td>' . htmlspecialchars($row['book_title']) . '</td>
                <td>' . htmlspecialchars($row['book_author']) . '</td>
                <td>' . intval($row['book_stocks']) . '</td>
                <td>' . htmlspecialchars($row['book_category']) . '</td>
                <td>' . htmlspecialchars($row['publisher']) . '</td>
                
            </tr>';
        }
    } else {
        echo '<tr><td colspan="7">No matching books found.</td></tr>';
    }
}
?>
