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

// Nettoyage et analyse de l'URL
$request = isset($_GET['url']) ? '/' . trim($_GET['url'], '/') : '/';
$request = filter_var($request, FILTER_SANITIZE_URL);
$request = rtrim($request, '/');
$request = empty($request) ? '/' : $request;

// Récupération de la méthode HTTP
$method = $_SERVER['REQUEST_METHOD'];

try {
    // Routeur principal
    switch ($request) {
        // Page d'accueil
        case '/':
        case '/index.php':
            header("Location: /projet/public/index.php");
            exit();

        // Authentification
        case '/login':
            $userController = new UserController($pdo);
            if ($method === 'GET') {
                header("Location: /projet/public/login.php");
                exit();
            } else {
                try {
                    $userController->login($_POST);
                    $_SESSION['success'] = 'Connexion réussie!';
                    header('Location: /projet/public/dashboard.php');
                    exit();
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                    header('Location: /projet/public/login.php');
                    exit();
                }
            }

        case '/logout':
            $userController = new UserController($pdo);
            $userController->logout();
            $_SESSION['success'] = 'Déconnexion réussie!';
            header('Location: /projet/public/login.php');
            exit();

        case '/register':
            $userController = new UserController($pdo);
            if ($method === 'GET') {
                header("Location: /projet/public/register.php");
                exit();
            } else {
                try {
                    $userController->register($_POST);
                    $_SESSION['success'] = 'Inscription réussie! Vous pouvez maintenant vous connecter.';
                    header('Location: /projet/public/login.php');
                    exit();
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                    $_SESSION['old_input'] = $_POST;
                    header('Location: /projet/public/register.php');
                    exit();
                }
            };

        // Gestion des projets
        case '/projects':
            header("Location: /projet/public/projects.php");
            exit();

        case '/projects/add':
            $projectController = new ProjectController($pdo);
            if ($method === 'GET') {
                header("Location: /projet/public/projects.php?action=create");
                exit();
            } else {
                try {
                    $projectController->createProject($_POST);
                    $_SESSION['success'] = 'Projet créé avec succès!';
                    header('Location: /projet/public/projects.php');
                    exit();
                } catch (Exception $e) {
                    $_SESSION['error'] = $e->getMessage();
                    $_SESSION['old_input'] = $_POST;
                    header('Location: /projet/public/projects.php?action=create');
                    exit();
                }
            }

        // Gestion des tâches
        case '/tasks':
            header("Location: /projet/public/tasks.php");
            exit();

        // Gestion des employés
        case '/employees':
        case '/employes.php':
            header("Location: /projet/public/employees.php");
            exit();

        // Gestion des utilisateurs
        case '/users':
            header("Location: /projet/public/users.php");
            exit();

        // Gestion des équipes
        case '/teams':
            header("Location: /projet/public/teams.php");
            exit();

        // Route par défaut (404)
        default:
            http_response_code(404);
            require __DIR__ . '/../views/errors/404.php';
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