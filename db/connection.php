<?php
// (A) SETTINGS - CHANGE THESE TO YOUR OWN!
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'ev_charging_db');
// define('DB_CHARSET', 'utf8');
// define('DB_USER', 'smartpay');
// define('DB_PASSWORD', 'smartpay@DEV');

define('DB_HOST', 'localhost');
define('DB_NAME', 'ev_charging_db');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'rnd');
define('DB_PASSWORD', 'smartpay@DEV');
set_time_limit(30); // Set the appropriate time limit
ignore_user_abort(false); // Stop when polling breaks

// (B) DATABASE CLASS
class DB
{
    public $pdo = null;
    public $stmt = null;
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
}
