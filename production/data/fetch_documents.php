<?php
include('../incl/config.php');
header('Content-Type: application/json');

// Fetch the role and other query parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$role = isset($_GET['role']) ? $conn->real_escape_string($_GET['role']) : '';
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$limit = 10; // Number of records per page
$offset = ($page - 1) * $limit;

// Base SQL query for fetching documents
$sql = "SELECT `id`, `document_number`, `document_title`, `date_received`, `status`, `date_released`, `document_file`
        FROM `document` 
        WHERE (`document_title` LIKE '%$search%' OR `document_number` LIKE '%$search%')";

// Base SQL query for counting total records
$count_sql = "SELECT COUNT(*) as total 
              FROM `document` 
              WHERE (`document_title` LIKE '%$search%' OR `document_number` LIKE '%$search%')";

// Role-specific conditions
if ($role === "Admin") {
    // Admin sees all documents
    $sql .= " LIMIT $limit OFFSET $offset";
} elseif ($role === "User1") {
    // User1 sees only pending documents
    $sql .= " AND `status` = 'pending' LIMIT $limit OFFSET $offset";
    $count_sql .= " AND `status` = 'pending'";
}elseif($role === "User2"){
    // User2 sees only Processing documents
    $sql .= " AND `status` = 'processing' LIMIT $limit OFFSET $offset";
    $count_sql .= " AND `status` = 'processing'";
} else {
    // If no role matches, return an error
    echo json_encode([
        "error" => "Invalid role specified.",
    ]);
    exit;
}

// Execute the main query
$result = $conn->query($sql);

// Execute the count query
$count_result = $conn->query($count_sql);
$total_records = $count_result->fetch_assoc()['total'];

// Prepare the response data
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Prepare and output the response
$response = [
    "success" => true,
    "data" => $data,
    "total" => $total_records,
    "page" => $page,
    "limit" => $limit,
];
echo json_encode($response);

// Close connections
$conn->close();
?>
