<?php 

    // Headers 
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json'); 

    include_once '../../config/Database.php';
    include_once '../../models/RendezVous.php';
    include_once '../../Token/token.php';

    if (Token::verifier()) {
        // DB instanciation and connection 
        $database = new Database(); 
        $db = $database->connect();
    
        // rdv object instanciation 
        $rdv = new RendezVous($db); 
    
        // RDV query
        $result = $rdv->read();
    
        // Get row count 
        $num = $result->rowCount(); 
    
        // Check if any rdv 
        if($num>0){
            // rdv array
            $rdvs_arr = array(); 
            $rdvs_arr['data'] = array();
    
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                // FETCH_ASSOC permet de renvoyer les donnees indexées par les noms de colonnes 
                // donc on crée un tableau avec les champs voulus
                // puis on les attribus les donnees retournées 
                extract($row);
                $rdv_item = array(
                    'rdv_date' => $rdv_date,
                    'utilisateur_id' => $utilisateur_id,
                );
    
                // Push to 'data'
                array_push($rdvs_arr['data'], $rdv_item);
            }
    
            // Turn to JSON & output 
            http_response_code(200);
            echo json_encode($rdvs_arr);
    
        } else {
            // no rdv
            http_response_code(404);
            echo json_encode(
                array('message' => 'RDV introuvables ')
            );
        }
    } else {
        http_response_code(400);
        echo json_encode(array('message' => 'invalide token'));
    }

