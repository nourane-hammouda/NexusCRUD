<?php
require_once __DIR__ . '/../models/Task.php';

class TaskController {
    private $taskModel;

    public function __construct($pdo) {
        $this->taskModel = new Task($pdo);
    }

    public function showAddForm() {
        require __DIR__ . '/../views/tasks/add.php';
    }

    public function addTask(array $data) {
        if (empty($data['title']) || empty($data['project_id'])) {
            throw new Exception('Le titre et le projet sont requis.');
        }
        
        $this->taskModel->addTask(
            $data['title'],
            $data['description'] ?? '',
            $data['project_id']
        );
    }

    public function listTasks() {
        return $this->taskModel->getAllTasks();
    }
}