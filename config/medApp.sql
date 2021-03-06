CREATE TABLE `utilisateurs` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(200) NOT NULL,
  `prenom` VARCHAR(200) NOT NULL,
  `email` VARCHAR(200) NOT NULL UNIQUE,
  `password` VARCHAR(200) NOT NULL,
  `adresse` VARCHAR(200) NOT NULL,
  `sexe` VARCHAR(20) NOT NULL,
  `gsm` VARCHAR(20) NOT NULL,
  `naissance` DATE NOT NULL,
  `role` ENUM('medecin', 'secretaire', 'patient') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `rendezvous` (
  `id`INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `rdv_date` DATE NOT NULL,
  `rdv_time` TIME NOT NULL,
  `utilisateur_id`INT NOT NULL,
  FOREIGN KEY(utilisateur_id) REFERENCES utilisateurs(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `consultations` (
  `id`INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `consultation_date` DATE NOT NULL,
  `consultation_remarque` TEXT NOT NULL,
  `utilisateur_id`INT NOT NULL,
  FOREIGN KEY(utilisateur_id) REFERENCES utilisateurs(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `DossierMedicaux` (
  `id`INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `utilisateur_id`INT NOT NULL,
  FOREIGN KEY(utilisateur_id) REFERENCES utilisateurs(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `Documents` (
  `id`INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(20) NOT NULL,
  `description` TEXT NOT NULL,
  `type` VARCHAR(200) NOT NULL,
  `dossier_id`INT NOT NULL,
  FOREIGN KEY(dossier_id) REFERENCES DossierMedicaux(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `ExamenCliniques` (
  `id`INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `poids` VARCHAR(20) NOT NULL,
  `taille` VARCHAR(20) NOT NULL,
  `IMC` VARCHAR(20) NOT NULL,
  `temperature` VARCHAR(20) NOT NULL,
  `dossier_id`INT NOT NULL,
  FOREIGN KEY(dossier_id) REFERENCES DossierMedicaux(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `EtatGeneraux` (
  `id`INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `antecedentsFamiliaux` VARCHAR(200) NOT NULL,
  `antecedentsMedicaux` VARCHAR(200) NOT NULL,
  `antecedentsChirurgicaux` VARCHAR(20) NOT NULL,
  `habitudesAlcoloTabagiques` VARCHAR(20) NOT NULL,
  `dossier_id`INT NOT NULL,
  FOREIGN KEY(dossier_id) REFERENCES DossierMedicaux(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;