<?php
require_once('../../db/connection.php');

function getSensor(){
    $pdoDB = new DB();
    $pdoDB->stmt = $pdoDB->pdo->query("SELECT
                                            dp.sensor_name,
                                            dp.capacity,
                                            dp.vehicle_in,
                                            md.mapping_value floor,
                                            DATE_FORMAT(dp.updated_at, '%d %M %Y %H:%i:%s') effective_date
                                        FROM data_parking dp
                                        JOIN mapping_data md ON md.mapping_data = dp.sensor_name");
    return $pdoDB->stmt->fetchAll(PDO::FETCH_ASSOC);
    // return $pdoDB->stmt->fetch();
}

echo json_encode(getSensor());