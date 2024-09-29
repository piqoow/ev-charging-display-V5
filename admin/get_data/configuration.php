<?php
function getSensor()
{
    $pdoDB = new DB();
    $pdoDB->stmt = $pdoDB->pdo->prepare("SELECT * FROM data_parking dp");
    $pdoDB->stmt->execute();
    $result = $pdoDB->stmt->fetchAll();
    return $result;
}
