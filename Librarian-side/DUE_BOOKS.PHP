<?php
session_start();
include '../Homepage/db_connect.php';
$today = date('Y-m-d');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> LIBRARIAN DUE BOOKS</title>
    <link rel='stylesheet' href="LIBRARIAN_NOTIFICATIONS.CSS">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>

    <div class="page-header">
        <h2>Student due Books</h2>
        <p class="page-subtitle">List of books due today</p>

        <div class="search-bar-container">
            <div class="search-input-wrapper">
                <input type="text" id="searchInput" placeholder="Search borrowed books..." />
                <ion-icon name="search-outline" class="search-icon"></ion-icon>
            </div>
        </div>

    </div>
    <div class="notifications-container">

        <div id="due">
            <table>
                <thead>
                    <tr>
                        <th>Book Cover</th>
                        <th>Borrow ID</th>
                        <th>Student No</th>
                        <th>Book Title</th>
                        <th>Borrowed Date</th>
                        <th>Due Date</th>
                        <th>Action </th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $due_sql = "SELECT bb.*, b.book_cover, book_author
            FROM borrowed_books bb
            JOIN tbl_books b ON bb.book_id = b.book_id
            WHERE bb.status = 'Borrowed' AND bb.due_date = '$today'
            ORDER BY bb.due_date ASC";
                    $due_result = mysqli_query($conn, $due_sql);

                    $total_due = $due_result ? mysqli_num_rows($due_result) : 0;
                    if ($due_result && mysqli_num_rows($due_result) > 0) {
                        while ($row = mysqli_fetch_assoc($due_result)) {
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
                        <td style='color: orange; font-weight: bold;'>{$row['due_date']}</td>
                       <td> <button class='return-btn' 
    data-borrow-id='{$row['borrow_id']}'
    data-student-no='{$row['student_no']}'
    data-book-id='{$row['book_id']}'
    data-book-title='{$row['book_title']}'
> 
<ion-icon name='arrow-undo-outline' style='font-size: 18px; vertical-align: middle;'></ion-icon>
Returned</button> </td>
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
                Total due: <?php echo $total_due; ?>
            </div>
            <button id="prevPage" class="styled-btn">Previous</button>
            <span id="pageIndicator">Page 1</span>
            <button id="nextPage" class="styled-btn">Next</button>
        </div>


        <script>
            document.addEventListener("DOMContentLoaded", () => {
                document.querySelectorAll(".return-btn").forEach(button => {
                    button.addEventListener("click", function() {
                        const borrowId = this.dataset.borrowId;
                        const studentNo = this.dataset.studentNo;
                        const bookId = this.dataset.bookId;
                        const bookTitle = this.dataset.bookTitle;

                        Swal.fire({
                            title: 'Return Book',
                            html: `
                    <p><strong>Book Title:</strong> ${bookTitle}</p>
                    <p><strong>Student No:</strong> ${studentNo}</p>
                    <select id="book_condition" class="swal2-select" style="width: 100%; padding: 8px; margin-top: 10px;">
                        <option value="">Select Book Condition</option>
                        <option value="Good">Good</option>
                        <option value="1">Damaged-Low</option>
                        <option value="2">Damaged-Medium</option>
                        <option value="3">Damaged-High</option>
                    </select>
                    <div id="proof-section" style="display: none; margin-top: 10px;">
                        <label for="proof_image">Upload Proof of Damage:</label><br>
                        <input type="file" id="proof_image" accept="image/*">
                    </div>
                `,
                            didOpen: () => {
                                const conditionSelect = Swal.getPopup().querySelector('#book_condition');
                                const proofSection = Swal.getPopup().querySelector('#proof-section');

                                conditionSelect.addEventListener('change', () => {
                                    if (conditionSelect.value !== "Good" && conditionSelect.value !== "") {
                                        proofSection.style.display = 'block';
                                    } else {
                                        proofSection.style.display = 'none';
                                    }
                                });
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Confirm',
                            preConfirm: () => {
                                const bookCondition = Swal.getPopup().querySelector('#book_condition').value;
                                const proofImage = Swal.getPopup().querySelector('#proof_image').files[0];

                                if (!bookCondition) {
                                    Swal.showValidationMessage('Please select the book condition.');
                                    return false;
                                }

                                if (bookCondition !== "Good" && !proofImage) {
                                    Swal.showValidationMessage('Please upload a proof of damage image.');
                                    return false;
                                }

                                return {
                                    borrow_id: borrowId,
                                    student_no: studentNo,
                                    book_id: bookId,
                                    book_condition: bookCondition,
                                    proof_image: proofImage || null
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed && result.value) {
                                const {
                                    borrow_id,
                                    student_no,
                                    book_id,
                                    book_condition,
                                    proof_image
                                } = result.value;

                                if (book_condition === "Good") {
                                    fetch('librarian_returned_book.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/x-www-form-urlencoded'
                                            },
                                            body: new URLSearchParams({
                                                borrow_id,
                                                student_no,
                                                book_id,
                                                book_condition
                                            })
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                            Swal.fire(data.success ? 'Success' : 'Error', data.message, data.success ? 'success' : 'error')
                                                .then(() => data.success && location.reload());
                                        });
                                } else {
                                    const formData = new FormData();
                                    formData.append("fine_id", book_condition);
                                    formData.append("student_no", student_no);
                                    formData.append("book_id", book_id);
                                    formData.append("borrow_id", borrow_id);
                                    formData.append("proof_image", proof_image);
                                    formData.append("damage_description", "Damage reported upon return.");
                                    fetch('LIBRARIAN_INSERT_STUDENT_FINE.php', {
                                            method: 'POST',
                                            body: formData
                                        })
                                        .then(res => res.json())
                                        .then(fineRes => {
                                            Swal.fire(fineRes.success ? 'Fine Issued' : 'Error', fineRes.message, fineRes.success ? 'warning' : 'error')
                                                .then(() => fineRes.success && location.reload());
                                        });
                                }
                            }
                        });
                    });
                });
            });

            function viewProofImage(imageFile) {
                if (imageFile) {
                    Swal.fire({
                        title: 'Proof Image',
                        imageUrl: 'proofs/' + imageFile, // Change path as needed
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