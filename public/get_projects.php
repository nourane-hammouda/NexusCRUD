<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/ProjectController.php';

try {
    $projectController = new ProjectController($pdo);
    $projects = $projectController->listProjects();
    $result = array_map(function($p) {
        return [
            'id' => $p['id'],
            'name' => $p['name'],
            'description' => $p['description'],
            'start_date' => $p['start_date'],
            'end_date' => $p['end_date'],
            'status' => $p['status'],
            'task_count' => $p['task_count'],
            'employee_count' => $p['employee_count']
        ];
    }, $projects);
    echo json_encode($result);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
} 