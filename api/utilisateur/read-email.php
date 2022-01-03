<?php 

    //Headers
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json');
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
        $user->email = $data->email;
    
        // Get user
        $user->read_single_email(); 
    
        // Create array
        $user_arr = array(
            'id' => $user->id,
            'nom' => $user->nom,
            'prenom' => $user->prenom,
            'sexe' => $user->sexe,
            'adresse' => $user->adresse,
            'email' => $user->email,
            'gsm' => $user->gsm,
            'naissance' => $user->naissance
        );
    
        // Make JSON
        http_response_code(200);
        print_r(json_encode($user_arr));
    } else {
        //http_response_code(400);
        echo json_encode(array('message' => 'invalide token'));
    }
