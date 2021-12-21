<?php 

    //Headers
    header('Access-Control-Allow-Origin: *'); 
    header('Content-Type: application/json'); 

    include_once '../../config/Database.php';
    include_once '../../models/Utilisateur.php';

    // Instantiate DB & connect 
    $database = new Database(); 
    $db = $database->connect(); 

    // Instantiate User Object
    $user = new Utilisateur($db); 

    // Get ID
    $user->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get user
    $user->read_single(); 

    // Create array
    $user_arr = array(
        'nom' => $user->nom,
        'prenom' => $user->prenom,
        'sexe' => $user->sexe,
        'adresse' => $user->adresse,
        'email' => $user->email,
        'gsm' => $user->gsm,
        'naissance' => $user->naissance
    );

    // Make JSON
    print_r(json_encode($user_arr));