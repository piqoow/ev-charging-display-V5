<?php
require_once('../../db/connection.php');

$pdoDB = new DB();
$pdoDB->stmt = $pdoDB->pdo->prepare("UPDATE data_parking SET vehicle_in=? , capacity=? WHERE data_parking_id=?");

$capacity=$_POST['capacity'];
$used = $_POST['used'];
$id = $_POST['data_id'];
$data = array($used,$capacity,$id);
// echo json_encode($_POST['capacity']);exit;
if($pdoDB->stmt->execute($data)) {
    $message = "Edited Successfully";
    $status = 'Success';
} else {
    $message = "Problem in Editing Record";
    $status = 'Error';
}
echo json_encode(array(
    'status'    => $status,
    'message'   => $message
));