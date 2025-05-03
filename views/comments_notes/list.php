<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
require_once '../../config/config.php';
require_once '../../controllers/CommentNoteController.php';
require_once '../../controllers/ProjectController.php';
require_once '../../controllers/UserController.php';

$commentNoteController = new CommentNoteController($pdo);
$commentsNotes = $commentNoteController->index();

// Récupérer les informations sur les projets et utilisateurs pour l'affichage
$projectController = new ProjectController($pdo);
$userController = new UserController($pdo);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Commentaires et Notes</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <h1>Liste des Commentaires et Notes</h1>
    
    <!-- Champ de recherche -->
    <div class="search-container">
        <input type="text" id="search-input" placeholder="Rechercher un commentaire...">
    </div>
    
    <table id="comments-notes-table" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Commentaire</th>
                <th>Projet</th>
                <th>Utilisateur</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commentsNotes as $commentNote): 
                // Récupérer les noms du projet et de l'utilisateur
                $project = $projectController->getProject($commentNote['project_id']);
                $user = $userController->getUser($commentNote['user_id']);
            ?>
            <tr>
                <td><?= htmlspecialchars($commentNote['id']) ?></td>
                <td><?= htmlspecialchars($commentNote['comment']) ?></td>
                <td><?= htmlspecialchars($project['name'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($user['name'] ?? 'N/A') ?></td>
                <td><?= isset($commentNote['created_at']) ? date('d/m/Y H:i', strtotime($commentNote['created_at'])) : 'N/A' ?></td>
                <td>
                    <a href="../projects/list.php?project_id=<?= $commentNote['project_id'] ?>">Voir le projet</a>
                    <a href="../../controllers/CommentNoteController.php?action=delete&id=<?= $commentNote['id'] ?>" 
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <!-- Formulaire d'ajout rapide -->
    <div class="quick-add-form">
        <h2>Ajouter un commentaire</h2>
        <form action="../../controllers/CommentNoteController.php?action=create" method="POST">
            <div class="form-group">
                <label for="comment">Commentaire:</label>
                <textarea name="comment" id="comment" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="project_id">Projet:</label>
                <select name="project_id" id="project_id" required>
                    <option value="">Sélectionner un projet</option>
                    <?php 
                    $projects = $projectController->listProjects();
                    foreach ($projects as $project): 
                    ?>
                        <option value="<?= $project['id'] ?>"><?= htmlspecialchars($project['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
            
            <button type="submit" class="btn-submit">Ajouter</button>
        </form>
    </div>
    
    <script src="../../assets/js/search.js"></script>
</body>
</html>