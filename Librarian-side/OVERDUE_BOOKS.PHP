<?php
session_start();
include '../Homepage/db_connect.php';
$today = date('Y-m-d');
$overdue_sql = "SELECT bb.*, b.book_cover 
                   FROM borrowed_books bb
                   JOIN tbl_books b ON bb.book_id = b.book_id
                   WHERE bb.status = 'Borrowed' AND bb.due_date < '$today'
                   ORDER BY bb.due_date ASC";
$overdue_result = mysqli_query($conn, $overdue_sql);
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


    <div class="notifications-container">
        <h2>Librarian Overdue Books</h2>

        <div id="overdue">
            <table>
                <thead>
                    <tr>
                        <th>Book Cover</th>
                        <th>Borrow ID</th>
                        <th>Student No</th>
                        <th>Book Title</th>
                        <th>Borrowed Date</th>
                        <th>Due Date</th>
                        <th>Days Overdue</th>
                        <th>Action </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($overdue_result && mysqli_num_rows($overdue_result) > 0) {
                        while ($row = mysqli_fetch_assoc($overdue_result)) {
                            $imageURL = $row['book_cover'];
                            $due_date = new DateTime($row['due_date']);
                            $today_date = new DateTime($today);
                            $interval = $due_date->diff($today_date);
                            $daysOverdue = $interval->days;

                            echo "<tr>
    <td><img src='{$imageURL}' alt='Book Cover' style='width: 60px; height: auto; border-radius: 4px;'></td>
    <td>{$row['borrow_id']}</td>
    <td>{$row['student_no']}</td>
    <td>{$row['book_title']}</td>
    <td>{$row['preferred_date']}</td>
    <td style='color: red; font-weight: bold;'>{$row['due_date']}</td>
    <td style='color: red;'>{$daysOverdue} day(s)</td>
    <td>
        <button 
            class='return-btn styled-btn' 
            data-borrow-id='{$row['borrow_id']}'
            data-student-no='{$row['student_no']}'
            data-book-id='{$row['book_id']}'
            data-book-title=\"" . htmlspecialchars($row['book_title'], ENT_QUOTES) . "\"
        >Returned</button>
    </td>
</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No overdue books found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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
        </script>
</body>

</html>