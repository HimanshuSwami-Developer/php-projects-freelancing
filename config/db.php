<?php
// config/database.php

class Database {
    
    // private $host = "sql210.infinityfree.com";
    // private $username = "if0_41065730";
    // private $password = "4psdXTQrLXh";
    // private $dbname = "if0_41065730_banke_dress";
    
    // private $host = "localhost";
    // private $username = "admin";
    // private $password = "ddassociate@123";
    // private $dbname = "ereal_state";

    
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "banke_dress";
    public $conn;
    
    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
            
            // Check connection
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
            
            // Set charset to utf8
            $this->conn->set_charset("utf8");
            
        } catch (Exception $e) {
            die("Database connection error: " . $e->getMessage());
        }
        
        return $this->conn;
    }
    
    // Close connection
    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

// Helper function to get database connection
function getDB() {
    $database = new Database();
    return $database->getConnection();
}
?>