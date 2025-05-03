<?php
require_once __DIR__ . '/../controllers/TaskController.php';
require_once __DIR__ . '/../config/config.php';

$taskController = new TaskController($pdo);
$tasks = $taskController->listTasks();

// Inclure la vue des tâches
require_once __DIR__ . '/../views/tasks/list.php'; 