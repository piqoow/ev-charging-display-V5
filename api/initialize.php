<?php
require_once('../db/connection.php');

function getlog()
{
    $pdoDB = new DB();
    $pdoDB->stmt = $pdoDB->pdo->prepare("SELECT time as timenow, energy, savedate as tanggal, id, ev_id FROM charging_log where ev_id = 'EV01' ORDER BY id DESC LIMIT 1");
    $pdoDB->stmt->execute();
    $result = $pdoDB->stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

// function getlog()
// {
//     $pdoDB = new DB();
//     $pdoDB->stmt = $pdoDB->pdo->prepare("SELECT time as timenow, 
//                                                 energy,
//                                                 savedate as tanggal,
//                                                 id 
//                                         FROM charging_log
//                                         ORDER BY id DESC
//                                         LIMIT 1");
//     $pdoDB->stmt->execute();
//     $result = $pdoDB->stmt->fetchAll(PDO::FETCH_ASSOC);
//     return $result;
// }
// ====================== ACTION ========================//

// $floor = '';
// $display = '';
// if(isset($_GET['floor'])){
//     $floor = $_GET['floor'];
// }
// if(isset($_GET['display'])){
//     $display = $_GET['display'];
// }
echo json_encode(getlog());
