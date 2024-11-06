<?php
require_once('../db/connection.php');

$id = $_POST['id']; // Customer ID passed as a parameter

// Function to update the park service status in the database
function logUpdateParkee($id) {
    $pdoDB = new DB();
    // Use prepared statements to avoid SQL injection
    $pdoDB->stmt = $pdoDB->pdo->prepare("UPDATE evgate SET parkee_service = 'OFF' WHERE customer_id = :id");
    $pdoDB->stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $pdoDB->stmt->execute();
}

// Function to retrieve the evClientId (serial_number) from the database using the customer_id
function getEvClientId($id) {
    $pdoDB = new DB();
    $pdoDB->stmt = $pdoDB->pdo->prepare("SELECT serial_number FROM evgate WHERE customer_id = :id");
    $pdoDB->stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $pdoDB->stmt->execute();

    $result = $pdoDB->stmt->fetch(PDO::FETCH_ASSOC);

    // Return the serial_number (evClientId) if found, or null if not
    if ($result && isset($result['serial_number'])) {
        return $result['serial_number'];
    } else {
        return null;
    }
}

// Function to call the API to stop the charge using the evClientId
function callApiStopCharge($evClientId) {
    $url = 'https://ms.parkee.app/quickbook/v1/ev-charges/blue-charge/auto-off-or-on/stop';

    // Prepare data to be sent in the API request body
    $data = [
        "evClientId" => $evClientId,  // Use the evClientId retrieved from the database
        "durationInMinutes" => 100000 // Duration (can be customized as needed)
    ];

    // Convert data to JSON format for the request
    $jsonData = json_encode($data);

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options for the request
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Send JSON data in POST body
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'X-API-REQUEST-TYPE: BLUE_CHARGE',
        'Content-Type: application/json',
        'Authorization: Basic Ji4wVEtDQ25WYUdQYXM2KD1iWmRYISVQanQyTkAyRTgxLmFCQGQmVDo=' // Authorization header
    ]);

    // Execute the cURL request and get the response
    $response = curl_exec($ch);

    // Check for any cURL errors
    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);

    return $response;  // Return the API response
}

// Main code execution
$update = logUpdateParkee($id);  // Update the parkee_service status in the database

$evClientId = getEvClientId($id);  // Get the evClientId (serial_number) from the database

// Check if evClientId was found
if ($evClientId) {
    // Call the API to stop charging using the retrieved evClientId
    $apiResponse = callApiStopCharge($evClientId);

    // Decode the API response from JSON
    $decodedResponse = json_decode($apiResponse, true);

    // Check if the response is valid JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode([
            'updateStatus' => $update,
            'error' => 'Invalid API response'
        ]);
    } else {
        // Output the response along with the update status
        echo json_encode([
            'updateStatus' => $update,
            'apiResponse' => $decodedResponse
        ]);
    }
} else {
    // If evClientId was not found, return an error message
    echo json_encode([
        'updateStatus' => $update,
        'error' => 'evClientId not found for the provided ID'
    ]);
}
?>
