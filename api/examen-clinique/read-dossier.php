<?php 

    // Headers 
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST'); 
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 
     

    include_once '../../config/Database.php';
    include_once '../../models/ExamenClinique.php';
    include_once '../../Token/token.php';

    if (Token::verifier()) {
        // DB instanciation and connection 
        $database = new Database(); 
        $db = $database->connect();
    
        // examenClinique object instanciation 
        $examenClinique = new ExamenClinique($db); 

        //Get ID
        $data = json_decode(file_get_contents("php://input"));
        $examenClinique->dossier_id = $data->dossierId;
    
        // examenClinique query
        $result = $examenClinique->read_dossier();
    
        // Get row count 
        $num = $result->rowCount(); 
    
        // Check if any examenClinique 
        if($num>0){
            // examenClinique array
            $examenCliniques_arr = array();
    
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                // FETCH_ASSOC permet de renvoyer les donnees indexées par les noms de colonnes 
                // donc on crée un tableau avec les champs voulus
                // puis on les attribus les donnees retournées 
                extract($row);
                $examenClinique_item = array(
                    'id' => $id,
                    'poids' => $poids,
                    'taille' => $taille,
                    'IMC' => $IMC,
                    'temperature' => $temperature,
                    'dossier_id' => $dossier_id,
                );
    
                // Push to 'data'
                array_push($examenCliniques_arr, $examenClinique_item);
            }
    
            // Turn to JSON & output 
            echo json_encode($examenCliniques_arr);
            http_response_code(200);
    
        } else {
            // no examenClinique
            echo json_encode(
                array('message' => 'examenClinique introuvable ')
            );
            http_response_code(404);
        }
    } else {
        echo json_encode(array('message' => 'invalide token'));
        //http_response_code(400);
    }

