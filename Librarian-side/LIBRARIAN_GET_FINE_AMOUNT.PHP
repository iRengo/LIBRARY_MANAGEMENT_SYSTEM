<?php
include '../Homepage/db_connect.php'; // adjust to your DB file

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (isset($data->fine_id)) {
    $fine_id = $data->fine_id;
    $query = "SELECT price FROM fines_table WHERE fine_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $fine_id);
    $stmt->execute();
    $stmt->bind_result($price);

    if ($stmt->fetch()) {
        echo json_encode(["success" => true, "price" => $price]);
    } else {
        echo json_encode(["success" => false, "message" => "Fine not found"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
