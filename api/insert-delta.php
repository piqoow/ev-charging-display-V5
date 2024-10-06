<?php
$servername = "localhost";
$username = "smartpay";
$password = "smartpay@DEV";
$database = "ev_charging_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$chargerStatus = $_POST['chargerStatus'];
$voltage = $_POST['voltage'];
$current = $_POST['current'];
$power = $_POST['power'];
$fixedRoundedEnergy = $_POST['fixedRoundedEnergy'];
$time = $_POST['time'];
$id = $_POST['id'];

$sql = "UPDATE evgate SET charger_status = '$chargerStatus', voltage = '$voltage', current = '$current', power = '$power', energy = '$fixedRoundedEnergy kWh', insert_status = '1', `time` ='$time', `updated_log` =now() WHERE customer_id = '$id'"; // Update your_table_name and your_condition accordingly

if ($conn->query($sql) === TRUE) {
    $response = array("status" => "success", "message" => "Signal updated successfully");
    echo json_encode($response);
} else {
    $response = array("status" => "error", "message" => "Error updating signal: " . $conn->error);
    echo json_encode($response);
}

$conn->close();
?>