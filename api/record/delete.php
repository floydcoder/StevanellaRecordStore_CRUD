<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include '../../config/Database.php';
    include '../../models/Record.php';

    // Instantiation of DB & connection
    $database = new Database();
    $db = $database->connect();

    // url query paramater
    $id = isset($_GET['id']) ? $_GET['id'] : die();

    // Instantiate Record Gateway to Database Table (would be like a door)
    $record = new Record($db);

    if($record->delete($id)){
        http_response_code(200);
        echo json_encode(
            array('message' => 'Record Deleted')
        );
    }else{
        http_response_code(404);
        echo json_encode(
            array('message' => 'Record Not Deleted')
        );
    }

    // Instantiate Record object (interface to the record table)

    