<?php 

    //Headers
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json'); 
    header('Access-Control-Allow-Methods: POST'); 
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 
    
    include_once '../../config/Database.php';
    include_once '../../models/RendezVous.php';

    // Instantiate DB & connect 
    $database = new Database(); 
    $db = $database->connect(); 

    // Instantiate rdv object
    $rdv = new RendezVous($db); 

    // Get raw rdv data 
    $data = json_decode(file_get_contents("php://input"));

    $rdv->date = $data->date;
    $rdv->utilisateur_id = $data->utilisateur_id;
    

     // Create rdv 
     if($rdv->create()){
         echo json_encode(
             array('message'=>'RDV Created')
         );
     } else {
        echo json_encode(
            array('message'=>'RDV not created')
        );
     }

     