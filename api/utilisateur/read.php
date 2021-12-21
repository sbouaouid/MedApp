<?php 

    // Headers 
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json'); 

    include_once '../../config/Database.php';
    include_once '../../models/Utilisateur.php'; 

    // DB instanciation and connection 
    $database = new Database(); 
    $db = $database->connect();

    // User object instanciation 
    $user = new Utilisateur($db); 

    // User query
    $result = $user->read();

    // Get row count 
    $num = $result->rowCount(); 

    // Check if any user 
    if($num>0){
        // User array
        $users_arr = array(); 
        $users_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            // FETCH_ASSOC permet de renvoyer les donnees indexées par les noms de colonnes 
            // donc on crée un tableau avec les champs voulus
            // puis on les attribus les donnees retournées 
            extract($row);
            $user_item = array(
                'nom' => $nom,
                'prenom' => $prenom,
                'sexe' => $sexe,
                'adresse' => $adresse,
                'email' => $email,
                'gsm' => $gsm,
                'naissance' => $naissance
            );

            // Push to 'data'
            array_push($users_arr['data'], $user_item);
        }

        // Turn to JSON & output 
        echo json_encode($users_arr);

    } else {
        // no users 
        echo json_encode(
            array('message' => 'Patients introuvables ')
        );
    }
