<?php
session_start();
include '../Homepage/db_connect.php'; // adjust path if needed

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Librarian Notifications</title>
    <link rel="stylesheet" href="LIBRARIAN_NOTIFICATIONS.css">

</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP'; ?>


    <div class="notifications-container">
        <h2>Librarian Notifications</h2>

        <div class="tab-container">
            <ul class="tab-list">
                <li onclick="filterSection('borrow')" data-section="borrow">Borrow Requests</li>
                <li onclick="filterSection('pickup')" data-section="pickup">Ready to Pickup</li>
                <li onclick="filterSection('reserve')" data-section="reserve">Reserved Books</li>
                <li onclick="filterSection('due')" data-section="due">Due Books</li>
                <li onclick="filterSection('overdue')" data-section="overdue">Overdue Books</li>
                <li onclick="filterSection('returned')" data-section="returned">Returned Books</li>
                <li onclick="filterSection('unpaid')" data-section="unpaid">Unpaid Fines</li>

            </ul>
        </div>
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
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $borrow_sql = "SELECT bb.*, b.book_cover 
                FROM borrowed_books bb
                JOIN tbl_books b ON bb.book_id = b.book_id
                WHERE bb.status = 'Pending'
                ORDER BY bb.borrow_id DESC";


                    $borrow_result = mysqli_query($conn, $borrow_sql);

                    if ($borrow_result && mysqli_num_rows($borrow_result) > 0) {
                        while ($row = mysqli_fetch_assoc($borrow_result)) {
                            $imageURL = $row['book_cover'];

                            echo "<tr>
                                <td><img src='{$imageURL}' alt='Book Cover' style='width: 60px; height: auto; border-radius: 4px;'></td>
                                <td>{$row['borrow_id']}</td>
                                <td>{$row['student_no']}</td>
                                <td>{$row['book_title']}</td>
                                <td>{$row['preferred_date']}</td>
                                <td>{$row['status']}</td>
                               <td class='action-icons'>
                                    <i class='accept' onclick='acceptRequest({$row['borrow_id']})'>&#10003;</i>
                                    <i class='decline' onclick='declineRequest(
    " . json_encode($row['borrow_id']) . ", 
    " . json_encode($row['student_no']) . ", 
    " . json_encode($row['email']) . ", 
    " . json_encode($row['book_title']) . ", 
    " . json_encode($row['contact']) . ", 
    " . json_encode($row['preferred_date']) . "
)'>&#10006;</i>

                                </td>
                              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No borrow requests found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>


        <div id="reserve" class="tab-content">
            <table>
                <thead>
                    <tr>
                        <th>Book Cover</th>
                        <th>Reservation ID</th>
                        <th>Student No</th>
                        <th>Book Title</th>
                        <th>Reserved Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to fetch reservation details including book cover
                    $reserve_sql = "SELECT r.reserved_id, r.student_no, r.book_title, r.reserved_date, b.book_cover
                            FROM reserved_books r
                            JOIN tbl_books b ON r.book_id = b.book_id
                            ORDER BY r.reserved_id DESC";
                    $reserve_result = mysqli_query($conn, $reserve_sql);

                    if ($reserve_result && mysqli_num_rows($reserve_result) > 0) {
                        while ($row = mysqli_fetch_assoc($reserve_result)) {
                            $imageURL = $row['book_cover']; // Get the book cover URL

                            echo "<tr>
                        <td><img src='{$imageURL}' alt='Book Cover' style='width: 60px; height: auto; border-radius: 4px;'></td> 
                        <td>{$row['reserved_id']}</td>
                        <td>{$row['student_no']}</td>
                        <td>{$row['book_title']}</td>
                        
                        <td>{$row['reserved_date']}</td>
                    </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No reserved books found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

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
                    $pickup_sql = "SELECT bb.*, b.book_cover 
                FROM borrowed_books bb
                JOIN tbl_books b ON bb.book_id = b.book_id
                WHERE bb.status = 'Approved'
                ORDER BY bb.borrow_id DESC";

                    $pickup_result = mysqli_query($conn, $pickup_sql);

                    if ($pickup_result && mysqli_num_rows($pickup_result) > 0) {
                        while ($row = mysqli_fetch_assoc($pickup_result)) {
                            $imageURL = $row['book_cover'];

                            echo "<tr>
                        <td><img src='{$imageURL}' alt='Book Cover' style='width: 60px; height: auto; border-radius: 4px;'></td>
                        <td>{$row['borrow_id']}</td>
                        <td>{$row['student_no']}</td>
                        <td>{$row['book_title']}</td>
                        <td>{$row['preferred_date']}</td>
                        <td>Within 24 hours</td>
                        <td>{$row['status']}</td>
                        <td>
    <button onclick='markAsPickedUp({$row['borrow_id']})' style='padding: 6px 12px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;'>Picked Up</button>
</td>
                    </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No ready-to-pickup books found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div id="due" style="display: none;">
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
                    $today = date('Y-m-d');
                    $due_sql = "SELECT bb.*, b.book_cover 
                FROM borrowed_books bb
                JOIN tbl_books b ON bb.book_id = b.book_id
                WHERE bb.status = 'Borrowed' AND bb.due_date = '$today'
                ORDER BY bb.due_date ASC";

                    $due_result = mysqli_query($conn, $due_sql);

                    if ($due_result && mysqli_num_rows($due_result) > 0) {
                        while ($row = mysqli_fetch_assoc($due_result)) {
                            $imageURL = $row['book_cover'];
                            echo "<tr>
                        <td><img src='{$imageURL}' alt='Book Cover' style='width: 60px; height: auto; border-radius: 4px;'></td>
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
> Returned</button> </td>
                    </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No books due today.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="overdue" style="display: none;">
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
                    $today = date('Y-m-d');
                    $overdue_sql = "SELECT bb.*, b.book_cover 
                   FROM borrowed_books bb
                   JOIN tbl_books b ON bb.book_id = b.book_id
                   WHERE bb.status = 'Borrowed' AND bb.due_date > '$today'
                   ORDER BY bb.due_date ASC";
                    $overdue_result = mysqli_query($conn, $overdue_sql);

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
                        <td> <button> Returned </button> </td>
                    </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No overdue books found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="unpaid" class="tab-content">
            <table>
                <thead>
                    <tr>
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
                    $fines_sql = "
    SELECT 
        sf.student_no,
        b.book_title,
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

                    if ($fines_result && mysqli_num_rows($fines_result) > 0) {
                        while ($fine = mysqli_fetch_assoc($fines_result)) {
                            echo "<tr>
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
                        echo "<tr><td colspan='6'>No unpaid fines found.</td></tr>";
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


            function filterSection(sectionId) {
                const sections = ['borrow', 'pickup', 'reserve', 'due', 'overdue', 'returned', 'unpaid'];

                // Show/Hide content
                sections.forEach(id => {
                    const section = document.getElementById(id);
                    if (section) {
                        section.style.display = id === sectionId ? 'block' : 'none';
                    }
                });

                // Update active tab
                const tabItems = document.querySelectorAll('.tab-list li');
                tabItems.forEach(tab => {
                    tab.classList.remove('active');
                    if (tab.dataset.section === sectionId) {
                        tab.classList.add('active');
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
        </script>
</body>

</html>