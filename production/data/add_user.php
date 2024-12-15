<?php
    include('../incl/config.php');
    header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get POST data
    $fName = $_POST['fName'];
    $fusername = $_POST['fusername'];
    $fPass = $_POST['fPass'];
    $fRole = $_POST['fRole'];
    $mdPass = md5($fPass);
    
    // Insert the document into the database
    $sql = "INSERT INTO `users`(`name`, `username`, `password`, `role`)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssss", $fName, $fusername, $mdPass, $fRole);
        $stmt->execute();

        // Check if the insertion was successful
        if ($stmt->affected_rows > 0) {
            $response = [
                'status' => 'success',
                'message' => 'User added successfully!',
                'user' => [
                    'fName' => $fName
                ]
            ];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to add User.'];
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
