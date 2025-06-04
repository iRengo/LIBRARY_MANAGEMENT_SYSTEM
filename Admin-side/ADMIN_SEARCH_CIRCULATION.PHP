<?php
include '../homepage/db_connect.php'; 

$search = mysqli_real_escape_string($conn, $_POST['query'] ?? '');

$sql = "SELECT * FROM borrowed_books 
        WHERE 
            book_title LIKE '%$search%' OR 
            first_name LIKE '%$search%' OR 
            last_name LIKE '%$search%' OR 
            status LIKE '%$search%' OR 
            preferred_date LIKE '%$search%' OR 
            due_date LIKE '%$search%'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $username = $row['first_name'] . ' ' . $row['last_name'];
        echo '<tr>
            <td>' . htmlspecialchars($row['book_title']) . '</td>
            <td>' . htmlspecialchars($username) . '</td>
            <td>' . htmlspecialchars($row['preferred_date']) . '</td>
            <td>' . htmlspecialchars($row['due_date']) . '</td>
            <td>' . htmlspecialchars($row['status']) . '</td>
            <td>' . htmlspecialchars($row['update_datetime']) . '</td>
        </tr>';
    }
} else {
    echo '<tr><td colspan="6">No matching records found.</td></tr>';
}
?>
