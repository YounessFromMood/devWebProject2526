-- ============================================================
--  Base de données : en_formation_2526
--  Version corrigée :
--    - Colonnes deleted_at ajoutées (soft delete CodeIgniter)
--      sur : eleve, formateur, formation, session
--    - Données de départ (seed) ajoutées :
--      modalite, note_reussite, type_formation, administrateur
--  Mot de passe admin : Admin1234
-- ============================================================

DROP DATABASE IF EXISTS en_formation_2526;

CREATE DATABASE en_formation_2526;

USE en_formation_2526;

CREATE TABLE eleve(
	id_eleve INT AUTO_INCREMENT NOT NULL, 
	nom VARCHAR(50) NOT NULL,
	prenom VARCHAR(50) NOT NULL,
	email VARCHAR(70) NOT NULL UNIQUE,
	mdp VARCHAR(255) NOT NULL,
	num_tel VARCHAR(20) UNIQUE,
	deleted_at DATETIME DEFAULT NULL,
	PRIMARY KEY(id_eleve)
) ENGINE=INNODB;

CREATE TABLE formateur(
   id_formateur INT AUTO_INCREMENT NOT NULL,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(70) NOT NULL UNIQUE,
   mdp VARCHAR(255) NOT NULL,
   num_tel VARCHAR(20) UNIQUE, 
   deleted_at DATETIME DEFAULT NULL,
   PRIMARY KEY(id_formateur)
)ENGINE=INNODB;

CREATE TABLE administrateur(
   id_administrateur INT AUTO_INCREMENT NOT NULL,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(70) NOT NULL UNIQUE,
   mdp VARCHAR(255) NOT NULL,
   num_tel VARCHAR(20) UNIQUE,
   PRIMARY KEY(id_administrateur)
)ENGINE=INNODB;

CREATE TABLE formation(
   id_formation INT AUTO_INCREMENT NOT NULL,
   titre VARCHAR(300) NOT NULL,
   DESCRIPTION VARCHAR(2500) NOT NULL,
   duree VARCHAR(150),
   prix DECIMAL(10,2),
   langue VARCHAR(50),
   deleted_at DATETIME DEFAULT NULL,
   PRIMARY KEY(id_formation)
)ENGINE=INNODB;

CREATE TABLE modalite(
   id_modalite INT AUTO_INCREMENT NOT NULL,
   libelle VARCHAR(30) NOT NULL,
   nb_etudiant_max INT NOT NULL,
   PRIMARY KEY(id_modalite)
)ENGINE=INNODB;

CREATE TABLE type_formation(
   id_type_formation INT AUTO_INCREMENT NOT NULL,
   libelle VARCHAR(100) NOT NULL,
   PRIMARY KEY(id_type_formation)
)ENGINE=INNODB;

CREATE TABLE note_reussite(
   id_note_reussite INT AUTO_INCREMENT NOT NULL,
   libelle VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_note_reussite)
)ENGINE=INNODB;

CREATE TABLE `session`(
   id_session INT AUTO_INCREMENT NOT NULL,
   date_debut DATE NOT NULL,
   date_fin DATE NOT NULL,
   prix DECIMAL(10,2),
   lieu_session VARCHAR(100),
   id_formateur INT NOT NULL,
   id_formation INT NOT NULL,
   id_modalite INT NOT NULL,
   deleted_at DATETIME DEFAULT NULL,
   PRIMARY KEY(id_session),
   FOREIGN KEY(id_formateur) REFERENCES formateur(id_formateur),
   FOREIGN KEY(id_formation) REFERENCES formation(id_formation),
   FOREIGN KEY(id_modalite) REFERENCES modalite(id_modalite)
)ENGINE=INNODB;

CREATE TABLE S_inscrire(
   id_eleve INT,
   id_session INT,
   paiement_recu BOOLEAN DEFAULT FALSE,
   date_inscription DATE,
   PRIMARY KEY(id_eleve, id_session),
   FOREIGN KEY(id_eleve) REFERENCES eleve(id_eleve),
   FOREIGN KEY(id_session) REFERENCES `session`(id_session)
)ENGINE=INNODB;

CREATE TABLE Editer(
   id_administrateur INT,
   id_formation INT,
   PRIMARY KEY(id_administrateur, id_formation),
   FOREIGN KEY(id_administrateur) REFERENCES administrateur(id_administrateur),
   FOREIGN KEY(id_formation) REFERENCES formation(id_formation)
)ENGINE=INNODB;

CREATE TABLE Gerer(
   id_formateur INT,
   id_administrateur INT,
   PRIMARY KEY(id_formateur, id_administrateur),
   FOREIGN KEY(id_formateur) REFERENCES formateur(id_formateur),
   FOREIGN KEY(id_administrateur) REFERENCES administrateur(id_administrateur)
)ENGINE=INNODB;

CREATE TABLE `Modifier`(
   id_administrateur INT,
   id_session INT,
   PRIMARY KEY(id_administrateur, id_session),
   FOREIGN KEY(id_administrateur) REFERENCES administrateur(id_administrateur),
   FOREIGN KEY(id_session) REFERENCES `session`(id_session)
)ENGINE=INNODB;

CREATE TABLE Typer(
   id_formation INT,
   id_type_formation INT,
   PRIMARY KEY(id_formation, id_type_formation),
   FOREIGN KEY(id_formation) REFERENCES formation(id_formation),
   FOREIGN KEY(id_type_formation) REFERENCES type_formation(id_type_formation)
)ENGINE=INNODB;

CREATE TABLE notifier(
   id_eleve INT,
   id_session INT,
   id_note_reussite INT,
   PRIMARY KEY(id_eleve, id_session),
   FOREIGN KEY(id_eleve) REFERENCES eleve(id_eleve),
   FOREIGN KEY(id_session) REFERENCES `session`(id_session),
   FOREIGN KEY(id_note_reussite) REFERENCES note_reussite(id_note_reussite)
)ENGINE=INNODB;

-- ============================================================
--  DONNÉES DE DÉPART (SEED)
-- ============================================================

-- Modalités : capacités attendues par Session::toRegister
INSERT INTO modalite (libelle, nb_etudiant_max) VALUES
('Présentiel', 10),
('Distanciel', 20);

-- Notes : libellés cherchés par NotifierModel::addGrade
INSERT INTO note_reussite (libelle) VALUES
('Réussite'),
('A participé');

-- Types de formation : utilisés par la recherche / le filtre
INSERT INTO type_formation (libelle) VALUES
('Programmation'),
('Cybersécurité'),
('Design'),
('Bureautique');

-- Administrateur de départ (aucun moyen d'en créer un via le site)
-- Email    : admin@enformation.be
-- Password : Admin1234   (hash bcrypt ci-dessous)
INSERT INTO administrateur (nom, prenom, email, mdp, num_tel) VALUES
('Admin', 'Principal', 'admin@enformation.be',
 '$2b$10$EIV9Va5PubCNLCMZl6JWI.wcQy/jk23uG7qHhqZvRTMg4Mo0FPyNC', NULL);

-- Formateur de test
-- Email    : jack.frost@enformation.be
-- Password : Formateur1234
INSERT INTO formateur (nom, prenom, email, mdp, num_tel) VALUES
(
    'Frost',
    'Jack',
    'jack.frost@enformation.be',
    '$2y$10$tPVmT.KlqwFGF7QsWhvjk.vqp7rSTgE0Y51wUos5yCOGJ8CUmpwZG',
    '+32 470 12 34 56'
);
