<?php
header("Content-Type: application/json");

// Get JSON data from the request body
$data = json_decode(file_get_contents('php://input'), true);

// Check if required fields are present
if (isset($data['name'], $data['email'], $data['ticket'])) {
    $fileName = 'ticket_data.txt';

    // Format the data
    $fileContent = "{$data['name']}, {$data['email']}, {$data['ticket']}\n";

    // Append data to the file
    $success = file_put_contents($fileName, $fileContent, FILE_APPEND | LOCK_EX);

    if ($success !== false) {
        http_response_code(200);
        echo json_encode(['message' => 'Ticket submitted successfully!']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error writing to file']);
    }
} else {
    http_response_code(400);
    echo json_encode(['message' => 'Bad Request: Missing data']);
}
?>