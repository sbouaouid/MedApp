<?php 

    // Headers 
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST'); 
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 
     

    include_once '../../config/Database.php';
    include_once '../../models/EtatGeneral.php';
    include_once '../../Token/token.php';

    if (Token::verifier()) {
        // DB instanciation and connection 
        $database = new Database(); 
        $db = $database->connect();
    
        // etatGeneral object instanciation 
        $etatGeneral = new EtatGeneral($db); 

        //Get ID
        $data = json_decode(file_get_contents("php://input"));
        $etatGeneral->dossier_id = $data->dossierId;
    
        // etatGeneral query
        $result = $etatGeneral->read_dossier();
    
        // Get row count 
        $num = $result->rowCount(); 
    
        // Check if any etatGeneral 
        if($num>0){
            // etatGeneral array
            $etatGenerals_arr = array();
    
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                // FETCH_ASSOC permet de renvoyer les donnees indexées par les noms de colonnes 
                // donc on crée un tableau avec les champs voulus
                // puis on les attribus les donnees retournées 
                extract($row);
                $etatGeneral_item = array(
                    'id' => $id,
                    'antecedentsFamiliaux' => $antecedentsFamiliaux,
                    'antecedentsMedicaux' => $antecedentsMedicaux,
                    'antecedentsChirurgicaux' => $antecedentsChirurgicaux,
                    'habitudesAlcoloTabagiques' => $habitudesAlcoloTabagiques,
                    'dossier_id' => $dossier_id,
                );
    
                // Push to 'data'
                array_push($etatGenerals_arr, $etatGeneral_item);
            }
    
            // Turn to JSON & output 
            echo json_encode($etatGenerals_arr);
            http_response_code(200);
    
        } else {
            // no etatGeneral
            echo json_encode(
                array('message' => 'etatGeneral introuvable ')
            );
            http_response_code(404);
        }
    } else {
        echo json_encode(array('message' => 'invalide token'));
        //http_response_code(400);
    }

