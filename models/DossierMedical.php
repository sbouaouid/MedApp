<?php 

class DossierMedical{
    // DB information 
    private $conn;
    private $table = 'DossierMedicaux';
    
    // DossierMedical attributes 
    public $id;
    public $utilisateur_id;

    // Constructor
    public function __construct($db){
        $this->conn=$db;
    }

    /*
    ****** READ DossierMedical BY USER ID
    */
    public function read_user(){
        // Create query 
        $query = 'SELECT 
            id,
            utilisateur_id 
            FROM 
                '.$this->table.'
            WHERE
                utilisateur_id = ?
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query); 

        //bind DossierMedical_date
        $stmt->bindParam(1, $this->utilisateur_id);

        // Execute query
        $stmt->execute(); 

        return $stmt;
    }

    /*
    ****** READ DossierMedical BY DossierMedical ID
    */
    public function read(){
        // Create query 
        $query = 'SELECT 
            id,
            utilisateur_id 
            FROM 
                '.$this->table.'
            WHERE
                id = ?
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query); 

        //bind DossierMedical_date
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute(); 

        return $stmt;
    }


    /*
        *******CREATE DossierMedical
    */
    public function create(){
        // create query
        $query = 'INSERT INTO '.$this->table.'
            SET
                utilisateur_id = :utilisateur_id ';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->utilisateur_id = htmlspecialchars(strip_tags($this->utilisateur_id));
    

        // Bind data
        $stmt->bindParam(':utilisateur_id', $this->utilisateur_id);
    
        // Execute query
        if($stmt->execute()){
            return true; 
        }

        // Print error if smthg goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;

    }

    /*
        *******Update DossierMedical
    */
    public function update(){
        // create query
        $query = 'UPDATE '.$this->table.' 
            SET 
                utilisateur_id = :utilisateur_id
            WHERE 
                id = :id';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->utilisateur_id = htmlspecialchars(strip_tags($this->utilisateur_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':utilisateur_id', $this->utilisateur_id);
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
    ****** DELETE DossierMedical
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