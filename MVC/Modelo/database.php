<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "carkey";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}
?>
