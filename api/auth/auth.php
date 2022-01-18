<?php

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Utilisateur.php';
    include_once '../../Token/token.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate User Object
    $user = new Utilisateur($db);

    // Get email
    $data = json_decode(file_get_contents("php://input"));
    $user->email = $data->email;
    $password = $data->password;

    // Get user
    $user->read_single_email();

    //Verify the password

    if (password_verify($password, $user->password)) {
        // Create array
        $user_arr = array(
            'id' => $user->id,
            'nom' => $user->nom,
            'prenom' => $user->prenom,
            'sexe' => $user->sexe,
            'adresse' => $user->adresse,
            'email' => $user->email,
            'gsm' => $user->gsm,
            'naissance' => $user->naissance,
            'role' => $user->role
        );
        if (Token::auth()) {
            http_response_code(200);
            echo json_encode(array($user_arr, Token::auth()));
        } else {
            http_response_code(400);
            echo json_encode(
                array(
                    'type'=> "error",
                    'title'=> "faild",
                    'message'=>"pas de token, veuillez contacter votre admin"
                )
            );
        }
    } else {
        echo json_encode(array("message"=>"le mot de passe est invalide"));
        http_response_code(400);
    }

?>
