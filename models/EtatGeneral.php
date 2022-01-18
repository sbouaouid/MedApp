<?php 

class EtatGeneral{
    // DB information 
    private $conn;
    private $table = 'EtatGeneraux';
    
    // EtatGeneral attributes 
    public $id; 
    public $antecedentsFamiliaux;
    public $antecedentsMedicaux;
    public $antecedentsChirurgicaux;
    public $habitudesAlcoloTabagiques;
    public $dossier_id;

    // Constructor
    public function __construct($db){
        $this->conn=$db;
    }

    /*
    ****** READ EtatGeneral BY DOSSIER ID
    */
    public function read_dossier(){
        // Create query 
        $query = 'SELECT 
            id,
            antecedentsFamiliaux,
            antecedentsMedicaux,
            antecedentsChirurgicaux,
            habitudesAlcoloTabagiques,
            dossier_id 
            FROM 
                '.$this->table.'
            WHERE
                dossier_id = ?
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query); 

        //bind EtatGeneral_date
        $stmt->bindParam(1, $this->dossier_id);

        // Execute query
        $stmt->execute(); 

        return $stmt;
    }

    /*
    ****** READ EtatGeneral BY EtatGeneral ID
    */
    public function read(){
        // Create query 
        $query = 'SELECT 
            id,
            antecedentsFamiliaux,
            antecedentsMedicaux,
            antecedentsChirurgicaux,
            habitudesAlcoloTabagiques,
            dossier_id 
            FROM 
                '.$this->table.'
            WHERE
                id = ?
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query); 

        //bind EtatGeneral_date
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute(); 

        return $stmt;
    }


    /*
        *******CREATE EtatGeneral
    */
    public function create(){
        // create query
        $query = 'INSERT INTO '.$this->table.'
            SET
                antecedentsFamiliaux = :antecedentsFamiliaux,
                antecedentsMedicaux = :antecedentsMedicaux,
                antecedentsChirurgicaux = :antecedentsChirurgicaux,
                habitudesAlcoloTabagiques = :habitudesAlcoloTabagiques,
                dossier_id = :dossier_id';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->antecedentsFamiliaux = htmlspecialchars(strip_tags($this->antecedentsFamiliaux));
        $this->antecedentsMedicaux = htmlspecialchars(strip_tags($this->antecedentsMedicaux));
        $this->antecedentsChirurgicaux = htmlspecialchars(strip_tags($this->antecedentsChirurgicaux));
        $this->habitudesAlcoloTabagiques = htmlspecialchars(strip_tags($this->habitudesAlcoloTabagiques));
        $this->dossier_id = htmlspecialchars(strip_tags($this->dossier_id));
    

        // Bind data
        $stmt->bindParam(':antecedentsFamiliaux', $this->antecedentsFamiliaux);
        $stmt->bindParam(':antecedentsMedicaux', $this->antecedentsMedicaux);
        $stmt->bindParam(':antecedentsChirurgicaux', $this->antecedentsChirurgicaux);
        $stmt->bindParam(':habitudesAlcoloTabagiques', $this->habitudesAlcoloTabagiques);
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
        *******Update EtatGeneral
    */
    public function update(){
        // create query
        $query = 'UPDATE '.$this->table.' 
            SET 
                antecedentsFamiliaux = :antecedentsFamiliaux,
                antecedentsMedicaux = :antecedentsMedicaux, 
                antecedentsChirurgicaux = :antecedentsChirurgicaux,
                habitudesAlcoloTabagiques = :habitudesAlcoloTabagiques,
                dossier_id = :dossier_id
            WHERE 
                id = :id';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->antecedentsFamiliaux = htmlspecialchars(strip_tags($this->antecedentsFamiliaux));
        $this->antecedentsMedicaux = htmlspecialchars(strip_tags($this->antecedentsMedicaux));
        $this->antecedentsChirurgicaux = htmlspecialchars(strip_tags($this->antecedentsChirurgicaux));
        $this->habitudesAlcoloTabagiques = htmlspecialchars(strip_tags($this->habitudesAlcoloTabagiques));
        $this->dossier_id = htmlspecialchars(strip_tags($this->dossier_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':antecedentsFamiliaux', $this->antecedentsFamiliaux);
        $stmt->bindParam(':antecedentsMedicaux', $this->antecedentsMedicaux);
        $stmt->bindParam(':antecedentsChirurgicaux', $this->antecedentsChirurgicaux);
        $stmt->bindParam(':habitudesAlcoloTabagiques', $this->habitudesAlcoloTabagiques);
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
    ****** DELETE EtatGeneral
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