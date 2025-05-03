<?php
require_once __DIR__ . '/../models/Employee.php';

class EmployeeController {
    private $employeeModel;

    public function __construct($pdo) {
        $this->employeeModel = new Employee($pdo);
    }

    public function handleRequest() {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'create':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $this->create($_POST);
                    } else {
                        $this->createPage();
                    }
                    break;

                case 'update':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $this->update($_POST);
                    } else {
                        $this->updatePage($_GET['id']);
                    }
                    break;

                case 'delete':
                    $this->delete($_GET['id']);
                    break;

                case 'list':
                default:
                    $this->listPage();
                    break;
            }
        } else {
            $this->listPage();
        }
    }

    public function listPage() {
        $employees = $this->employeeModel->getAllEmployees();
        require __DIR__ . '/../views/employees/list.php';
    }

    public function createPage() {
        require __DIR__ . '/../views/employees/add.php';
    }

    public function updatePage($id) {
        $employee = $this->employeeModel->getEmployeeById($id);
        require __DIR__ . '/../views/employees/edit.php';
    }

    public function create($data) {
        if (empty($data['name']) || empty($data['email'])) {
            $_SESSION['error'] = 'Tous les champs sont requis.';
            $_SESSION['old_input'] = $data;
            return false;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email invalide.';
            $_SESSION['old_input'] = $data;
            return false;
        }

        try {
            $this->employeeModel->addEmployee($data['name'], $data['email']);
            $_SESSION['success'] = 'Employé ajouté avec succès.';
            return true;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de l\'ajout: ' . $e->getMessage();
            $_SESSION['old_input'] = $data;
            return false;
        }
    }

    public function update($data) {
        if (empty($data['id']) || empty($data['name']) || empty($data['email'])) {
            $_SESSION['error'] = 'Tous les champs sont requis.';
            $_SESSION['old_input'] = $data;
            return false;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email invalide.';
            $_SESSION['old_input'] = $data;
            return false;
        }

        try {
            $this->employeeModel->updateEmployee($data['id'], $data['name'], $data['email']);
            $_SESSION['success'] = 'Employé modifié avec succès.';
            return true;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la modification: ' . $e->getMessage();
            $_SESSION['old_input'] = $data;
            return false;
        }
    }

    public function delete($id) {
        try {
            $this->employeeModel->deleteEmployee($id);
            $_SESSION['success'] = 'Employé supprimé avec succès.';
            return true;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la suppression: ' . $e->getMessage();
            return false;
        }
    }
} 