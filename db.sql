DROP DATABASE IF EXISTS project_management;
CREATE DATABASE project_management;
USE project_management;

CREATE TABLE authentication (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'employee') NOT NULL
);
CREATE TABLE projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    deadline DATE,
    status ENUM('ongoing', 'completed', 'pending') NOT NULL
);
CREATE TABLE employees (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    team VARCHAR(100)
);
CREATE TABLE assignments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT,
    employee_id INT,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
);
CREATE TABLE tasks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    status ENUM('pending', 'in progress', 'completed') NOT NULL,
    due_date DATE,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);
CREATE TABLE comments_notes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT,
    employee_id INT,
    message TEXT NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
);
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE equipes (
  id int(11) NOT NULL AUTO_INCREMENT,
  equipe varchar(255) NOT NULL,
  membres text NOT NULL,
  description text NOT NULL,
  taches text NOT NULL,
  etat varchar(7) NOT NULL DEFAULT '#ffffff',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



    
