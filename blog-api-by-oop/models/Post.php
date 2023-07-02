<?php

class Post{
    private $conn;
    private $table = "posts";

    public $id;
    public $category_id;
    public $title;
    public $body;
    public $author;
    public $created_at;

    function __construct($db)
    {
        $this->conn = $db;
    }

    /* Read Data all */
    public function read()
    {
        $sql = "SELECT c.cateogry_name as category_name, p.category_id, p.title, p.body, p.author, p.created_at" .
               "FROM " . $this->table . ' p '.
               " LEFT JOIN categories c 
               ON c.id = p.category_id 
               ORDER BY p.id DESC";
               
               /* Prepare Statement */
               $stmt = $this->conn->prepare($sql);
               /* Execute Statement */
               $stmt->execute();
               return $stmt;
    }

    public function read_single()
    {
        $sql = "SELECT c.cateogry_name as category_name, p.category_id, p.title, p.body, p.author, p.created_at" .
        " FROM " . $this->table . " p " .
        " LEFT JOIN categories c ON p.category_id = c." . 
        " WHERE id = ?" . 
        " LIMIT 0,1";

        /* Prepare Statement */
        $stmt = $this->conn->prepare($sql);
        /* Bind Para-meter */
        $stmt->bindParam('id', $this->id);
        /* Statement Execute */
        $stmt->execute();
        /* Data fetching from database */
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set Properties to Properties
        
        $this->id = $row['id'];
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->created_at = $row['created_at'];

    }
}