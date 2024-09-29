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
                                            WHERE cs.ev_id = '$ev_id' AND vm.usage_status = 'Belum Terpakai' OR 'Terpakai' AND vm.id_voucher order by vm.id_voucher DESC limit 1
                                            ");
    $pdoDB->stmt->execute();
    //$row = $pdoDB->stmt->rowCount();
    $result = $pdoDB->stmt->fetchAll();
    return array(
        'voltase' => isset($result[0]['voltase']) ? $result[0]['voltase'] : 0,
        'arus'    => isset($result[0]['arus']) ? $result[0]['arus'] : 0,
        // 'energy'  => $result[0]['inenergy'],
        // 'power'   => $result[0]['inpower'],
        // 'status'  => $result[0]['status'],
        // 'inserts' => $result[0]['insert_status'],
        'voucher' => $result[0]['voucher'],
        'usage_status' => $result[0]['usage_status'],
        // 'usage_date'   => $result[0]['usage_date']
    );
    
    // if ($row !== NULL) {
        
    //     //$row = $pdoDB->stmt->numb_row();
    //     return array(
    //         'voltase' => isset($result[0]['voltase']) ? ,
    //         'arus'    => $result[0]['arus'],
    //         'energy'  => $result[0]['inenergy'],
    //         'power'   => $result[0]['inpower'],
    //         'status'  => $result[0]['status'],
    //         'inserts' => $result[0]['insert_status'],
    //         'voucher' => $result[0]['voucher'],
    //         'usage_status' => $result[0]['usage_status'],
    //         'usage_date'   => $result[0]['usage_date']
    //     );
    // } else {
    //     return array(
    //         'voltase' => 0,
    //         'arus'    => 0,
    //         'energy'  => 0,
    //         'power'   => 0,
    //         'status'  => 'OFF',
    //         'inserts' => 0,
    //         'voucher' => '',
    //         'usage_status' => 'Terpakai',
    //         'usage_date'   => date('Y-m-d')
    //     );
    // }
    
}


// ====================== ACTION ========================//

$arr = array(
    'ev_status'  => getStatus($_POST['ev_id']),
    // $row
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
