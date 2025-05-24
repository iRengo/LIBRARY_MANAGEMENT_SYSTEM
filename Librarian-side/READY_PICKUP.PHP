<?php
session_start();
include '../Homepage/db_connect.php';
$pickup_sql = "SELECT bb.*, b.book_cover, book_author
                FROM borrowed_books bb
                JOIN tbl_books b ON bb.book_id = b.book_id
                WHERE bb.status = 'Approved'
                ORDER BY bb.borrow_id DESC";

$pickup_result = mysqli_query($conn, $pickup_sql);

$readyToPickup = 0;
if (isset($conn)) {
    $countSql = "SELECT COUNT(*) as total_approved FROM borrowed_books WHERE status = 'Approved'";
    $countResult = mysqli_query($conn, $countSql);
    if ($countResult && $row = mysqli_fetch_assoc($countResult)) {
        $readyToPickup = $row['total_approved'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> LIBRARIAN Ready To Pickup</title>
    <link rel='stylesheet' href="LIBRARIAN_NOTIFICATIONS.CSS">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>


    <div class="page-header">
        <h2>Ready to Pickup Books</h2>
        <p class="page-subtitle">List of books ready to Pickup</p>

        <div class="search-bar-container">
            <div class="search-input-wrapper">
                <input type="text" id="searchInput" placeholder="Search borrowed books..." />
                <ion-icon name="search-outline" class="search-icon"></ion-icon>
            </div>
        </div>

    </div>


    <div class="notifications-container">
        <div id="pickup" class="tab-content">
            <table>
                <thead>
                    <tr>
                        <th>Book Cover</th>
                        <th>Borrow ID</th>
                        <th>Student No</th>
                        <th>Book Title</th>
                        <th>Preferred Date</th>
                        <th>Pickup Deadline</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($pickup_result && mysqli_num_rows($pickup_result) > 0) {
                        while ($row = mysqli_fetch_assoc($pickup_result)) {
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
                        <td>{$row['borrow_id']}</td>
                        <td>{$row['student_no']}</td>
                        <td>{$row['book_title']}</td>
                        <td>{$row['preferred_date']}</td>
                        <td>Within 24 hours</td>
                        <td>{$row['status']}</td>
                        <td>
    <button onclick='markAsPickedUp({$row['borrow_id']})' style='padding: 6px 12px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 20px; display: flex; align-items: center; justify-content: center;'>
        <ion-icon name='checkmark-done-outline'></ion-icon>
    </button>
</td>

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
                Total Borrowed: <?php echo $readyToPickup; ?>
            </div>
            <button id="prevPage" class="styled-btn">Previous</button>
            <span id="pageIndicator">Page 1</span>
            <button id="nextPage" class="styled-btn">Next</button>
        </div>
        <script>
            function markAsPickedUp(borrowId) {
                fetch('LIBRARIAN_BORROW_ACTION.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'action=mark_borrowed&borrow_id=' + borrowId
                    })
                    .then(res => res.text())
                    .then(data => {
                        Swal.fire('Success', 'Book Successfully Borrowed.', 'success').then(() => location.reload());
                    });
            }

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