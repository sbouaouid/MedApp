<?php 

    //Headers
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json'); 
    header('Access-Control-Allow-Methods: DELETE'); 
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 
    
    include_once '../../config/Database.php';
    include_once '../../models/Document.php';
    include_once '../../Token/token.php';

    if (Token::verifier()) {
        // Instantiate DB & connect 
        $database = new Database(); 
        $db = $database->connect(); 
    
        // Instantiate document object 
        $document = new Document($db); 
    
        // Get raw document data 
        $data = json_decode(file_get_contents("php://input"));
    
        // Set ID to delete
        $document->id = $data->id;
    
        // DELETE document
        if($document->delete()){
            http_response_code(200);
            echo json_encode(
                array('message'=>'document Deleted')
            );
        }   else {
            http_response_code(400);
            echo json_encode(
                array('message'=>'document Not Deleted')
            );
        }
    } else {
       //http_response_code(400);
        echo json_encode(array('message' => 'invalide token'));
    }

