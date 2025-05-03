<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function handleRequest() {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'register':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $this->register($_POST);
                    } else {
                        $this->registerPage();
                    }
                    break;

                case 'login':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $this->login($_POST);
                    } else {
                        $this->loginPage();
                    }
                    break;

                case 'logout':
                    $this->logout();
                    break;

                case 'list':
                    $this->listPage();
                    break;

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
            }
        }
    }

    // Pages d'authentification
    public function registerPage() {
        require __DIR__ . '/../views/auth/register.php';
    }

    public function loginPage() {
        require __DIR__ . '/../views/auth/login.php';
    }

    public function listPage() {
        $users = $this->getAllUsers();
        require __DIR__ . '/../views/employees/list.php';
    }

    public function createPage() {
        require __DIR__ . '/../views/employees/add.php';
    }

    public function updatePage($id) {
        $user = $this->getUser($id);
        require __DIR__ . '/../views/employees/edit.php';
    }

    // Fonction utilitaire pour extraire un nom depuis un email
    private function extractNameFromEmail($email) {
        $email = strtolower($email);
        $parts = explode('@', $email);
        $namePart = $parts[0];
        $namePart = str_replace(['.', '_', '-'], ' ', $namePart);
        $words = explode(' ', $namePart);
        $words = array_filter($words);
        $words = array_map(function($w) {
            return ucfirst($w);
        }, $words);
        return implode(' ', $words);
    }

    // Méthodes d'authentification
    public function register(array $data) {
        if (empty($data['email']) || empty($data['password'])) {
            $_SESSION['error'] = 'Tous les champs sont requis.';
            $_SESSION['old_input'] = $data;
            return false;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email invalide.';
            $_SESSION['old_input'] = $data;
            return false;
        }

        if ($this->userModel->getUserByEmail($data['email'])) {
            $_SESSION['error'] = 'Cet email est déjà utilisé.';
            $_SESSION['old_input'] = $data;
            return false;
        }

        // Si le nom n'est pas fourni, l'extraire de l'email
        $name = trim($data['name'] ?? '');
        if ($name === '') {
            $name = $this->extractNameFromEmail($data['email']);
        }

        try {
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            $this->userModel->addUser($name, $data['email'], $hashedPassword);
            return true;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de l\'inscription: ' . $e->getMessage();
            $_SESSION['old_input'] = $data;
            return false;
        }
    }

    public function login(array $data) {
        if (empty($data['email']) || empty($data['password'])) {
            $_SESSION['error'] = 'Tous les champs sont requis.';
            return false;
        }

        try {
            $user = $this->userModel->getUserByEmail($data['email']);

            if (!$user || !password_verify($data['password'], $user['password'])) {
                $_SESSION['error'] = 'Identifiants incorrects.';
                return false;
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            return true;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la connexion: ' . $e->getMessage();
            return false;
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /projet/public/home.php');
        exit();
    }

    // Méthodes de gestion des utilisateurs/employés
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
            $this->userModel->addUser($data['name'], $data['email'], null);
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
            $this->userModel->updateUser($data['id'], $data['name'], $data['email']);
            return true;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la modification: ' . $e->getMessage();
            $_SESSION['old_input'] = $data;
            return false;
        }
    }

    public function delete($id) {
        try {
            $this->userModel->deleteUser($id);
            return true;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la suppression: ' . $e->getMessage();
            return false;
        }
    }

    public function getUser($id) {
        return $this->userModel->getUserById($id);
    }

    public function getAllUsers() {
        return $this->userModel->getAllUsers();
    }
}

// Si ce fichier est appelé directement
if (basename($_SERVER['SCRIPT_NAME']) === basename(__FILE__)) {
    require_once __DIR__ . '/../config/config.php';
    session_start();

    $controller = new UserController($pdo);
    $controller->handleRequest();
}
