<?php 

    //Headers
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json'); 
    header('Access-Control-Allow-Methods: POST'); 
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 
    
    include_once '../../config/Database.php';
    include_once '../../models/EtatGeneral.php';
    include_once '../../Token/token.php';

    if (Token::verifier()) {
        // Instantiate DB & connect 
        $database = new Database(); 
        $db = $database->connect(); 
    
        // Instantiate etatGeneral object
        $etatGeneral = new EtatGeneral($db); 
    
        // Get raw etatGeneral data 
        $data = json_decode(file_get_contents("php://input"));
    
        $etatGeneral->antecedentsFamiliaux = $data->antecedentsFamiliaux;
        $etatGeneral->antecedentsMedicaux = $data->antecedentsMedicaux;
        $etatGeneral->antecedentsChirurgicaux = $data->antecedentsChirurgicaux;
        $etatGeneral->habitudesAlcoloTabagiques = $data->habitudesAlcoloTabagiques;
        $etatGeneral->dossier_id = $data->dossier_id;
        
    
         // Create etatGeneral 
         if($etatGeneral->create()){
             http_response_code(201);
             echo json_encode(
                 array('message'=>'etatGeneral Created')
             );
         } else {
             echo json_encode(
                 array('message'=>'etatGeneral not created')
                );
                http_response_code(400);
         }
    } else {
        //http_response_code(400);
        echo json_encode(array('message' => 'invalide token'));
    }


     