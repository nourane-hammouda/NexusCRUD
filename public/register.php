<?php
session_start();
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../config/config.php';

$userController = new UserController($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($userController->register($_POST)) {
        // Connecter l'utilisateur après l'inscription
        if ($userController->login($_POST)) {
            header("Location: /projet/public/dashboard.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Erreur lors de l'inscription.";
        $_SESSION['old_input'] = $_POST;
    }
}

// Inclure la vue d'inscription
require_once __DIR__ . '/../views/auth/register.php';
