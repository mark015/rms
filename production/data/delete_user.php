<?php

declare(strict_types=1);

include('../incl/config.php');
header('Content-Type: application/json');

try {
    // Ensure the ID is provided in the request
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new InvalidArgumentException('No document ID provided.');
    }

    $documentId = (int)$_POST['id']; // Ensure ID is sanitized as an integer

    // Prepare the SQL query to delete the document
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);

    // Execute the query
    if ($stmt->execute([$documentId])) {
        // If deletion is successful, return a success response
        echo json_encode(['status' => 'success', 'message' => 'User deleted successfully.']);
    } else {
        // If deletion fails, throw an exception
        throw new RuntimeException('Failed to delete the document.');
    }
} catch (InvalidArgumentException $e) {
    // Handle invalid input errors
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} catch (RuntimeException $e) {
    // Handle runtime errors (e.g., database issues)
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} catch (Exception $e) {
    // Catch any unexpected errors
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred.']);
}

?>