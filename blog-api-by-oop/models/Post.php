<?php
class Post{
    private $conn;
    private $table = "posts";
    public $id;
    public $category_id;
    public $category_name;
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
        $sql = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
        FROM ' . $this->table . ' p
        LEFT JOIN
          categories c ON p.category_id = c.id
        ORDER BY
          p.created_at DESC';
               
               // Prepare statement
      $stmt = $this->conn->prepare($sql);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    public function read_single()
    {
        $sql = "SELECT c.name as category_name, p.category_id, p.title, p.body, p.author, p.created_at
         FROM  $this->table p 
         LEFT JOIN categories c ON p.category_id = c.id  
         WHERE p.id = ? 
        LIMIT 0,1";

        /* Prepare Statement */
        $stmt = $this->conn->prepare($sql);
        /* Bind Para-meter */
        $stmt->bindParam(1, $this->id);
        /* Statement Execute */
        $stmt->execute();
        /* Data fetching from database */
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set Properties to Properties

        // $this->id = $row['id'];
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];

    }


    public function create()
    {
        $sql = "INSERT INTO $this->table SET title = :title, body = :body, author = :author, category_id = :category_id";
        $stmt = $this->conn->prepare($sql);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        /* Bind Data */

        $stmt->bindParam(':title',$this->title);
        $stmt->bindParam(':body',$this->body);
        $stmt->bindParam(':author',$this->author);
        $stmt->bindParam(':category_id',$this->category_id);
       
        if($stmt->execute()){
            return true;
            
        }else{
            printf("Error: %s. \n",$stmt->error);
            return false;
        }
    }

    /* Update Post Here */

    public function update()
    {
        $sql = "UPDATE $this->table SET title = :title,body = :body, author = :author, category_id = :category_id WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        /* Input Data Validation Here */
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        /* Bind Param Here */
        $stmt->bindParam(':title',$this->title);
        $stmt->bindParam(':body',$this->body);
        $stmt->bindParam(':author',$this->author);
        $stmt->bindParam(':category_id',$this->category_id);
        $stmt->bindParam(':id',$this->id);

        if($stmt->execute()){
            return true;
        }else{
            printf("Error: %s \n $stmt->error");
            return false;
        }
    }

    /* Delete Data Here */

    public function delete()
    {
        $sql = "DELETE FROM $this->table WHERE id= :id";

        $stmt = $this->conn->prepare($sql);

        /* Data Validation */
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id',$this->id);

        /* Execute the Prepare Statement */
        if($stmt->execute()){
            return true;
        }else{
            printf("Error: %s /n $stmt->error");
            return true;
        }

    }
}