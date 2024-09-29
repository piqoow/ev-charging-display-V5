<?php
require_once('../db/connection.php');

function logInsertData($kwh, $time, $id, $ev_id) {
    $pdoDB = new DB();
    $pdoDB->stmt = $pdoDB->pdo->prepare("INSERT INTO `charging_log`(`id`, `ev_id`, `time`, `energy`, `savedate`) 
                                         VALUES ('$id','$ev_id', '$time', '$kwh', CURRENT_TIMESTAMP)");
    return $pdoDB->stmt->execute();
}

$input = logInsertData($_POST['kwh'], $_POST['time'], $_POST['id'], $_POST['ev_id']);
echo json_encode($input);