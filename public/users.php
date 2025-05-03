<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/UserController.php';

$controller = new UserController($pdo);
$controller->handleRequest(); 