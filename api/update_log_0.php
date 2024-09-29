<?php
require_once('../db/connection.php');

function logUpdateData($id) {
    $pdoDB = new DB();
    $pdoDB->stmt = $pdoDB->pdo->prepare("UPDATE charging_status
                                         SET insert_status = '0'
                                         WHERE ev_id = '$id';");
    return $pdoDB->stmt->execute();
}

$update = logUpdateData($_POST['id']);
echo json_encode($update);