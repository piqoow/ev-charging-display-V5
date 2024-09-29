<?php
// (A) SETTINGS - CHANGE THESE TO YOUR OWN!
define('DB_HOST', '111.0.149.91');
define('DB_NAME', 'parking_pgs_1_1');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'cp_user');
define('DB_PASSWORD', 'cp_password');
set_time_limit(30); // Set the appropriate time limit
ignore_user_abort(false); // Stop when polling breaks

// (B) DATABASE CLASS
class DB
{
    protected $pdo = null;
    protected $stmt = null;
    function __construct()
    {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASSWORD
            );
        } catch (Exception $ex) {
            exit($ex->getMessage());
        }
    }
    function __destruct()
    {
        if ($this->stmt !== null) {
            $this->stmt = null;
        }
        if ($this->pdo !== null) {
            $this->pdo = null;
        }
    }
    function getData()
    {
        $this->stmt = $this->pdo->prepare("SELECT
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
        $this->stmt->execute();
        $result = $this->stmt->fetchAll();
        return count($result) == 0 ? array("used" => 0, "capacity" => 0) : array("used" => $result[0]['used'], "capacity"    => $result[0]['capacity']);
    }
}
$pdoDB = new DB();

// ====================== ACTION ========================//
$floor = '';
if(isset($_POST['floor'])){
    $floor = $_POST['floor'];
}


// (C) LOOP - CHECK FOR SCORE UPDATES
if(isset($_POST['used'])){
    while (true) {
        $score = $pdoDB->getData($floor);
        if ($score['used'] != $_POST['used'] || $score['capacity'] != $_POST['capacity']) {
            echo json_encode($score);
            break;
        }
        sleep(1);
    }
}else{
    echo json_encode(array("used" => 0));
}
