<?php
include('../incl/config.php'); // Include your database connection file
header('Content-Type: application/json');

// SQL query to count employees based on service years
$query = "
        SELECT 
        COUNT(id) AS total_documents,
        (SELECT COUNT(*) FROM `document` WHERE status = 'pending') AS pending_count,
        (SELECT COUNT(*) FROM `document` WHERE status = 'processing') AS processing_count,
        (SELECT COUNT(*) FROM `document` WHERE status = 'complete') AS complete_count
        FROM 
        `document`;
";

// Execute the query and fetch the result
$result = $conn->query($query);

// Check if the query was successful
if ($result) {
    $data = $result->fetch_assoc();
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching data'
    ]);
}
?>
