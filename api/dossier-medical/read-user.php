<?php 

    // Headers 
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST'); 
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 
     

    include_once '../../config/Database.php';
    include_once '../../models/DossierMedical.php';
    include_once '../../Token/token.php';

    if (Token::verifier()) {
        // DB instanciation and connection 
        $database = new Database(); 
        $db = $database->connect();
    
        // dossierMed object instanciation 
        $dossierMed = new DossierMedical($db); 

        //Get ID
        $data = json_decode(file_get_contents("php://input"));
        $dossierMed->utilisateur_id = $data->utilisateur_id;
    
        // dossierMed query
        $result = $dossierMed->read_user();
    
        // Get row count 
        $num = $result->rowCount(); 
    
        // Check if any dossierMed 
        if($num>0){
            // dossierMed array
            $dossierMeds_arr = array(); 
            $dossierMeds_arr['data'] = array();
    
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                // FETCH_ASSOC permet de renvoyer les donnees indexées par les noms de colonnes 
                // donc on crée un tableau avec les champs voulus
                // puis on les attribus les donnees retournées 
                extract($row);
                $dossierMed_item = array(
                    'id' => $id,
                    'utilisateur_id' => $utilisateur_id,
                );
    
                // Push to 'data'
                array_push($dossierMeds_arr['data'], $dossierMed_item);
            }
    
            // Turn to JSON & output 
            http_response_code(200);
            echo json_encode($dossierMeds_arr);
    
        } else {
            // no dossierMed
            //http_response_code(404);
            echo json_encode(
                array('message' => 'dossierMed introuvable ')
            );
        }
    } else {
        echo json_encode(array('message' => 'invalide token'));
        //http_response_code(400);
    }

