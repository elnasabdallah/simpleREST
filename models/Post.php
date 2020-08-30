<?php
class Post
{

    //db stuff
    private $conn;
    private $table = "posts";
    //post properties
    public $id;
    public $title;
    public $category_id;
    public $category_name;
    public $body;
    public $author;
    public $created_at;
    //constructor

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //get posts
    public function read()
    {
        //create query

        $query = 'SELECT 
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
    FROM ' . $this->table . ' p
    LEFT JOIN 
    categories c ON p.category_id=c.id
    ORDER BY
    p.created_at DESC
        ';
        //prepare
        $stmt = $this->conn->prepare($query);
        //Execute

        $stmt->execute();
        return $stmt;
    }

    //read single post
    public function read_single()
    {
        //create query

        $query = 'SELECT 
    c.name as category_name,
    p.id,
    p.category_id,
    p.title,
    p.body,
    p.author,
    p.created_at
FROM ' . $this->table . ' p
LEFT JOIN 
    categories c ON p.category_id=c.id
WHERE p.id=?
LIMIT 0,1
    ';
        //prepare
        $stmt = $this->conn->prepare($query);
        //Execute
        //bind
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        //return $stmt;

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //set properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    //creating a post
    public function create()
    {
        //create query

        $query = 'INSERT INTO ' . $this->table . '
        SET  
            title=:title,
            body=:body,
            author=:author,
            category_id=:category_id  
        ';
        // $query = 'INSERT INTO ' . $this->table . ' SET title = :title, body = :body, author = :author, category_id = :category_id';
        //prepare statement

        $stmt = $this->conn->prepare($query);

        //clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->body = htmlspecialchars(strip_tags($this->body));

        //binding the named params
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

        //execute
        if ($stmt->execute()) {
            return true;
        } else {
            //print error if something goes wrong

            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
    //updating a post
    public function update()
    {
        //create query

        $query = 'UPDATE ' . $this->table . '
         SET  
             title=:title,
             body=:body,
             author=:author,
             category_id=:category_id  
         WHERE id=:id
             ';
        //prepare statement

        $stmt = $this->conn->prepare($query);

        //clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //binding the named params
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        //execute
        if ($stmt->execute()) {
            return true;
        } else {
            //print error if something goes wrong

            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    //delete post

    public function delete()
    {
        //create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id=:id';
        //prepare
        $stmt = $this->conn->prepare($query);
        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        //bind data
        $stmt->bindParam(':id', $this->id);

        //execute
        if ($stmt->execute()) {
            return true;
        } else {
            //print error if something goes wrong

            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}
