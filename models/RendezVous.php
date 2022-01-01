<?php 

class RendezVous{
    // DB information 
    private $conn;
    private $table = 'rendezvous';
    
    // RDV attributes 
    public $id; 
    public $date; 
    public $utilisateur_id;

    // Constructor
    public function __construct($db){
        $this->conn=$db;
    }

    /*
    ****** READ RDV
    */
    public function read(){
        // Create query 
        $query = 'SELECT 
            rdv_date,
            utilisateur_id 
            FROM 
                '.$this->table.'
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query); 

        // Execute query
        $stmt->execute(); 

        return $stmt;
    }


    /*
        *******CREATE RDV
    */
    public function create(){
        // create query
        $query = 'INSERT INTO '.$this->table.'
            SET
                rdv_date = :rdv_date,
                utilisateur_id = :utilisateur_id ';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->utilisateur_id = htmlspecialchars(strip_tags($this->utilisateur_id));
    

        // Bind data
        $stmt->bindParam(':rdv_date', $this->date);
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
        *******Update RDV
    */
    public function update(){
        // create query
        $query = 'UPDATE '.$this->table.' 
            SET 
                rdv_date = :rdv_date, 
                utilisateur_id = :utilisateur_id
            WHERE 
                id = :id';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->rdv_date = htmlspecialchars(strip_tags($this->date));
        $this->utilisateur_id = htmlspecialchars(strip_tags($this->utilisateur_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':rdv_date', $this->date);
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
    ****** DELETE RDV
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