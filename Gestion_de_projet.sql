CREATE DATABASE Projet_Manager;
USE Projet_Manager;

-- Table des projets
CREATE TABLE projets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    deadline DATE,
    etat VARCHAR(255)
);

-- Table des employés
CREATE TABLE employes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    mail VARCHAR(255) UNIQUE NOT NULL,
    equipe VARCHAR(255)
);

-- Table de liaison projets-employés (Many-to-Many)
CREATE TABLE projets_employes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    projet_id INT,
    employe_id INT,
    FOREIGN KEY (projet_id) REFERENCES projets(id) ON DELETE CASCADE,
    FOREIGN KEY (employe_id) REFERENCES employes(id) ON DELETE CASCADE,
    UNIQUE (projet_id, employe_id) -- Pour éviter les doublons d'affectation
);

    

