<?php
class Database
{
    //propertiies
    private $host = "localhost";
    private $db_name = "myblog";
    private $username = "root";
    private $password = "elnas";
    private $conn;
    //method to connect 

    public function connect()
    {
        $this->conn = null;
        try {

            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException  $e) {

            echo "Connection Error:" . $e->getMessage();
        }
        return $this->conn;
    }
}
