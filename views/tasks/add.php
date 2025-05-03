<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../../config/config.php';
require_once '../../controllers/ProjectController.php';

// Récupérer la liste des projets pour le menu déroulant
$projectController = new ProjectController($pdo);
$projects = $projectController->listProjects();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Tâche</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <h1>Ajouter une Tâche</h1>
    <form action="../../controllers/TaskController.php?action=create" method="POST">
        <label for="title">Titre:</label>
        <input type="text" name="title" required><br>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea><br>

        <label for="project_id">Projet:</label>
        <select name="project_id" required>
            <option value="">Sélectionner un projet</option>
            <?php foreach ($projects as $project): ?>
            <option value="<?= $project['id'] ?>"><?= htmlspecialchars($project['name']) ?></option>
            <?php endforeach; ?>
        </select><br>

        <button type="submit">Ajouter</button>
    </form>
    
    <!-- Retour à la liste des tâches -->
    <p><a href="list.php">Retour à la liste des tâches</a></p>
</body>
</html>