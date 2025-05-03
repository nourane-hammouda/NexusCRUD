<?php

class Project {
    private $pdo;

    // Constructeur pour initialiser la connexion à la base de données
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer tous les projets
    public function getAllProjects() {
        $stmt = $this->pdo->query("SELECT * FROM projects");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un projet
    public function addProject($name, $description) {
        $stmt = $this->pdo->prepare("INSERT INTO projects (name, description) VALUES (?, ?)");
        $stmt->execute([$name, $description]);
    }

    // Modifier un projet
    public function updateProject($id, $name, $description) {
        $stmt = $this->pdo->prepare("UPDATE projects SET name = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $description, $id]);
    }

    // Supprimer un projet
    public function deleteProject($id) {
        $stmt = $this->pdo->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$id]);
    }

    // Récupérer un projet par son ID
    public function getProjectById($id) {
        // Requête pour récupérer un projet spécifique par son ID
        $stmt = $this->pdo->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne un seul projet sous forme de tableau associatif
    }
}
?>
