<?php
require_once('../../db/connection.php');

function getSensor(){
    $pdoDB = new DB();
    $pdoDB->stmt = $pdoDB->pdo->query("SELECT * FROM data_parking dp WHERE dp.sensor_name = '".$_POST['sensor']."'");
    $pdoDB->stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $pdoDB->stmt->fetch();
}

echo json_encode(getSensor());