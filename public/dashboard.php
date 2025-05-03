<?php
// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /projet/public/login.php");
    exit();
}

// Inclure les fichiers nécessaires
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/ProjectController.php';
require_once __DIR__ . '/../controllers/TaskController.php';
require_once __DIR__ . '/../controllers/UserController.php';

// Initialiser les contrôleurs
$projectController = new ProjectController($pdo);
$taskController = new TaskController($pdo);
$userController = new UserController($pdo);

// Récupérer les données
$projects = $projectController->listProjects();
$tasks = $taskController->listTasks();
$users = $userController->getAllUsers();

// Inclure la vue du tableau de bord
require_once __DIR__ . '/../views/dashboard.php'; 