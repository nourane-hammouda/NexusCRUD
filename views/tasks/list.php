<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../../config/config.php';
require_once '../../controllers/TaskController.php';

$taskController = new TaskController($pdo);
$tasks = $taskController->listTasks();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Tâches</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <h1>Liste des Tâches</h1>
    
    <!-- Bouton d'ajout -->
    <div class="actions">
        <a href="add.php" class="btn-add">Ajouter une tâche</a>
    </div>
    
    <!-- Champ de recherche -->
    <div class="search-container">
        <input type="text" id="search-input" placeholder="Rechercher une tâche...">
    </div>
    
    <table id="tasks-table" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Projet</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= htmlspecialchars($task['id']) ?></td>
                <td><?= htmlspecialchars($task['title']) ?></td>
                <td><?= htmlspecialchars($task['description']) ?></td>
                <td><?= isset($task['project_name']) ? htmlspecialchars($task['project_name']) : 'N/A' ?></td>
                <td>
                    <a href="edit.php?id=<?= $task['id'] ?>">Modifier</a>
                    <a href="../../controllers/TaskController.php?action=delete&id=<?= $task['id'] ?>" 
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="../../assets/js/search.js"></script>
</body>
</html>