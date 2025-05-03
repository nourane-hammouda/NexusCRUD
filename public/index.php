<?php
// Activation des erreurs pour le développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialisation de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Chargement de la configuration et de la connexion PDO
require_once __DIR__ . '/../config/config.php';

// Inclusions des contrôleurs
require_once __DIR__ . '/../controllers/ProjectController.php';
require_once __DIR__ . '/../controllers/TaskController.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/CommentNoteController.php';
require_once __DIR__ . '/../controllers/TeamController.php';
require_once __DIR__ . '/../controllers/EmployeeController.php';

// Si l'utilisateur est déjà connecté, rediriger vers le dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: /projet/public/dashboard.php");
    exit();
}

$title = "Accueil - Gestion de Projets";

ob_start();
?>
<div class="card">
    <h1>Bienvenue sur la plateforme de gestion de projets</h1>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Vous êtes connecté en tant que <?= htmlspecialchars($_SESSION['user_name']) ?></p>
        <div class="actions">
            <a href="/projet/public/dashboard.php" class="btn btn-primary">Accéder au tableau de bord</a>
        </div>
    <?php else: ?>
        <p>Connectez-vous pour accéder à toutes les fonctionnalités :</p>
        <div class="actions">
            <a href="/projet/public/login.php" class="btn btn-primary">Se connecter</a>
            <a href="/projet/public/register.php" class="btn btn-secondary">S'inscrire</a>
        </div>
    <?php endif; ?>
</div>

<div class="card">
    <h2>Fonctionnalités principales</h2>
    <ul>
        <li>Gestion des projets</li>
        <li>Gestion des employés</li>
        <li>Gestion des équipes</li>
        <li>Suivi des tâches</li>
        <li>Tableau de bord personnalisé</li>
    </ul>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../views/layouts/base.php';

try {
    // Routeur principal
    $page = $_GET['page'] ?? 'home';

    switch ($page) {
        case 'employees':
            $controller = new EmployeeController($pdo);
            $controller->handleRequest();
            break;

        // Page d'accueil
        case '/':
        case '/index.php':
            $projectController = new ProjectController($pdo);
            $projects = $projectController->listProjects();
            require __DIR__ . '/../views/dashboard.php';
            break;

        // Authentification
        case '/login':
            $userController = new UserController($pdo);
            if ($method === 'GET') {
                $userController->loginPage();
            } else {
                try {
                    $userController->login($_POST);
                    $_SESSION['success'] = 'Connexion réussie!';
                    header('Location: /');
                    exit();
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                    header('Location: /login');
                    exit();
                }
            }
            break;

        case '/logout':
            $userController = new UserController($pdo);
            $userController->logout();
            $_SESSION['success'] = 'Déconnexion réussie!';
            header('Location: /login');
            exit();

        case '/register':
            $userController = new UserController($pdo);
            if ($method === 'GET') {
                $userController->registerPage();
            } else {
                try {
                    $userController->register($_POST);
                    $_SESSION['success'] = 'Inscription réussie! Vous pouvez maintenant vous connecter.';
                    header('Location: /login');
                    exit();
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                    $_SESSION['old_input'] = $_POST;
                    header('Location: /register');
                    exit();
                }
            }
            break;

        // Gestion des projets
        case '/projects':
            $projectController = new ProjectController($pdo);
            $projects = $projectController->listProjects();
            require __DIR__ . '/../views/projects/list.php';
            break;

        case '/projects/add':
            $projectController = new ProjectController($pdo);
            if ($method === 'GET') {
                $projectController->showAddForm();
            } else {
                try {
                    $projectController->createProject($_POST);
                    $_SESSION['success'] = 'Projet créé avec succès!';
                    header('Location: /projects');
                    exit();
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                    $_SESSION['old_input'] = $_POST;
                    header('Location: /projects/add');
                    exit();
                }
            }
            break;

        case '/projects/edit':
            $projectController = new ProjectController($pdo);
            if ($method === 'GET' && isset($_GET['id'])) {
                try {
                    $project = $projectController->getProject($_GET['id']);
                    require __DIR__ . '/../views/projects/edit.php';
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                    header('Location: /projects');
                    exit();
                }
            } else {
                header('Location: /projects');
                exit();
            }
            break;

        case '/projects/update':
            if ($method === 'POST') {
                $projectController = new ProjectController($pdo);
                try {
                    $projectController->update($_POST);
                    $_SESSION['success'] = 'Projet mis à jour avec succès!';
                    header('Location: /projects');
                    exit();
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                    header('Location: /projects/edit?id=' . $_POST['id']);
                    exit();
                }
            }
            break;

        case '/projects/delete':
            if ($method === 'POST' && isset($_POST['id'])) {
                $projectController = new ProjectController($pdo);
                try {
                    $projectController->delete($_POST['id']);
                    $_SESSION['success'] = 'Projet supprimé avec succès!';
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                }
                header('Location: /projects');
                exit();
            }
            break;

        // Gestion des tâches
        case '/tasks':
            $taskController = new TaskController($pdo);
            $tasks = $taskController->listTasks();
            require __DIR__ . '/../views/tasks/list.php';
            break;

        case '/tasks/add':
            $taskController = new TaskController($pdo);
            if ($method === 'GET') {
                $taskController->showAddForm();
            } else {
                try {
                    $taskController->addTask($_POST);
                    $_SESSION['success'] = 'Tâche ajoutée avec succès!';
                    header('Location: /tasks');
                    exit();
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                    $_SESSION['old_input'] = $_POST;
                    header('Location: /tasks/add');
                    exit();
                }
            }
            break;

        // Gestion des commentaires
        case '/comments':
            $commentController = new CommentNoteController($pdo);
            $comments = $commentController->index();
            require __DIR__ . '/../views/comments_notes/list.php';
            break;

        case '/comments/add':
            if ($method === 'POST') {
                $commentController = new CommentNoteController($pdo);
                try {
                    $commentController->create(
                        $_POST['comment'],
                        $_POST['project_id'],
                        $_SESSION['user_id']
                    );
                    $_SESSION['success'] = 'Commentaire ajouté avec succès!';
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                }
                header('Location: /projects/view?id=' . $_POST['project_id']);
                exit();
            }
            break;

        // Route par défaut (404)
        default:
            http_response_code(404);
            require __DIR__ . '/../views/errors/404.php';
            break;
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $_SESSION['error'] = 'Une erreur de base de données est survenue';
    http_response_code(500);
    require __DIR__ . '/../views/errors/500.php';
} catch (Exception $e) {
    error_log("Application error: " . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
    http_response_code(500);
    require __DIR__ . '/../views/errors/500.php';
}