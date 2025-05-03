<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: /projet/public/login.php");
    exit();
}
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../controllers/UserController.php';

header('Content-Type: text/html; charset=UTF-8');

$userController = new UserController($pdo);
$users = $userController->getAllUsers();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Employés</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <nav class="navbar">
        <div>
            <a href="/projet/public/dashboard.php">Tableau de bord</a>
            <a href="/projet/public/projects.php">Projets</a>
            <a href="/projet/public/tasks.php">Tâches</a>
            <a href="/projet/public/employees.php">Employés</a>
            <a href="/projet/public/teams.php">Équipes</a>
        </div>
        <div>
            <span style="color: white; margin-right: 1rem;"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Utilisateur') ?></span>
            <a href="/projet/public/logout.php" class="btn btn-danger">Déconnexion</a>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Liste des employés</h1>
            <a href="/projet/public/employees.php?action=create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter un employé
            </a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (empty($users)): ?>
            <div class="alert alert-info">
                Aucun employé n'a été trouvé.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <a href="/projet/public/employees.php?action=update&id=<?php echo $user['id']; ?>" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <a href="/projet/public/employees.php?action=delete&id=<?php echo $user['id']; ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="../../assets/js/scripts.js"></script>
</body>
</html>