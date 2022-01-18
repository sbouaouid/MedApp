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
    
        // Set ID to update
        $dossierMed->id = $data->id;

        $dossierMed->utilisateur_id = $data->utilisateur_id;
    
    
         // Update dossierMed 
         if($dossierMed->update()){
             http_response_code(203);
             echo json_encode(
                 array('message'=>'dossierMed updated')
             );
         } else {
             http_response_code(400);
            echo json_encode(
                array('message'=>'dossierMed not updated')
            );
         } 
    } else {
        //http_response_code(400);
        echo json_encode(array('message' => 'invalide token'));
    }


     