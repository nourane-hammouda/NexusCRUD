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

$controller = new ProjectController($pdo);
$projects = $controller->listProjects();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Projets</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <h1>Liste des Projets</h1>
    
    <!-- Bouton d'ajout -->
    <div class="actions">
        <a href="add.php" class="btn-add">Ajouter un projet</a>
    </div>

    <!-- Champ de recherche -->
    <div class="search-container">
        <input type="text" id="search-input" placeholder="Rechercher un projet...">
    </div>
    
    <!-- Tableau des projets -->
    <table id="projects-table" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project) : ?>
                <tr>
                    <td><?= htmlspecialchars($project['id']) ?></td>
                    <td><?= htmlspecialchars($project['name']) ?></td>
                    <td><?= htmlspecialchars($project['description']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $project['id'] ?>">Modifier</a>
                        <a href="../../controllers/ProjectController.php?action=delete&id=<?= $project['id'] ?>" 
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="../../assets/js/search.js"></script>
</body>
</html>