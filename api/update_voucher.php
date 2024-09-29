<?php
require_once('../db/connection.php');

function logUpdateData($id) {
    $pdoDB = new DB();
    $pdoDB->stmt = $pdoDB->pdo->prepare("UPDATE voucher_ms SET usage_status = 'Terpakai' WHERE ev_id='$id' order by id_voucher DESC limit 1");
    return $pdoDB->stmt->execute();
}

$update = logUpdateData($_POST['id']);
echo json_encode($update);