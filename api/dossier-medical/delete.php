<?php 

    //Headers
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json'); 
    header('Access-Control-Allow-Methods: DELETE'); 
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
    
        // Set ID to delete
        $dossierMed->id = $data->id;
    
        // DELETE dossierMed
        if($dossierMed->delete()){
            http_response_code(200);
            echo json_encode(
                array('message'=>'dossierMed Deleted')
            );
        }   else {
            http_response_code(400);
            echo json_encode(
                array('message'=>'dossierMed Not Deleted')
            );
        }
    } else {
       //http_response_code(400);
        echo json_encode(array('message' => 'invalide token'));
    }

