<?php 
session_start();
include '../Homepage/db_connect.php';

$loggedInUser = $_SESSION['librarian_no'];

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
        <h2>Librarian Unpaid Fines</h2>

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
        </script>
</body>

</html>