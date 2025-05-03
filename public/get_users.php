<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/User.php';

try {
    $userModel = new User($pdo);
    $users = $userModel->getAllUsers();
    $result = array_map(function($u) {
        return [
            'id' => $u['id'],
            'name' => $u['name']
        ];
    }, $users);
    echo json_encode($result);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
} 