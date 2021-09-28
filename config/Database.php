<?php
    // we are creating a class in charge of creating a connection to the database
    class Database {
        // DB Parameters
        private $host = 'localhost';
        private $db_name = 'records';
        private $username = 'root';
        private $password = '123456';
        private $conn;

        // DB connect
        public function connect() {
            $this->conn = null; // initialize the connection to null (in case of previous data contained in it)
            try {
                // a PDO ( PHP DATA OBJECT ) --> lightweight, consistent interface for accessing databases in PHP.
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo 'Connection Error ' . $e->getMessage(); 
            }
            return $this->conn;
        }
    }
   ?>