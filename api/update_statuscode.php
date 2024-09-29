<?php
require_once('../db/connection.php');

function logUpdateData($id) {
    $pdoDB = new DB();
    $pdoDB->stmt = $pdoDB->pdo->prepare("UPDATE charging_status
                                         SET status_code = '1'
                                         WHERE ev_id = '$id';");
    return $pdoDB->stmt->execute();
}

$update = logUpdateData($_POST['id']);
echo json_encode($update);