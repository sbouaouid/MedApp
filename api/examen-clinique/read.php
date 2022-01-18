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
        $etatGeneral->id = $data->id;
    
        // etatGeneral query
        $result = $etatGeneral->read();
    
        // Get row count 
        $num = $result->rowCount(); 
    
        // Check if any etatGeneral 
        if($num>0){
            // etatGeneral array
            $etatGenerals_arr = array(); 
            $etatGenerals_arr['data'] = array();
    
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
                array_push($etatGenerals_arr['data'], $etatGeneral_item);
            }
    
            // Turn to JSON & output 
            http_response_code(200);
            echo json_encode($etatGenerals_arr);
    
        } else {
            // no etatGeneral
            //http_response_code(404);
            echo json_encode(
                array('message' => 'etatGeneral introuvable ')
            );
        }
    } else {
        //http_response_code(400);
        echo json_encode(array('message' => 'invalide token'));
    }

