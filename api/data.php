<?php
require_once('../db/connection.php');

function getStatus($id)
{
    $pdoDB = new DB();
    $pdoDB->stmt = $pdoDB->pdo->prepare("SELECT
                        status,
                        voltase,
                        arus,
                        inpower,
                        inenergy,
                        infrequency,
                        ev_id,
                        insert_status
                    FROM charging_status where ev_id = '$id'");
    $pdoDB->stmt->execute();
    $result = $pdoDB->stmt->fetchAll();
    return array(
        'voltase' => $result[0]['voltase'],
        'arus'    => $result[0]['arus'],
        'energy'  => $result[0]['inenergy'],
        'power'   => $result[0]['inpower'],
        'status'  => $result[0]['status'],
        'inserts' => $result[0]['insert_status']
    );
}


// ====================== ACTION ========================//

$arr = array(
    'ev_status'  => getStatus($_POST['id'])
);

echo json_encode($arr);


//(C) LOOP - CHECK FOR SCORE UPDATES
// if (isset($_POST['voltase'])) {
//     while (true) {
//         $score = $pdoDB->getStatus();
//         if ($score['energy'] != $_POST['energy'] || $score['arus'] != $_POST['arus']) {
//             echo json_encode($score);
//             break;
//         }
//         sleep(1);
//     }
// } else {
//     echo json_encode(array("used" => 0));
// }
