<?php
include('../incl/config.php');
header('Content-Type: application/json');

$documentId = $_POST['documentId'];
$documentNumber = $_POST['documentNumber'];
$documentTitle = $_POST['documentTitle'];
$status = $_POST['status'];
$dateReleased = date('Y-m-d H:i:s'); 
$notifStatus = 'unread';
if($status === 'pending'){
    $statusDocs = 'processing';
}else{
    $statusDocs = 'complete';
}
$filePath = "";
if (isset($_FILES['documentFile']['name']) && !empty($_FILES['documentFile']['name'])) {
    $uploadDir = "../uploads/";
    $fileName = basename($_FILES['documentFile']['name']);
    $filePath = $uploadDir . $fileName;

    // Move uploaded file
    if (!move_uploaded_file($_FILES['documentFile']['tmp_name'], $filePath)) {
        echo json_encode(["success" => false, "message" => "Failed to upload the file."]);
        exit;
    }
}
// Update query
$sql = "UPDATE document 
        SET document_number = ?, document_title = ?, document_file = ? , status = ?, date_released = ?, notif_status = ?
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $documentNumber, $documentTitle, $filePath , $statusDocs, $dateReleased , $notifStatus ,$documentId);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update the document."]);
}

$stmt->close();
$conn->close();
?>
