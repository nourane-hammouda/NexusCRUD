<?php
require_once __DIR__ . '/../models/Team.php';

class TeamController {
    private $teamModel;

    public function __construct($pdo) {
        $this->teamModel = new Team($pdo);
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

                default:
                    $this->listPage();
            }
        } else {
            $this->listPage();
        }
    }

    public function listPage() {
        $teams = $this->teamModel->getAllTeams();
        require __DIR__ . '/../views/teams/list.php';
    }

    public function createPage() {
        require __DIR__ . '/../views/teams/create.php';
    }

    public function updatePage($id) {
        $team = $this->teamModel->getTeamById($id);
        require __DIR__ . '/../views/teams/edit.php';
    }

    public function create($data) {
        if (empty($data['name'])) {
            $_SESSION['error'] = 'Le nom de l\'équipe est requis.';
            $_SESSION['old_input'] = $data;
            return false;
        }

        try {
            $this->teamModel->addTeam($data['name']);
            return true;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la création: ' . $e->getMessage();
            $_SESSION['old_input'] = $data;
            return false;
        }
    }

    public function update($data) {
        if (empty($data['id']) || empty($data['name'])) {
            $_SESSION['error'] = 'Tous les champs sont requis.';
            $_SESSION['old_input'] = $data;
            return false;
        }

        try {
            $this->teamModel->updateTeam($data['id'], $data['name']);
            return true;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la modification: ' . $e->getMessage();
            $_SESSION['old_input'] = $data;
            return false;
        }
    }

    public function delete($id) {
        try {
            $this->teamModel->deleteTeam($id);
            return true;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la suppression: ' . $e->getMessage();
            return false;
        }
    }
}

// Si ce fichier est appelé directement
if (basename($_SERVER['SCRIPT_NAME']) === basename(__FILE__)) {
    require_once __DIR__ . '/../config/config.php';
    session_start();

    $controller = new TeamController($pdo);
    $controller->handleRequest();
}
