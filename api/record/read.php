<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include '../../config/Database.php';
    include '../../models/Record.php';

    // Instantiation of DB & connection
    $database = new Database(); // instantiate the Database class, in the Database.php file
    $db = $database->connect(); // now the instance 'database' of the Database class is using the property connect()

    // Instantiate Record object (interface to the Record Table)
    $record = new Record($db); // instance of the record class, passing $db to the parameter constructor

    // Recod calling query
    $result = $record->read(); // the record object execute the read() funcion that internally executes the query!

    if($result->rowCount() > 0) {
        $data = array(); // the map is given a name 'data'
        $row = $result->fetch(PDO::FETCH_ASSOC); // composing the row by 
        while($row) {
            //    extract($row);
            $record_item = array(
                'record_id' => $row['RECORD_ID'],
                'artist' => $row['ARTIST'],
                'album' => $row['ALBUM'],
                'released' => $row['RELEASED'],
                'label' => $row['LABEL'],
                'cover' => $row['COVER'],
                'genre' => $row['GENRE'], 
                'onsale' => $row['ONSALE'],
                'price' => $row['PRICE']
            );
            // push to 'data'
            array_push($data, $record_item);
            
            $row = $result->fetch(PDO::FETCH_ASSOC);
        }

        // Turn to JSON 
        echo json_encode(
            array(
                'message' => "Successfully fetched records",
                'data' => $data,
                'success' => true
                
            )
        );
        //return $result;
    } else {
        // No Records
        echo json_encode(
            array(
                'message' => 'No Records Found',
                'data' => array(),
                'success' => false
            )
        );
    }

    ?>
