<?php

  class Database {
    private $db_host = 'localhost'; 
    private $db_name = 'php_blog_api';
    private $db_user = 'root';
    private $db_password = '';
    private $conn;
    public function connect()
    {
        $this->conn = null;

        try{

            $this->conn = new PDO('mysql:host=' . $this->db_host . ';dbname=' . $this->db_name,$this->db_user,$this->db_password);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $err){
            echo "connection Error" . $err->getMessage();
        }

        return $this->conn;

    }

   

}
  