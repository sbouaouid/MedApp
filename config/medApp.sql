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
  `utilisateur_id`INT NOT NULL,
  FOREIGN KEY(utilisateur_id) REFERENCES utilisateurs(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;