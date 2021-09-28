<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
    

    include '../../config/Database.php';
    include '../../models/Record.php';

    // instantiation of Database and connection
    $database = new Database();
    $db = $database->connect();

    // instantiate the record class
    $record = new Record($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // class record executes Create() method - (where the query is contained)
    // $artist = htmlspecialchars(strip_tags($data->artist))
    $succeeded = $record->create($data->artist, $data->album, (int)$data->released, $data->label, $data->cover, $data->genre, $data->price, $data->onsale);

    if ($succeeded) {
        echo json_encode(
            array('message' => 'Record Created', 'success' => true)
        );
    } else {
        echo json_encode(
            array('message' => 'Failed to Create Record', 'success' => false)
        );
    }
