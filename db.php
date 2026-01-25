<?php
// config/database.php

class Database {
    
    //   private $host = "sql206.infinityfree.com";
    //  private $username = "if0_40766948";
    //  private $password = "Goku1234ss3";
    //  private $dbname = "if0_40766948_sys_tracker";
    

     private $host = "localhost";
    private $username = "root";
    private $password = "";
    // private $dbname = "ereal_state";
    // private $dbname = "attendance_system";
    private $dbname = "attend";
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