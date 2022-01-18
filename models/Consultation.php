<?php 

class Consultation{
    // DB information 
    private $conn;
    private $table = 'consultations';
    
    // Consultation attributes 
    public $id; 
    public $date;
    public $remarque;
    public $utilisateur_id;

    // Constructor
    public function __construct($db){
        $this->conn=$db;
    }

    /*
    ****** READ CONSULTATIONS
    */
    public function readAll(){
        // Create query 
        $query = 'SELECT 
            id,
            consultation_date,
            consultation_remarque,
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
    ****** READ Consultation BY USER ID
    */
    public function read_user(){
        // Create query 
        $query = 'SELECT 
            id,
            consultation_date,
            consultation_remarque,
            utilisateur_id 
            FROM 
                '.$this->table.'
            WHERE
                utilisateur_id = ?
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query); 

        //bind Consultation_date
        $stmt->bindParam(1, $this->utilisateur_id);

        // Execute query
        $stmt->execute(); 

        return $stmt;
    }

    /*
    ****** READ Consultation BY CONSULTATION ID
    */
    public function read(){
        // Create query 
        $query = 'SELECT 
            id,
            consultation_date,
            consultation_remarque,
            utilisateur_id 
            FROM 
                '.$this->table.'
            WHERE
                id = ?
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query); 

        //bind Consultation_date
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute(); 

        return $stmt;
    }


    /*
        *******CREATE CONSULTATION
    */
    public function create(){
        // create query
        $query = 'INSERT INTO '.$this->table.'
            SET
                consultation_date = :consultation_date,
                consultation_remarque = :consultation_remarque,
                utilisateur_id = :utilisateur_id ';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->utilisateur_id = htmlspecialchars(strip_tags($this->utilisateur_id));
        $this->remarque = htmlspecialchars(strip_tags($this->remarque));
    

        // Bind data
        $stmt->bindParam(':consultation_date', $this->date);
        $stmt->bindParam(':utilisateur_id', $this->utilisateur_id);
        $stmt->bindParam(':consultation_remarque', $this->remarque);
    
        // Execute query
        if($stmt->execute()){
            return true; 
        }

        // Print error if smthg goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;

    }

    /*
        *******Update CONSULTATION
    */
    public function update(){
        // create query
        $query = 'UPDATE '.$this->table.' 
            SET 
                consultation_date = :consultation_date,
                consultation_remarque = :consultation_remarque, 
                utilisateur_id = :utilisateur_id
            WHERE 
                id = :id';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->remarque = htmlspecialchars(strip_tags($this->remarque));
        $this->utilisateur_id = htmlspecialchars(strip_tags($this->utilisateur_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':consultation_date', $this->date);
        $stmt->bindParam(':consultation_remarque', $this->remarque);
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
    ****** DELETE Consultation
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