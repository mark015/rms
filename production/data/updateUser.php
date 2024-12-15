<?php
include('../incl/config.php');
header('Content-Type: application/json');

$userId = $_POST['userId'];
$fName = $_POST['fName'];
$fusername = $_POST['fusername'];
$fRole = $_POST['fRole'];
// Update query
$sql = "UPDATE users 
        SET name = ?, username = ?, role = ?
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $fName, $fusername, $fRole, $userId);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update the document."]);
}

$stmt->close();
$conn->close();
?>
