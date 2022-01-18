<?php 

    //Headers
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json'); 
    header('Access-Control-Allow-Methods: POST'); 
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 
    
    include_once '../../config/Database.php';
    include_once '../../models/Consultation.php';
    include_once '../../Token/token.php';

    if (Token::verifier()) {
        // Instantiate DB & connect 
        $database = new Database(); 
        $db = $database->connect(); 
    
        // Instantiate consultation object
        $consultation = new RendezVous($db); 
    
        // Get raw consultation data 
        $data = json_decode(file_get_contents("php://input"));
    
        // Set ID to update
        $consultation->id = $data->id;
    
        $consultation->date = $data->date;
        $consultation->remarque = $data->remarque;
        $consultation->utilisateur_id = $data->utilisateur_id;
    
    
         // Update consultation 
         if($consultation->update()){
             http_response_code(203);
             echo json_encode(
                 array('message'=>'consultation updated')
             );
         } else {
             http_response_code(400);
            echo json_encode(
                array('message'=>'consultation not updated')
            );
         } 
    } else {
        //http_response_code(400);
        echo json_encode(array('message' => 'invalide token'));
    }


     