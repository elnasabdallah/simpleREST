<?php
class Category
{
    private $conn;
    private $table = "categories";
    public $id;
    public $name;
    public $created_at;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = 'SELECT * FROM ' .  $this->table;

        $stmnt = $this->conn->prepare($query);
        $stmnt->execute();

        return $stmnt;
    }


    public function read_single()
    {
        $query = 'SELECT * FROM ' .  $this->table . ' WHERE id=:id';

        $stmnt = $this->conn->prepare($query);
        $stmnt->execute(["id" => $this->id]);

        $row = $stmnt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->created_at = $row['created_at'];
    }
    public function create()
    {

        $query = 'INSERT INTO ' . $this->table . '
            SET name=:name
        
        ';
        $this->name = htmlspecialchars(strip_tags($this->name));
        $stmnt = $this->conn->prepare($query);
        $stmnt->execute(['name' => $this->name]);

        if ($stmnt) {
            return true;
        } else {
            return false;
            echo "Error";
        }
    }
}
