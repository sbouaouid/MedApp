<?php

    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Utilisateur.php';
    include_once '../../Token/token.php';

    if (Token::verifier()) {
        // Instantiate DB & connect
        $database = new Database();
        $db = $database->connect();

        // Instantiate User Object
        $user = new Utilisateur($db);

        // Get ID
        $data = json_decode(file_get_contents("php://input"));
        $user->id = $data->id;

        // Get user
        $result = $user->read_single();


        $num = $result->rowCount(); 
    
        // Check if any user 
        if($num>0){
            // user array
            $users_arr = array();
    
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                // FETCH_ASSOC permet de renvoyer les donnees indexées par les noms de colonnes 
                // donc on crée un tableau avec les champs voulus
                // puis on les attribus les donnees retournées 
                extract($row);
                $user_item = array(
                    'id' => $id,
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'sexe' => $sexe,
                    'adresse' => $adresse,
                    'email' => $email,
                    'gsm' => $gsm,
                    'naissance' => $naissance
                );
    
                // Push to 'data'
                array_push($users_arr, $user_item);
            }
    
            // Turn to JSON & output 
            http_response_code(200);
            echo json_encode($users_arr);

    } else {
        //http_response_code(400);
        echo json_encode(array('message' => 'invalide token'));
    }
}