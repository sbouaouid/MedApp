<?php 

    //Headers
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json'); 
    header('Access-Control-Allow-Methods: POST'); 
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
    
        $document->description = $data->description;
        $document->type = $data->type;
        $document->dossier_id = $data->dossier_id;
        $document->nom = $data->nom;


        // Create document 
        if($document->create()){
            http_response_code(201);
            echo json_encode(
                array('message'=>'document Created')
            );
        } else {
            echo json_encode(
                array('message'=>'document not created')
            );
            http_response_code(400);
        }
    }else {
        //http_response_code(400);
        echo json_encode(array('message' => 'invalide token'));
    }


     
