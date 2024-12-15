<?php

declare(strict_types=1);

include('../incl/config.php');
header('Content-Type: application/json');

try {
    // Ensure the ID is provided in the request
    $documentId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($documentId === null || $documentId === false) {
        throw new InvalidArgumentException('No valid document ID provided.');
    }

    // Construct the SQL query to delete the document
    $query = "DELETE FROM document WHERE id = $documentId";

    // Execute the query
    if ($conn->query($query)) {
        // If deletion is successful, return a success response
        echo json_encode([
            'status' => 'success', 
            'message' => 'Document deleted successfully.'
        ], JSON_THROW_ON_ERROR);
    } else {
        // If deletion fails, throw an exception
        throw new RuntimeException('Failed to delete the document.');
    }
} catch (InvalidArgumentException $e) {
    // Handle invalid input errors
    http_response_code(400);
    echo json_encode([
        'status' => 'error', 
        'message' => $e->getMessage()
    ], JSON_THROW_ON_ERROR);
} catch (RuntimeException $e) {
    // Handle runtime errors (e.g., database issues)
    http_response_code(500);
    echo json_encode([
        'status' => 'error', 
        'message' => $e->getMessage()
    ], JSON_THROW_ON_ERROR);
} catch (Throwable $e) {
    // Catch any unexpected errors
    http_response_code(500);
    echo json_encode([
        'status' => 'error', 
        'message' => 'An unexpected error occurred.'
    ], JSON_THROW_ON_ERROR);
}

?>