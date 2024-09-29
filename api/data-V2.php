<?php
require_once('../db/connection.php');

function getStatus()
{
    $pdoDB = new DB();
    $pdoDB->stmt = $pdoDB->pdo->prepare("SELECT
                        status,
                        voltase,
                        arus,
                        inpower,
                        inenergy,
                        infrequency
                    FROM charging_status");
    $pdoDB->stmt->execute();
    $result = $pdoDB->stmt->fetchAll();
    return array(
        'voltase' => $result[0]['voltase'],
        'arus'    => $result[0]['arus'],
        'energy'  => $result[0]['inenergy'],
        'status'  => $result[0]['status']
    );
}


// ====================== ACTION ========================//

$arr = array(
    'ev_status'  => getStatus()
);
echo json_encode($arr);


//(C) LOOP - CHECK FOR SCORE UPDATES
if (isset($_POST['arus'])) {
    while (true) {
        $score = $pdoDB->getStatus();
        if ($score['energy'] != $_POST['energy'] || $score['arus'] != $_POST['arus']) {
            echo json_encode($score);
            break;
        }
        sleep(1);
    }
} else {
    echo json_encode(array("arus" => 0));
}
