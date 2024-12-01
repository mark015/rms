<?php
include('../incl/config.php');
header('Content-Type: application/json');

$documentId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($documentId) {
    $sql = "SELECT id, document_number, document_title, date_received, status, date_released, document_file 
            FROM document 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $documentId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(["success" => true, "data" => $data]);
    } else {
        echo json_encode(["success" => false, "message" => "Document not found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid document ID."]);
}
?>
