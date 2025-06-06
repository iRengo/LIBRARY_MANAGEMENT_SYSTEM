<?php
session_start();
include '../Homepage/db_connect.php';

$borrow_sql = "SELECT bb.*, b.book_cover 
    FROM borrowed_books bb
    JOIN tbl_books b ON bb.book_id = b.book_id
    WHERE bb.status = 'Pending'
    ORDER BY bb.borrow_id DESC";

$borrow_result = mysqli_query($conn, $borrow_sql);


$pendingCount = 0;
if (isset($conn)) {
    $countSql = "SELECT COUNT(*) as total_pending FROM borrowed_books WHERE status = 'Pending'";
    $countResult = mysqli_query($conn, $countSql);
    if ($countResult && $row = mysqli_fetch_assoc($countResult)) {
        $pendingCount = $row['total_pending'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> LIBRARIAN BORROW REQUEST</title>
    <link rel='stylesheet' href="LIBRARIAN_NOTIFICATIONS.CSS">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>


    <div class="page-header">
        <h2>Student Pending Requests</h2>
        <p class="page-subtitle">Manage pending borrow requests efficiently.</p>

        <div class="search-bar-container">
            <div class="search-input-wrapper">
                <input type="text" id="searchInput" placeholder="Search borrowed books..." />
                <ion-icon name="search-outline" class="search-icon"></ion-icon>
            </div>
        </div>
    </div>



    <div class="notifications-container">
        <div id="borrow" class="tab-content active-tab">
            <table>
                <thead>
                    <tr>
                        <th>Cover</th>
                        <th>Borrow ID</th>
                        <th>Student No</th>
                        <th>Book Title</th>
                        <th>Preferred Date</th>
                        <th>Status</th>
                        <!-- <th>Actions</th> -->
                    </tr>
                </thead>

                <?php
$borrow_sql = "SELECT bb.*, b.book_cover, b.book_author, b.book_title 
               FROM borrowed_books bb
               JOIN tbl_books b ON bb.book_id = b.book_id
               WHERE bb.status = 'Pending'
               ORDER BY bb.borrow_id DESC";

$borrow_result = mysqli_query($conn, $borrow_sql);

if ($borrow_result && mysqli_num_rows($borrow_result) > 0) {
    while ($row = mysqli_fetch_assoc($borrow_result)) {
        $imageURL = htmlspecialchars($row['book_cover']);
        $bookTitle = htmlspecialchars($row['book_title']);
        $author = htmlspecialchars($row['book_author']);
        $borrowId = $row['borrow_id'];
        $studentNo = $row['student_no'];
        $email = $row['email'];
        $contact = $row['contact'];
        $preferredDate = $row['preferred_date'];
        $status = $row['status'];

        echo <<<HTML
<tr>
    <td class='book-icon-cell'>
        <button 
            class='book-details-btn' 
            data-title="{$bookTitle}" 
            data-author="{$author}" 
            data-cover="{$imageURL}" 
            style='background:none; border:none; cursor:pointer; font-size: 24px; color:#1C2E5C;' 
            title='View Book Details'>
            <ion-icon name='book-outline'></ion-icon>
        </button>
    </td>
    <td>{$borrowId}</td>
    <td>{$studentNo}</td>
    <td>{$bookTitle}</td>
    <td>{$preferredDate}</td>
    <td>{$status}</td>
    <td class='action-icons'>
        <!-- <ion-icon 
            name='checkmark-circle-outline' 
            class='accept' 
            onclick='acceptRequest({$borrowId})' 
            style='cursor:pointer; font-size:18px; color:green;'>
        </ion-icon>

        <ion-icon 
            name='close-circle-outline' 
            class='decline' 
            onclick='declineRequest(
                {$borrowId}, 
                "{$studentNo}", 
                "{$email}", 
                "{$bookTitle}", 
                "{$contact}", 
                "{$preferredDate}"
            )' 
            style='cursor:pointer; font-size:18px; color:red;'>
        </ion-icon> -->
    </td>
</tr>
HTML;
    }
} else {
    echo "<tr id='noDataRow'><td colspan='7' style='text-align:center; color:#666; font-style: italic;'>No borrow requests found.</td></tr>";
}
?>



                <tr id="noResultsRow" style="display:none;">
                    <td colspan="7" style="text-align:center; color:#666; font-style: italic;">No more Data's to show.</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="pagination-container">
            <div class="total-borrowed-text">
                Total Requests: <?php echo $pendingCount; ?>
            </div>
            <button id="prevPage" class="styled-btn">Previous</button>
            <span id="pageIndicator">Page 1</span>
            <button id="nextPage" class="styled-btn">Next</button>
        </div>



        <script>
            function declineRequest(borrow_id, student_no, email, title, contact, preferred_date) {
                Swal.fire({
                    title: 'Reason for Decline',
                    input: 'text',
                    inputLabel: 'Enter reason',
                    showCancelButton: true,
                    inputValidator: (value) => {
                        if (!value) return 'You must provide a reason!';
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const reason = result.value;
                        const formData = new URLSearchParams();
                        formData.append('action', 'decline');
                        formData.append('borrow_id', borrow_id);
                        formData.append('student_no', student_no);
                        formData.append('email', email);
                        formData.append('title', title);
                        formData.append('contact', contact);
                        formData.append('preferred_date', preferred_date);
                        formData.append('status', 'Declined');
                        formData.append('reason', reason);

                        fetch('LIBRARIAN_BORROW_ACTION.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: formData
                            })
                            .then(res => res.text())
                            .then(data => {
                                Swal.fire('Declined', 'Request declined and logged.', 'info').then(() => location.reload());
                            });
                    }
                });
            }

            function acceptRequest(borrowId) {
                fetch('LIBRARIAN_BORROW_ACTION.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'action=accept&borrow_id=' + borrowId
                    })
                    .then(res => res.text())
                    .then(data => {
                        Swal.fire('Accepted!', 'Borrow request accepted.', 'success').then(() => location.reload());
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