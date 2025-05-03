<?php
require_once __DIR__ . '/../config/config.php';
class Task {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // CREATE : Ajouter une tâche
    public function addTask($title, $description, $project_id) {
        $sql = "INSERT INTO tasks (title, description, project_id) VALUES (:title, :description, :project_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['title' => $title, 'description' => $description, 'project_id' => $project_id]);
    }

    // READ : Récupérer toutes les tâches
    public function getAllTasks() {
        $sql = "SELECT * FROM tasks";
        return $this->pdo->query($sql)->fetchAll();
    }

    // UPDATE : Modifier une tâche
    public function updateTask($id, $title, $description) {
        $sql = "UPDATE tasks SET title = :title, description = :description WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'title' => $title, 'description' => $description]);
    }

    // DELETE : Supprimer une tâche
    public function deleteTask($id) {
        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>
