<?php
require_once('../db/connection.php');

function logUpdateParkee($id) {
    $pdoDB = new DB();
    $pdoDB->stmt = $pdoDB->pdo->prepare("UPDATE evgate
                                         SET parkee_service = 'ON'
                                         WHERE ev_id = '$id';");
    return $pdoDB->stmt->execute();
}

function getEvClientId($id) {
    $pdoDB = new DB();
    
    $pdoDB->stmt = $pdoDB->pdo->prepare("SELECT serial_number FROM evgate WHERE ev_id = '$id';");
    $pdoDB->stmt->execute();

    $result = $pdoDB->stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && isset($result['serial_number'])) {
        return $result['serial_number'];
    } else {
        return null;
    }
}

function callApiStopCharge($evClientId) {
    $url = 'https://ms.parkee.app/quickbook/v1/ev-charges/blue-charge/auto-off-or-on/start';

    $data = [
        "evClientId" => $evClientId
    ];

    $jsonData = json_encode($data);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'X-API-REQUEST-TYPE: BLUE_CHARGE',
        'Content-Type: application/json',
        'Authorization: Basic Ji4wVEtDQ25WYUdQYXM2KD1iWmRYISVQanQyTkAyRTgxLmFCQGQmVDo='
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
    }

    curl_close($ch);

    return $response;
}

$id = $_POST['id'];

$update = logUpdateParkee($id);

$evClientId = getEvClientId($id);

if ($evClientId) {
    $apiResponse = callApiStopCharge($evClientId);

    echo json_encode([
        'updateStatus' => $update,
        'apiResponse' => json_decode($apiResponse)
    ]);
} else {
    echo json_encode([
        'updateStatus' => $update,
        'error' => 'evClientId not found for the provided ID'
    ]);
}
?>
