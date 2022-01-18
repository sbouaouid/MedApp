<?php 

    //Headers
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json'); 
    header('Access-Control-Allow-Methods: POST'); 
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 
    
    include_once '../../config/Database.php';
    include_once '../../models/DossierMedical.php';
    include_once '../../Token/token.php';

    if (Token::verifier()) {
        // Instantiate DB & connect 
        $database = new Database(); 
        $db = $database->connect(); 
    
        // Instantiate dossierMed object
        $dossierMed = new DossierMedical($db); 
    
        // Get raw dossierMed data 
        $data = json_decode(file_get_contents("php://input"));
    
        $dossierMed->utilisateur_id = $data->utilisateur_id;
        
         // Create dossierMed 
         if($dossierMed->create()){
             http_response_code(201);
             echo json_encode(
                 array('message'=>'dossierMed Created')
             );
         } else {
             echo json_encode(
                 array('message'=>'dossierMed not created')
                );
                http_response_code(400);
         }
    } else {
        //http_response_code(400);
        echo json_encode(array('message' => 'invalide token'));
    }


     