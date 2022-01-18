<?php 

class ExamenClinique{
    // DB information 
    private $conn;
    private $table = 'ExamenCliniques';
    
    // ExamenClinique attributes 
    public $id; 
    public $poids;
    public $taille;
    public $IMC;
    public $temperature;
    public $dossier_id;

    // Constructor
    public function __construct($db){
        $this->conn=$db;
    }

    /*
    ****** READ ExamenClinique BY DOSSIER ID
    */
    public function read_dossier(){
        // Create query 
        $query = 'SELECT 
            id,
            poids,
            taille,
            IMC,
            temperature,
            dossier_id 
            FROM 
                '.$this->table.'
            WHERE
                dossier_id = ?
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query); 

        //bind ExamenClinique_date
        $stmt->bindParam(1, $this->dossier_id);

        // Execute query
        $stmt->execute(); 

        return $stmt;
    }

    /*
    ****** READ ExamenClinique BY ExamenClinique ID
    */
    public function read(){
        // Create query 
        $query = 'SELECT 
            id,
            poids,
            taille,
            IMC,
            temperature,
            dossier_id 
            FROM 
                '.$this->table.'
            WHERE
                id = ?
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query); 

        //bind ExamenClinique_date
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute(); 

        return $stmt;
    }


    /*
        *******CREATE ExamenClinique
    */
    public function create(){
        // create query
        $query = 'INSERT INTO '.$this->table.'
            SET
                poids = :poids,
                taille = :taille,
                IMC = :IMC,
                temperature = :temperature,
                dossier_id = :dossier_id';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->poids = htmlspecialchars(strip_tags($this->poids));
        $this->taille = htmlspecialchars(strip_tags($this->taille));
        $this->IMC = htmlspecialchars(strip_tags($this->IMC));
        $this->temperature = htmlspecialchars(strip_tags($this->temperature));
        $this->dossier_id = htmlspecialchars(strip_tags($this->dossier_id));
    

        // Bind data
        $stmt->bindParam(':poids', $this->poids);
        $stmt->bindParam(':taille', $this->taille);
        $stmt->bindParam(':IMC', $this->IMC);
        $stmt->bindParam(':temperature', $this->temperature);
        $stmt->bindParam(':dossier_id', $this->dossier_id);
    
        // Execute query
        if($stmt->execute()){
            return true; 
        }

        // Print error if smthg goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;

    }

    /*
        *******Update ExamenClinique
    */
    public function update(){
        // create query
        $query = 'UPDATE '.$this->table.' 
            SET 
                poids = :poids,
                taille = :taille, 
                IMC = :IMC,
                temperature = :temperature,
                dossier_id = :dossier_id
            WHERE 
                id = :id';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->poids = htmlspecialchars(strip_tags($this->poids));
        $this->taille = htmlspecialchars(strip_tags($this->taille));
        $this->IMC = htmlspecialchars(strip_tags($this->IMC));
        $this->temperature = htmlspecialchars(strip_tags($this->temperature));
        $this->dossier_id = htmlspecialchars(strip_tags($this->dossier_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':poids', $this->poids);
        $stmt->bindParam(':taille', $this->taille);
        $stmt->bindParam(':IMC', $this->IMC);
        $stmt->bindParam(':temperature', $this->temperature);
        $stmt->bindParam(':dossier_id', $this->dossier_id);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()){
            return true; 
        }

        // Print error if smthg goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    /* 
    ****** DELETE ExamenClinique
    */
    public function delete(){
         // Create query
         $query = 'DELETE FROM '.$this->table.' WHERE id = :id';

         // Prepare statement 
         $stmt = $this->conn->prepare($query); 
 
         // Clean data
         $this->id = htmlspecialchars(strip_tags($this->id));
 
         // Bind data
         $stmt->bindParam(':id', $this->id);
 
         // Execute query
         if($stmt->execute()){
             return true;
         }
 
         //Print error if smthg goes wrong
         printf("Error: %s.\n", $stmt->error);
 
         return false;
    }

}