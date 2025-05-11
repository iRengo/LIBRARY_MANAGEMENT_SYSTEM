<?php
include '../homepage/db_connect.php';

if (isset($_POST['fine_id'])) {
    $fine_id = $_POST['fine_id'];

    // Fetch violation_id
    $fetch_sql = "SELECT violation_id FROM student_fines WHERE fine_id = ? AND status = 'unpaid' LIMIT 1";
    $stmt = mysqli_prepare($conn, $fetch_sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $fine_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $violation_id);

        if (mysqli_stmt_fetch($stmt)) {
            // Close the fetch statement
            mysqli_stmt_close($stmt);

            // Now update the fine status
            $update_sql = "UPDATE student_fines SET status = 'paid' WHERE violation_id = ?";
            $update_stmt = mysqli_prepare($conn, $update_sql);

            if ($update_stmt) {
                mysqli_stmt_bind_param($update_stmt, 'i', $violation_id);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);
                echo "Fine marked as paid.";
            } else {
                echo "Failed to prepare update statement.";
            }
        } else {
            mysqli_stmt_close($stmt);
            echo "No unpaid fine found for this fine ID.";
        }
    } else {
        echo "Error preparing fetch statement: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
