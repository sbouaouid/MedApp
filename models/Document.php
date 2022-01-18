<?php 

class Document{
    // DB information 
    private $conn;
    private $table = 'Documents';
    
    // Document attributes 
    public $id; 
    public $nom;
    public $description;
    public $type;
    public $dossier_id;

    // Constructor
    public function __construct($db){
        $this->conn=$db;
    }
    
    /*
    ****** READ Document BY DOSSIER ID
    */
    public function read_dossier(){
        // Create query 
        $query = 'SELECT 
            id,
            nom,
            description,
            type,
            dossier_id 
            FROM 
                '.$this->table.'
            WHERE
                dossier_id = ?
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query); 

        //bind Document_date
        $stmt->bindParam(1, $this->dossier_id);

        // Execute query
        $stmt->execute(); 

        return $stmt;
    }

    /*
    ****** READ Document BY Document ID
    */
    public function read(){
        // Create query 
        $query = 'SELECT 
            id,
            nom,
            description,
            type,
            dossier_id 
            FROM 
                '.$this->table.'
            WHERE
                id = ?
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query); 

        //bind Document_date
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute(); 

        return $stmt;
    }


    /*
        *******CREATE Document
    */
    public function create(){
        // create query
        $query = 'INSERT INTO '.$this->table.'
            SET
                nom = :nom,
                description = :description,
                type = :type,
                dossier_id = :dossier_id ';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->dossier_id = htmlspecialchars(strip_tags($this->dossier_id));
    

        // Bind data
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':type', $this->type);
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
        *******Update Document
    */
    public function update(){
        // create query
        $query = 'UPDATE '.$this->table.' 
            SET 
                nom = :nom,
                description = :description, 
                type = :type,
                dossier_id = :dossier_id
            WHERE 
                id = :id';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->dossier_id = htmlspecialchars(strip_tags($this->dossier_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':type', $this->type);
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
    ****** DELETE Document
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