<?php

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Utilisateur.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate user object
    $user = new Utilisateur($db);

    // Get raw user data
    $data = json_decode(file_get_contents("php://input"));

    $user->nom = $data->nom;
    $user->prenom = $data->prenom;
    $user->naissance = $data->naissance;
    $user->email = $data->email;
    $user->password = password_hash($data->password, PASSWORD_BCRYPT);
    $user->adresse = $data->adresse;
    $user->gsm = $data->gsm;
    $user->sexe = $data->sexe;
    $user->role = $data->role;

     // Create user
     if($user->create()){
         http_response_code(201);
         echo json_encode(
             array('message'=>'User Created')
         );
     } else {
        // http_response_code(400);
        echo json_encode(
            array('message'=>'User not created')
        );
     }
