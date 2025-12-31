<?php
// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set headers to allow cross-origin requests if needed
header('Content-Type: text/plain');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Error: Only POST requests are allowed";
    exit;
}

// Get the wish and timestamp from POST data
$wish = isset($_POST['wish']) ? $_POST['wish'] : '';
$timestamp = isset($_POST['timestamp']) ? $_POST['timestamp'] : date('Y-m-d H:i:s');

// Validate that wish is not empty
if (empty(trim($wish))) {
    http_response_code(400);
    echo "Error: Wish cannot be empty";
    exit;
}

// Sanitize the input
$wish = htmlspecialchars($wish, ENT_QUOTES, 'UTF-8');
$timestamp = htmlspecialchars($timestamp, ENT_QUOTES, 'UTF-8');

// Format the wish entry
$wishEntry = "[{$timestamp}] {$wish}\n";

// Define the file path (wishes.txt in the same directory)
$filePath = __DIR__ . '/wishes.txt';

// Append the wish to the file
$result = file_put_contents($filePath, $wishEntry, FILE_APPEND | LOCK_EX);

if ($result === false) {
    http_response_code(500);
    echo "Error: Could not save wish to file";
    exit;
}

// Success response
http_response_code(200);
echo "Success: Wish saved successfully";
?>