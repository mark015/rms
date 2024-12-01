<?php
    include('../incl/config.php');
    header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Set the timezone
    date_default_timezone_set('Asia/Manila');

    // Get POST data
    $documentNumber = $_POST['documentNumber'];
    $documentTitle = $_POST['documentTitle'];
    $status = 'pending';
    $documentFile = $_FILES['documentFile']['name'];

    // Generate the current date and time for date_received
    $dateReceived = date('Y-m-d H:i:s');
    $notifStatus = 'unread';
    // Move the uploaded file to the target directory (optional)
    
    if ($documentFile) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($_FILES['documentFile']['name']);
        if (!move_uploaded_file($_FILES['documentFile']['tmp_name'], $targetFile)) {
            echo json_encode(['status' => 'error', 'message' => 'File upload failed.']);
            exit;
        }
    }
    // Insert the document into the database
    $sql = "INSERT INTO document (document_number, document_title, date_received, status, document_file, notif_status) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssssss", $documentNumber, $documentTitle, $dateReceived, $status, $documentFile, $notifStatus);
        $stmt->execute();

        // Check if the insertion was successful
        if ($stmt->affected_rows > 0) {
            $response = [
                'status' => 'success',
                'message' => 'Document added successfully!',
                'document' => [
                    'documentNumber' => $documentNumber,
                    'documentTitle' => $documentTitle,
                    'dateReceived' => $dateReceived,
                    'status' => $status,
                    'documentFile' => $documentFile
                ]
            ];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to add document.'];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Database error.'];
    }

    // Send the response as JSON
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
