<?php

namespace Foroupna\Models;

use mysqli;

class Database
{

    private static ?Database $instance = null;
    private mysqli $conn;

    private function __construct()
    {
        require_once __DIR__ . "/../config/config.php";

        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

        if ($this->conn->connect_errno) {
            echo "Error occurred with MySQL: (" . $this->conn->connect_errno . ") " . $this->conn->connect_error;
        }

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): mysqli
    {
        return $this->conn;
    }
}
