DROP DATABASE IF EXISTS en_formation_2526;

CREATE DATABASE en_formation_2526;

USE en_formation_2526;

CREATE TABLE eleve(
	id_eleve INT AUTO_INCREMENT NOT NULL, 
	nom VARCHAR(50) NOT NULL,
	prenom VARCHAR(50) NOT NULL,
	email VARCHAR(70) NOT NULL UNIQUE,
	mdp VARCHAR(255) NOT NULL,
	num_tel VARCHAR(15) UNIQUE,
	PRIMARY KEY(id_eleve)
) ENGINE=INNODB;

CREATE TABLE formateur(
   id_formateur INT AUTO_INCREMENT NOT NULL,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(70) NOT NULL UNIQUE,
   mdp VARCHAR(255) NOT NULL,
   num_tel VARCHAR(15) UNIQUE, 
   PRIMARY KEY(id_formateur)
)ENGINE=INNODB;

CREATE TABLE administrateur(
   id_administrateur INT AUTO_INCREMENT NOT NULL,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(70) NOT NULL UNIQUE,
   mdp VARCHAR(255) NOT NULL,
   num_tel VARCHAR(15) UNIQUE,
   PRIMARY KEY(id_administrateur)
)ENGINE=INNODB;

CREATE TABLE formation(
   id_formation INT AUTO_INCREMENT NOT NULL,
   titre VARCHAR(150) NOT NULL,
   DESCRIPTION VARCHAR(2500) NOT NULL,
   duree VARCHAR(50),
   prix DECIMAL(10,2),
   langue VARCHAR(50),
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
   id_formateur INT NOT NULL,
   id_formation INT NOT NULL,
   id_modalite INT NOT NULL,
   PRIMARY KEY(id_session),
   FOREIGN KEY(id_formateur) REFERENCES formateur(id_formateur),
   FOREIGN KEY(id_formation) REFERENCES formation(id_formation),
   FOREIGN KEY(id_modalite) REFERENCES modalite(id_modalite)
)ENGINE=INNODB;

CREATE TABLE S_inscrire(
   id_eleve INT,
   id_session INT,
   paiement_recu VARCHAR(50),
   PRIMARY KEY(id_eleve, id_session),
   FOREIGN KEY(id_eleve) REFERENCES eleve(id_eleve),
   FOREIGN KEY(id_session) REFERENCES SESSION(id_session)
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
