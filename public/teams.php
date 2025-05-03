<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/TeamController.php';

$controller = new TeamController($pdo);
$controller->handleRequest(); 