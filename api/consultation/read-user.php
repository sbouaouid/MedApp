<?php 

    // Headers 
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST'); 
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 
     

    include_once '../../config/Database.php';
    include_once '../../models/Consultation.php';
    include_once '../../Token/token.php';

    if (Token::verifier()) {
        // DB instanciation and connection 
        $database = new Database(); 
        $db = $database->connect();
    
        // consultation object instanciation 
        $consultation = new Consultation($db); 

        //Get ID
        $data = json_decode(file_get_contents("php://input"));
        $consultation->utilisateur_id = $data->utilisateur_id;
    
        // Consultation query
        $result = $consultation->read_user();
    
        // Get row count 
        $num = $result->rowCount(); 
    
        // Check if any consultation 
        if($num>0){
            // consultation array
            $consultations_arr = array(); 
            $consultations_arr['data'] = array();
    
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                // FETCH_ASSOC permet de renvoyer les donnees indexées par les noms de colonnes 
                // donc on crée un tableau avec les champs voulus
                // puis on les attribus les donnees retournées 
                extract($row);
                $consultation_item = array(
                    'id' => $id,
                    'consultation_date' => $consultation_date,
                    'consultation_remarque' => $consultation_remarque,
                    'utilisateur_id' => $utilisateur_id,
                );
    
                // Push to 'data'
                array_push($consultations_arr['data'], $consultation_item);
            }
    
            // Turn to JSON & output 
            http_response_code(200);
            echo json_encode($consultations_arr);
    
        } else {
            // no consultation
            //http_response_code(404);
            echo json_encode(
                array('message' => 'Consultation introuvable ')
            );
        }
    } else {
        echo json_encode(array('message' => 'invalide token'));
        //http_response_code(400);
    }

