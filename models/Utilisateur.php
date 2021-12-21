<?php 

class Utilisateur{
    // DB information 
    private $conn;
    private $table = 'utilisateurs';
    
    // Utilisateurs attributes 
    public $id; 
    public $nom; 
    public $prenom;
    public $email;
    public $password;
    public $adresse;
    public $sexe;
    public $gsm;
    public $naissance; 
    public $role;

    // Constructor
    public function __construct($db){
        $this->conn=$db;
    }

    /*
    ****** READ USERS( Patients )
    */
    public function read(){
        // Create query 
        $query = 'SELECT 
            nom,
            prenom, 
            sexe,
            adresse, 
            email,
            gsm, 
            naissance 
            FROM 
                '.$this->table.'
            WHERE 
                role = "patient"
            ORDER BY 
                created_at DESC
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query); 

        // Execute query
        $stmt->execute(); 

        return $stmt;
    }


    /*
        *******GET SINGLE USER
    */
    public function read_single(){

        // Create query 
        $query = 'SELECT
            nom,
            prenom, 
            sexe,
            adresse, 
            email,
            gsm, 
            naissance 
            FROM 
                '.$this->table.'
            WHERE 
                role = "patient"
            AND 
                id = ?
            LIMIT 0,1
        ';

        // Prepare statement 
        $stmt = $this->conn->prepare($query);

        // Bind id
        $stmt->bindParam(1, $this->id);

        // Execute query 
        $stmt->execute(); 

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->nom = $row['nom'];
        $this->prenom = $row['prenom'];
        $this->sexe = $row['sexe'];
        $this->adresse = $row['adresse'];
        $this->email = $row['email'];
        $this->gsm = $row['gsm'];
        $this->naissance = $row['naissance'];
    }

    /*
        *******CREATE USER
    */
    public function create(){
        // create query
        $query = 'INSERT INTO '.$this->table.'
            SET
                nom = :nom,
                prenom = :prenom,
                naissance = :naissance, 
                email = :email,
                password = :password,
                adresse = :adresse,
                sexe = :sexe, 
                gsm = :gsm,
                role = :role';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->adresse = htmlspecialchars(strip_tags($this->adresse));
        $this->gsm = htmlspecialchars(strip_tags($this->gsm));
        $this->naissance = htmlspecialchars(strip_tags($this->naissance));
        $this->sexe = htmlspecialchars(strip_tags($this->sexe));
        $this->role = htmlspecialchars(strip_tags($this->role));

        // Bind data
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':adresse', $this->adresse);
        $stmt->bindParam(':gsm', $this->nom);
        $stmt->bindParam(':naissance', $this->naissance);
        $stmt->bindParam(':sexe', $this->sexe);
        $stmt->bindParam(':role', $this->role);

        // Execute query
        if($stmt->execute()){
            return true; 
        }

        // Print error if smthg goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;

    }

    /*
        *******UPDATE USER
    */
    public function update(){
        // create query
        $query = 'UPDATE '.$this->table.'
            SET
                nom = :nom,
                prenom = :prenom,
                naissance = :naissance, 
                email = :email,
                password = :password,
                adresse = :adresse,
                sexe = :sexe, 
                gsm = :gsm,
                role = :role
            WHERE 
                id = :id';

        // Prepare statement 
        $stmt = $this->conn->prepare($query); 

        // Clean data
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->adresse = htmlspecialchars(strip_tags($this->adresse));
        $this->gsm = htmlspecialchars(strip_tags($this->gsm));
        $this->naissance = htmlspecialchars(strip_tags($this->naissance));
        $this->sexe = htmlspecialchars(strip_tags($this->sexe));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':adresse', $this->adresse);
        $stmt->bindParam(':gsm', $this->nom);
        $stmt->bindParam(':naissance', $this->naissance);
        $stmt->bindParam(':sexe', $this->sexe);
        $stmt->bindParam(':role', $this->role);
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
    ****** DELETE USER
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