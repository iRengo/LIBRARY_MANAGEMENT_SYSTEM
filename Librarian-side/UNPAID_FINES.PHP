<?php
session_start();
include '../Homepage/db_connect.php';

$loggedInUser = $_SESSION['librarian_no'];

$fines_sql = "
    SELECT 
        sf.student_no,
        b.book_title,
        b.book_cover,
        b.book_author,
        f.fine_name,
        f.price AS fine_amount,
        sf.status,
        sf.fine_id,
        sf.proof
    FROM student_fines sf
    LEFT JOIN tbl_books b ON sf.book_id = b.book_id
    LEFT JOIN fines_table f ON sf.fine_id = f.fine_id
    WHERE sf.status = 'unpaid'
    ORDER BY sf.fine_id DESC
";


$fines_result = mysqli_query($conn, $fines_sql);

$total_unpaid = $fines_result ? mysqli_num_rows($fines_result) : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> LIBRARIAN RESERVED REQUEST</title>
    <link rel='stylesheet' href="LIBRARIAN_NOTIFICATIONS.CSS">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>

    <div class="page-header">
        <h2>Student Unpaid Fines</h2>
        <p class="page-subtitle">List of books currently borrowed by students</p>

        <div class="search-bar-container">
            <div class="search-input-wrapper">
                <input type="text" id="searchInput" placeholder="Search borrowed books..." />
                <ion-icon name="search-outline" class="search-icon"></ion-icon>
            </div>
        </div>

    </div>
    <div class="notifications-container">


        <div id="unpaid" class="tab-content">
            <table>
                <thead>
                    <tr>
                        <th>Book Cover </th>
                        <th>Student No</th>
                        <th>Book Title</th>
                        <th>Reason</th>
                        <th>Fine Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    if ($fines_result && mysqli_num_rows($fines_result) > 0) {
                        while ($fine = mysqli_fetch_assoc($fines_result)) {
                            $imageURL = $fine['book_cover'];
                            $bookTitle =$fine['book_title'];
                            $author = $fine['book_author'];
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
            <td>{$fine['student_no']}</td>
            <td>{$fine['book_title']}</td>
            <td>{$fine['fine_name']}</td>
            <td>₱{$fine['fine_amount']}</td>
            <td style='color: red; font-weight: bold;'>{$fine['status']}</td>
            <td>
            <button onclick=\"markFineAsPaid({$fine['fine_id']})\" style='background: green; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;'>Mark as Paid</button>
            <button onclick=\"viewProofImage('{$fine['proof']}')\" style='background: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-left: 5px;'>View</button>
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
                Total Unpaid: <?php echo $total_unpaid; ?>
            </div>
            <button id="prevPage" class="styled-btn">Previous</button>
            <span id="pageIndicator">Page 1</span>
            <button id="nextPage" class="styled-btn">Next</button>
        </div>


        <script>
            function markFineAsPaid(fineId) {
                Swal.fire({
                    title: "Confirm Payment?",
                    text: "Are you sure this fine has been paid?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, mark as paid"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData();
                        formData.append('fine_id', fineId); // FIXED: now using fine_id

                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'LIBRARIAN_MARK_PAID.PHP', true);
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                console.log(xhr.responseText);
                                if (xhr.responseText.includes("Fine marked as paid")) {
                                    Swal.fire("Updated!", "Fine has been marked as paid.", "success").then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire("Error!", xhr.responseText, "error");
                                }
                            }
                        };
                        xhr.send(formData);
                    }
                });
            }

            function viewProofImage(imageFile) {
                if (imageFile) {
                    Swal.fire({
                        title: 'Proof Image',
                        imageUrl: '../public/proofs/' + imageFile,
                        imageAlt: 'Proof Image',
                        width: 600,
                        imageWidth: 500,
                        imageHeight: 400,
                        confirmButtonText: 'Close'
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'No proof available',
                        text: 'There is no proof image uploaded for this fine.'
                    });
                }
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