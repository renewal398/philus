<?php
// Set the content type to JSON for the response
header('Content-Type: application/json');

// Define the path for the wishes file
$filePath = 'wishes.txt';

// Check if the 'wish' parameter is set in the POST request
if (isset($_POST['wish'])) {
    // Get the wish from the POST data
    $wish = trim($_POST['wish']);

    // Get the user's IP address
    $userIP = $_SERVER['REMOTE_ADDR'];

    // Create an associative array to store the wish data
    $wishData = array(
        'wish' => $wish,
        'ip' => $userIP,
        'timestamp' => date('Y-m-d H:i:s')
    );

    // Check if the wishes.txt file exists, if not create it
    if (!file_exists($filePath)) {
        file_put_contents($filePath, "[]"); // Initialize the file as an empty JSON array
    }

    // Read the existing wishes from the file
    $currentWishes = json_decode(file_get_contents($filePath), true);

    // Append the new wish data to the existing wishes array
    $currentWishes[] = $wishData;

    // Save the updated wishes back to the file
    file_put_contents($filePath, json_encode($currentWishes, JSON_PRETTY_PRINT));

    // Send a success response
    echo json_encode(array('status' => 'success', 'message' => 'Wish saved successfully!'));
} else {
    // If no wish is provided, send an error response
    echo json_encode(array('status' => 'error', 'message' => 'Wish not provided.'));
}
?>