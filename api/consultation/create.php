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
        $consultation = new Consultation($db); 
    
        // Get raw consultation data 
        $data = json_decode(file_get_contents("php://input"));
    
        $consultation->date = $data->date;
        $consultation->remarque = $data->remarque;
        $consultation->utilisateur_id = $data->utilisateur_id;
        
    
         // Create consultation 
         if($consultation->create()){
             http_response_code(201);
             echo json_encode(
                 array('message'=>'consultation Created')
             );
         } else {
             http_response_code(400);
            echo json_encode(
                array('message'=>'consultation not created')
            );
         }
    } else {
        //http_response_code(400);
        echo json_encode(array('message' => 'invalide token'));
    }


     