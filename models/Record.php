<?php
    // the creation of a class 'record'
    class Record {
        private $table = 'records';
        private $tableLogin = 'login';
        private $conn;

        public function __construct($db) { // a constructor that asks for a $db parameter 
            $this->conn = $db;
        }

        // ----- CRUD operations (Create / Read / Update / Delete) ------

        // Get (read) Records
        public function read() {
            // Create query
            $query = 'SELECT * FROM ' .  $this->table . ' r ORDER BY r.RECORD_ID ASC';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query); // prepare the query for execution, if no error it returns a statement, otherwise FALSE

            // Execute query
            $stmt->execute(); // execute a previously prepared statement, Returns true on success or false on failure.
            return $stmt;
        }

        // Get Records by genre
        public function filter($genre) {
            // Create query
            $query = 'SELECT * FROM ' .  $this->table . " r  WHERE genre = ? ORDER BY r.RECORD_ID DESC" ;
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            // Bind genre
            $stmt->bindParam(1, $genre);
            // Execute query
            $stmt->execute();
            return $stmt;
        }
        // CREATE RECORD
        public function create($artist, $album, $released, $label, $cover, $genre, $price, $onsale){
            $query = 'INSERT INTO ' . $this->table .'
                SET
                    ARTIST = :artist,
                    ALBUM = :album,
                    RELEASED = :released,
                    LABEL = :label,
                    COVER = :cover,
                    GENRE = :genre,
                    PRICE = :price,
                    ONSALE = :onsale';
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':artist', $artist);
            $stmt->bindParam(':album', $album);
            $stmt->bindParam(':released', $released);
            $stmt->bindParam(':label', $label);
            $stmt->bindParam(':cover', $cover);
            $stmt->bindParam(':genre', $genre);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':onsale', $onsale);
            
            // execute statement
            if($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
        

        // Update Record
        public function update($id, $artist, $album, $released, $label, $cover, $genre, $price, $onsale){
            // create query
            $queryUpdate = 'UPDATE ' . $this->table . '
                SET
                    ARTIST = :artist,
                    ALBUM = :album,
                    RELEASED = :released,
                    LABEL = :label,
                    COVER = :cover,
                    GENRE = :genre,
                    PRICE = :price,
                    ONSALE = :onsale
                WHERE 
                    RECORD_ID = :id';

            $stmt = $this->conn->prepare($queryUpdate);

            // Bind data
            $stmt->bindParam(':artist', $artist);
            $stmt->bindParam(':album', $album);
            $stmt->bindParam(':released', $released);
            $stmt->bindParam(':label', $label);
            $stmt->bindParam(':cover', $cover);
            $stmt->bindParam(':genre', $genre);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':onsale', $onsale);
            $stmt->bindParam(':id', $id);
            
            // execute statement
            if($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }           

        // DELETE Record

        public function delete($id){
            // create query
            $queryDelete = ' DELETE FROM ' . $this->table . ' WHERE '. $this->table .'.RECORD_ID = :id';
            // prepare statement
            $stmt = $this->conn->prepare($queryDelete);
            // clean data
            $id = htmlspecialchars(strip_tags($id));
            // bind id
            $stmt->bindParam(':id', $id);

            // execute statement
            if($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function getEmailAndPassword($email,$password){
            // CREATE 
            $queryUser = ' SELECT * FROM ' . $this->tableLogin . ' WHERE ' . $this->tableLogin . '.EMAIL = :email && ' . $this->tableLogin . '.PASSWORD = :password';
            // PREPARE
            $stmt = $this->conn->prepare($queryUser);
            // BIND
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            // EXECUTE
            $stmt->execute();
            return $stmt;
        }

    }

    ?>