<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/ProjectController.php';

try {
    // Initialisation de la connexion à la base de données
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Initialisation du contrôleur
    $controller = new ProjectController($pdo);

    // Gestion de la requête
    $controller->handleRequest();

} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
} 