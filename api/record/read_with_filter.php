<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include '../../config/Database.php';
    include '../../models/Record.php';

    // Instantiation of DB & connection
    $database = new Database();
    $db = $database->connect();


    $genre = isset($_GET['genre']) ? $_GET['genre'] : die();

    // Instantiate Record object (interface to the Record Table)
    $record = new Record($db);

    // Recod calling query
    $result = $record->filter($genre);

    if($result->rowCount() > 0) {
        // Records array
        $records_arr = array();
        $records_arr['data'] = array();
        $row = $result->fetch(PDO::FETCH_ASSOC);
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
            array_push($records_arr['data'], $record_item);
            
            $row = $result->fetch(PDO::FETCH_ASSOC);
        }
        $records_arr['message'] = "Successfully fetched records";
        // Turn to JSON 
        echo json_encode($records_arr);
    } else {
        // No Records
        echo json_encode(
            array('message' => 'No Records Found', 'data' => array())
        );
    }
