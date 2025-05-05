<?php
session_start();
session_unset();     // Unset all session variables
session_destroy();   // Destroy the session

// Optionally redirect to login or homepage
header("Location: ../homepage/signin.php");
exit();
?>