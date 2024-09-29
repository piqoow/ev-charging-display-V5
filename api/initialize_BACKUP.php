<?php
require_once('../db/connection.php');

function getCompany()
{
    $pdoDB = new DB();
    $pdoDB->stmt = $pdoDB->pdo->prepare("SELECT cp.company_name FROM company cp WHERE cp.flag = 'Y'");
    $pdoDB->stmt->execute();
    $result = $pdoDB->stmt->fetchAll();
    return $result[0]['company_name'];
}

function getParkingData()
{
    $pdoDB = new DB();
    $pdoDB->stmt = $pdoDB->pdo->prepare("SELECT
                                            md.display_code,
                                            md.display_name,
                                            dg.display_group_code,
                                            dg.display_group_name,
                                            dg.display_group_style,
                                            dgd.floor_id,
                                            mf.capacity,
                                            mf.balancing,
                                            mf.used,
                                            mf.floor_code
                                        FROM mst_display md
                                        JOIN display_group dg ON dg.display_group_id = md.display_group_id
                                        JOIN display_group_detail dgd ON dgd.display_group_code = dg.display_group_code
                                        JOIN mst_floor mf ON mf.floor_id = dgd.floor_id
                                        WHERE md.display_code = 'P1M1001'");
    $pdoDB->stmt->execute();
    $result = $pdoDB->stmt->fetchAll();
    return array(
        'used'       => $result[0]['used'],
        'capacity'   => $result[0]['capacity'],
        'floor_code' => $result[0]['floor_code'],

    );
}


// ====================== ACTION ========================//

$floor = '';
if(isset($_GET['floor'])){
    $floor = $_GET['floor'];
}

$arr = array(
    // 'company_name'  => getCompany(),
    'data_parking'  => getParkingData($floor)
);
echo json_encode($arr);
