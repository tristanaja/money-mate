<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Database
{
    private $host;
    private $dbName;
    private $username;
    private $password;

    private $db;

    public function __construct()
    {

        $this->host = $_ENV['DB_HOST'] ?? "";
        $this->dbName = $_ENV['DB_NAME'] ?? "";
        $this->username = $_ENV['DB_USERNAME'] ?? "";
        $this->password = $_ENV['DB_PASSWORD'] ?? "";
    }

    public function connect()
    {
        $this->db = new mysqli($this->host, $this->username, $this->password, $this->dbName);
        if ($this->db->connect_error) {
            die("Connection Failed:" . $this->db->connect_error);
        }
        return $this->db;
    }
}
