<?php
session_start();
include '../Homepage/db_connect.php';

$returned_sql = "SELECT rb.*, b.book_cover, book_author
                 FROM returned_books rb
                 JOIN tbl_books b ON rb.book_id = b.book_id
                 ORDER BY rb.return_date DESC";

$returned_result = mysqli_query($conn, $returned_sql);
$total_returned = $returned_result ? mysqli_num_rows($returned_result) : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Manage Returned Books</title>
    <link rel="icon" type="image/png" href="../logosample1.png">
    <link rel='stylesheet' href="LIBRARIAN_NOTIFICATIONS.CSS">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>

    <div class="page-header">
        <h2>Student Returned Books</h2>
        <p class="page-subtitle">List of books returned by students</p>

        <div class="search-bar-container">
            <div class="search-input-wrapper">
                <input type="text" id="searchInput" placeholder="Search borrowed books..." />
                <ion-icon name="search-outline" class="search-icon"></ion-icon>
            </div>
        </div>

    </div>

    <div class="notifications-container">


        <div id="returned">
            <table>
                <thead>
                    <tr>
                        <th>Book Cover</th>
                        <th>Return ID</th>
                        <th>Borrow ID</th>
                        <th>Student No</th>
                        <th>Book Title</th>
                        <th>Return Date</th>
                        <th>Book Condition</th>
                        <th>Handled By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($returned_result && mysqli_num_rows($returned_result) > 0) {
                        while ($row = mysqli_fetch_assoc($returned_result)) {
                            $imageURL = $row['book_cover'];
                            $bookTitle = htmlspecialchars($row['book_title']);
                            $author = htmlspecialchars($row['book_author']);

                            echo "<tr>
                        <td class='book-icon-cell'>
                        <button 
                            class='book-details-btn' 
                            data-title='{$bookTitle}' 
                            data-author='{$author}' 
                            data-cover='{$imageURL}' 
                            style='background:none; border:none; cursor:pointer; font-size: 24px; color:#1C2E5C;' 
                            title='View Book Details'>
                            <ion-icon name='book-outline'></ion-icon>
                        </button>
                    </td>
                        <td>{$row['return_id']}</td>
                        <td>{$row['borrow_id']}</td>
                        <td>{$row['student_no']}</td>
                        <td>{$row['book_title']}</td>
                        <td>{$row['return_date']}</td>
                        <td>{$row['book_condition']}</td>
                        <td>{$row['handled_by']}</td>
                    </tr>";
                        }
                    } else {

                        echo "<tr id='noDataRow'><td colspan='8' style='text-align:center; color:#666; font-style: italic;'>No borrow requests found.</td></tr>";
                    }
                    ?>


                    <tr id="noResultsRow" style="display:none;">
                        <td colspan="8" style="text-align:center; color:#666; font-style: italic;">No more Data's to show.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            <div class="total-borrowed-text">
                Total Returned: <?php echo $total_returned; ?>
            </div>
            <button id="prevPage" class="styled-btn">Previous</button>
            <span id="pageIndicator">Page 1</span>
            <button id="nextPage" class="styled-btn">Next</button>
        </div>

        <script>
            document.querySelectorAll('.book-details-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const title = btn.getAttribute('data-title');
                    const author = btn.getAttribute('data-author');
                    const cover = btn.getAttribute('data-cover');

                    Swal.fire({
                        title: title,
                        html: `<p><strong>Author:</strong> ${author}</p>`,
                        imageUrl: cover,
                        imageAlt: `Cover of ${title}`,
                        imageWidth: 300,
                        imageHeight: 400,
                        confirmButtonText: 'Close',
                        customClass: {
                            popup: 'swal2-border-radius'
                        }
                    });
                });
            });



            const rowsPerPage = 4;
            let currentPage = 1;

            function filterTable() {
                const input = document.getElementById('searchInput').value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr:not(#noResultsRow):not(#noDataRow)');
                let visibleRows = 0;

                rows.forEach(row => {
                    const rowText = row.innerText.toLowerCase();
                    const isMatch = rowText.includes(input);
                    row.style.display = isMatch ? '' : 'none';
                    row.setAttribute('data-visible', isMatch ? 'true' : 'false');
                    if (isMatch) visibleRows++;
                });

                // Show or hide the "No results found" row
                const noResultsRow = document.getElementById('noResultsRow');
                noResultsRow.style.display = visibleRows === 0 ? '' : 'none';

                // Reset to page 1 when filtering
                currentPage = 1;
                paginateTable(); // reset pagination after search
            }


            function paginateTable() {
                const rows = document.querySelectorAll('tbody tr[data-visible="true"]');
                const totalRows = rows.length;
                const startIndex = (currentPage - 1) * rowsPerPage;
                const endIndex = startIndex + rowsPerPage;

                rows.forEach((row, index) => {
                    row.style.display = index >= startIndex && index < endIndex ? '' : 'none';
                });

                document.getElementById('pageIndicator').innerText = `Page ${currentPage}`;
                document.getElementById('prevPage').disabled = currentPage === 1;
                document.getElementById('nextPage').disabled = endIndex >= totalRows;
            }

            document.getElementById('searchInput').addEventListener('input', () => {
                currentPage = 1;
                filterTable();
            });

            document.getElementById('prevPage').addEventListener('click', () => {
                currentPage--;
                paginateTable();
            });

            document.getElementById('nextPage').addEventListener('click', () => {
                currentPage++;
                paginateTable();
            });

            // On initial load
            document.querySelectorAll('tbody tr').forEach(tr => tr.setAttribute('data-visible', 'true'));
            paginateTable();
        </script>
</body>

</html>