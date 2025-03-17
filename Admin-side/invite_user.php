<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/vendor/autoload.php';
include '../homepage/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'], $_POST['role'])) {
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address']);
        exit;
    }

    // Generate a temporary password
    $temp_password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
    $hashed_password = password_hash($temp_password, PASSWORD_DEFAULT);

    // Determine the correct table and user ID column based on the role
    if ($role == 'Admin') {
        $stmt = $conn->prepare("INSERT INTO admin_acc (email, password) VALUES (?, ?)");
        $id_column = 'admin_no';
    } elseif ($role == 'Librarian') {
        $stmt = $conn->prepare("INSERT INTO librarian_acc (email, password) VALUES (?, ?)");
        $id_column = 'librarian_no';
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid role']);
        exit;
    }

    $stmt->bind_param('ss', $email, $hashed_password);
    if ($stmt->execute()) {
        // Get the newly inserted user's ID
        $user_id = $conn->insert_id;
        $stmt->close();

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'systemlibrarymanagement8@gmail.com';
            $mail->Password = 'ndur otbh aalt vicl';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Email Content
            $mail->setFrom('no-reply@librasphere.com', 'LibraSphere Support');
            $mail->addAddress($email);
            $mail->Subject = "LIBRASPHERE - Admin/Librarian Account Invitation";

            $mail->Body = "
Dear $role,

Your email ".$email." been invited to join the LibraSphere system as a $role.


Your account details:
 $id_column: $user_id
 Temporary Password: $temp_password

Please log in using the following link:
🔗 [LibraSphere Login](http://http://localhost/LIBRARY_MANAGEMENT_SYSTEM/Homepage/signin.php)

For security reasons, we strongly encourage you to change your password after logging in.

If you have any questions or need assistance, please contact our support team.

Best regards,  
**LibraSphere Support Team**  
no-reply@librasphere.com
";

            if ($mail->send()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Email sending failed']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add user']);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
