<?php 

    //Headers
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json'); 
    header('Access-Control-Allow-Methods: POST'); 
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 
    
    include_once '../../config/Database.php';
    include_once '../../models/ExamenClinique.php';
    include_once '../../Token/token.php';

    if (Token::verifier()) {
        // Instantiate DB & connect 
        $database = new Database(); 
        $db = $database->connect(); 
    
        // Instantiate examenClinique object
        $examenClinique = new ExamenClinique($db); 
    
        // Get raw examenClinique data 
        $data = json_decode(file_get_contents("php://input"));
    
        $examenClinique->poids = $data->poids;
        $examenClinique->taille = $data->taille;
        $examenClinique->IMC = $data->IMC;
        $examenClinique->temperature = $data->temperature;
        $examenClinique->dossier_id = $data->dossier_id;
        
    
         // Create examenClinique 
         if($examenClinique->create()){
             http_response_code(201);
             echo json_encode(
                 array('message'=>'examenClinique Created')
             );
         } else {
             echo json_encode(
                 array('message'=>'examenClinique not created')
                );
                http_response_code(400);
         }
    } else {
        //http_response_code(400);
        echo json_encode(array('message' => 'invalide token'));
    }


     