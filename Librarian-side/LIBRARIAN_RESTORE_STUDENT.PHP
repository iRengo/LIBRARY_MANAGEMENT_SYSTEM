<?php
include '../homepage/db_connect.php';

// Function to restore the student
function restoreStudent($archivedId, $conn) {
    $sql = "SELECT * FROM archived_acc WHERE archived_id = '$archivedId'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);

        $insertQuery = "INSERT INTO stud_acc (student_no, password, first_name, last_name, email, contact, otp, otp_expiry, last_logged_in, verified) 
                        VALUES ('" . $student['user_id'] . "', '" . $student['password'] . "', '" . $student['first_name'] . "', 
                        '" . $student['last_name'] . "', '" . $student['email'] . "', '" . $student['contact'] . "', '', '', '', '" . $student['verified'] . "')";

        if (mysqli_query($conn, $insertQuery)) {
            $deleteQuery = "DELETE FROM archived_acc WHERE archived_id = '$archivedId'";
            mysqli_query($conn, $deleteQuery);
            return true;
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['archived_id'])) {
    $archivedId = $_POST['archived_id'];

    if (restoreStudent($archivedId, $conn)) {
        echo 'success'; // Return success response to AJAX
    } else {
        echo 'failure'; // Return failure response to AJAX
    }
}
?>
