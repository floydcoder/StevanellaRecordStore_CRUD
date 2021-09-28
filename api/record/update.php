<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
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
    $succeeded = $record->update((int) $data->id,$data->artist, $data->album,(int) $data->released, $data->label, $data->cover, $data->genre, $data->price, $data->onsale);

    if ($succeeded) {
        http_response_code(201);
        echo json_encode(
            array('message' => 'Record Updated', 'success' => true)
        );
    } else {
        http_response_code(404);
        echo json_encode(
            array('message' => 'Failed to Update Record', 'success' => false)
        );
    }