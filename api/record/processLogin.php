<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include '../../models/Record.php';
    include '../../config/Database.php';

    session_start(); // This function returns true if a session was successfully started, otherwise false.
    // if already logged-in
    if(isset($_SESSION['isLoggedIn'])){
        header('Location: ../../frontend/index.html');
        exit();
    }
    if (isset($_POST['login'])){
        // Instantiation of DB & connection
        $database = new Database();
        $db = $database->connect();

        $record = new Record($db);

        $email = $_POST['emailPHP'];
        $password =  $_POST['passwordPHP'];

        $data = $record->getEmailAndPassword($email,$password);

        if($data->rowCount() > 0){
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['email']=$email;
            exit('success');
        }else{
            exit('Failed');
        }
        // exit($email . " = " . $password);
    }

   
?>