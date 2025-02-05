CREATE database Projet_Manager;
use Projet_Manager;

CREATE TABLE projets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    deadline DATE,
    etat varchar(255)
);

CREATE TABLE employe(
	id int auto_increment primary key,
    nom varchar(255),
    mail varchar(255),
    equipe varchar(255),
    nom_projet varchar(255),
    projet int,
    foreign key (projet) references projets(id)
    );

CREATE TABLE projets_employe(
	id int auto_increment primary key,
    projet_id int,
    employe_id int,
    foreign key (projet_id) references projet(id),
    foreign key (employe_id) references employe(id)
    );
    


