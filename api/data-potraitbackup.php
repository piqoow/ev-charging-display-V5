<?php
require_once('../db/connection.php');

function getStatus($ev_id)
{
    $pdoDB = new DB();
    $pdoDB->stmt = $pdoDB->pdo->prepare("SELECT cs.ev_id,
                                                cs.status,
                                                cs.voltase,
                                                cs.arus,
                                                cs.inpower,
                                                cs.inenergy,
                                                cs.infrequency,
                                                cs.insert_status,
                                                vm.id_voucher,
                                                vm.voucher,
                                                vm.usage_status,
                                                vm.usage_date
                                            FROM charging_status cs
                                            JOIN voucher_ms vm ON vm.ev_id = cs.ev_id
                                            WHERE cs.ev_id = '$ev_id' AND vm.usage_status = 'Belum Terpakai' OR 'Terpakai' AND vm.id_voucher order by vm.id_voucher desc limit 1");
    $pdoDB->stmt->execute();
    $result = $pdoDB->stmt->fetchAll();
    return array(
        'ev_id' => $result[0]['ev_id'],
        'voltase' => $result[0]['voltase'],
        'arus'    => $result[0]['arus'],
        'energy'  => $result[0]['inenergy'],
        'power'   => $result[0]['inpower'],
        'status'  => $result[0]['status'],
        'inserts' => $result[0]['insert_status'],
        'id_voucher' => $result[0]['id_voucher'],
        'voucher' => $result[0]['voucher'],
        // 'status_code' => $result[0]['status_code'],
        'usage_status' => $result[0]['usage_status'],
        'usage_date'   => $result[0]['usage_date']
    );
}


// ====================== ACTION ========================//

$arr = array(
    'ev_status'  => getStatus($_POST['ev_id'])
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
