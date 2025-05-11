<?php
include '../homepage/db_connect.php';

// Function to archive the student
function archiveStudent($studentNo, $conn) {
    $sql = "SELECT * FROM stud_acc WHERE student_no = '$studentNo'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);

        $insertQuery = "INSERT INTO archived_acc (user_id, password, first_name, last_name, email, contact, role, verified, archived_at) 
                        VALUES (
                            '" . $student['student_no'] . "', 
                            '" . $student['password'] . "', 
                            '" . $student['first_name'] . "', 
                            '" . $student['last_name'] . "', 
                            '" . $student['email'] . "', 
                            '" . $student['contact'] . "', 
                            'student', 
                            '" . $student['verified'] . "', 
                            NOW()
                        )";

        if (mysqli_query($conn, $insertQuery)) {
            $deleteQuery = "DELETE FROM stud_acc WHERE student_no = '$studentNo'";
            mysqli_query($conn, $deleteQuery);
            return true;
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_no'])) {
    $studentNo = $_POST['student_no'];

    if (archiveStudent($studentNo, $conn)) {
        echo 'success'; // Return success response to AJAX
    } else {
        echo 'failure'; // Return failure response to AJAX
    }
}
?>
