<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_library_management_system";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>