<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/UserController.php';

$controller = new UserController($pdo);

// Gérer les actions
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'create':
            $controller->createPage();
            break;
        case 'update':
            if (isset($_POST['id'])) {
                $controller->update($_POST);
            }
            header("Location: /projet/public/employees.php");
            break;
        case 'delete':
            if (isset($_GET['id'])) {
                $controller->delete($_GET['id']);
            }
            header("Location: /projet/public/employees.php");
            break;
        default:
            $controller->listPage();
    }
} else {
    $controller->listPage();
} 