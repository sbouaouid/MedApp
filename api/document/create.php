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
        $data = json_decode(file_get_contents("php://input"), true);
    
        //$_FILES is an associative array containing items uploaded via HTTP POST method
        $fileName = $_FILES['file']['name'];
        $tempPath  =  $_FILES['file']['tmp_name'];
        $fileSize  =  $_FILES['file']['size'];

        $document->description = $data->description;
        $document->type = $data->type;
        $document->dossier_id = $data->dossier_id;
        $document->nom = $fileName;


        if(empty($fileName))
        {
            $errorMSG = json_encode(array("message" => "please select file", "status" => false));	
            echo $errorMSG;
        }
        else
        {
            $upload_path = '../../upload'; // set upload folder path 
            
            $fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get extension extension
                
            // valid file extensions
            $valid_extensions = array('doc','pdf','jpeg', 'jpg', 'png'); 
                            
            // allow valid file formats
            if(in_array($fileExt, $valid_extensions))
            {				
                //check file not exist our upload folder path
                if(!file_exists($upload_path . $fileName))
                {
                    // check file size '5MB'
                    if($fileSize < 5000000){
                        move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path 
                    }
                    else{		
                        $errorMSG = json_encode(array("message" => "Sorry, your file is too large, please upload 5 MB size", "status" => false));	
                        echo $errorMSG;
                    }
                }
                else
                {		
                    $errorMSG = json_encode(array("message" => "Sorry, file already exists check upload folder", "status" => false));	
                    echo $errorMSG;
                }
            }
            else
            {		
                $errorMSG = json_encode(array("message" => "Sorry, only DOC, PDF, JPG, JPEG, PNG files are allowed", "status" => false));	
                echo $errorMSG;		
            }
        }
           

        if(!isset($errorMSG))
        {
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
        }


    } else {
        //http_response_code(400);
        echo json_encode(array('message' => 'invalide token'));
    }


     
