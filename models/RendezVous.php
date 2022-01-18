<?php 

class RendezVous{
    // DB information 
    private $conn;
    private $table = 'rendezvous';
    
    // RDV attributes 
    public $id; 
    public $date;
    public $time;
    public $utilisateur_id;

    // Constructor
    public function __construct($db){
        $this->conn=$db;
    }

    /*
    ****** READ RDV BY DATE
    */
    public function read(){
        // Create query 
        $query = 'SELECT 
            id,
            rdv_date,
            rdv_time,
            utilisateur_id 
            FROM 
                '.$this->table.'
            WHERE
                rdv_date = ?
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query); 

        //bind rdv_date
        $stmt->bindParam(1, $this->date);

        // Execute query
        $stmt->execute(); 

        return $stmt;
    }
    /*
    ****** READ RDV BY USER ID
    */
    public function read_user(){
        // Create query 
        $query = 'SELECT 
            id,
            rdv_date,
            rdv_time,
            utilisateur_id 
            FROM 
                '.$this->table.'
            WHERE
                utilisateur_id = ?
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query); 

        //bind rdv_date
        $stmt->bindParam(1, $this->utilisateur_id);

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
                rdv_time = :rdv_time,
                utilisateur_id = :utilisateur_id ';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->utilisateur_id = htmlspecialchars(strip_tags($this->utilisateur_id));
        $this->time = htmlspecialchars(strip_tags($this->time));
    

        // Bind data
        $stmt->bindParam(':rdv_date', $this->date);
        $stmt->bindParam(':utilisateur_id', $this->utilisateur_id);
        $stmt->bindParam(':rdv_time', $this->time);
    
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
                rdv_time = :rdv_time, 
                utilisateur_id = :utilisateur_id
            WHERE 
                id = :id';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->rdv_date = htmlspecialchars(strip_tags($this->date));
        $this->rdv_time = htmlspecialchars(strip_tags($this->time));
        $this->utilisateur_id = htmlspecialchars(strip_tags($this->utilisateur_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':rdv_date', $this->date);
        $stmt->bindParam(':rdv_time', $this->time);
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