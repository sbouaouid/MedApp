<?php 

    // Headers 
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST'); 
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With'); 
     

    include_once '../../config/Database.php';
    include_once '../../models/Document.php';
    include_once '../../Token/token.php';

    if (Token::verifier()) {
        // DB instanciation and connection 
        $database = new Database(); 
        $db = $database->connect();
    
        // document object instanciation 
        $document = new Document($db); 

        //Get ID
        $data = json_decode(file_get_contents("php://input"));
        $document->id = $data->id;
    
        // document query
        $result = $document->read();
    
        // Get row count 
        $num = $result->rowCount(); 
    
        // Check if any document 
        if($num>0){
            // document array
            $documents_arr = array(); 
            $documents_arr['data'] = array();
    
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                // FETCH_ASSOC permet de renvoyer les donnees indexées par les noms de colonnes 
                // donc on crée un tableau avec les champs voulus
                // puis on les attribus les donnees retournées 
                extract($row);
                $document_item = array(
                    'id' => $id,
                    'nom' => $nom,
                    'description' => $description,
                    'type' => $type,
                    'dossier_id' => $dossier_id,
                );
    
                // Push to 'data'
                array_push($documents_arr['data'], $document_item);
            }
    
            // Turn to JSON & output 
            http_response_code(200);
            echo json_encode($documents_arr);
    
        } else {
            // no document
            //http_response_code(404);
            echo json_encode(
                array('message' => 'document introuvable ')
            );
        }
    } else {
        //http_response_code(400);
        echo json_encode(array('message' => 'invalide token'));
    }

