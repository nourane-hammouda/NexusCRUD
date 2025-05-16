<?php
require_once __DIR__ . '/../models/Project.php';

class ProjectController {
    private $projectModel;
    private $pdo;

    public function __construct($pdo) {
        $this->projectModel = new Project($pdo);
        $this->pdo = $pdo;
    }

    public function listProjects() {
        return $this->projectModel->getAllProjects();
    }

    public function getProject($id) {
        return $this->projectModel->getProjectById($id);
    }

    
    
    public function handleRequest() {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'create':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $this->createProject($_POST);
                    } else {
                        $this->showCreateForm();
                    }
                    break;
                case 'delete':
                    if (isset($_GET['id'])) {
                        $this->delete($_GET['id']);
                    }
                    break;
                case 'edit':
                    if (isset($_GET['id'])) {
                        $this->edit($_GET['id']);
                    }
                    break;
                case 'update':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                        $this->update($_POST);
                    }
                    break;
            }
        }
    }
    public function showAddForm() {
        require __DIR__ . '/../views/projects/add.php';
    }


    public function createProject(array $data) {
        // Validation des données
        if (empty($data['title'])) {
            $_SESSION['error'] = 'Le titre du projet est requis.';
            header('Location: ../views/projects/add.php');
            exit();
        }
        
        try {
            $this->projectModel->addProject(
                $data['title'],
                $data['description'] ?? null
            );
            $_SESSION['success'] = 'Projet ajouté avec succès.';
            header('Location: ../views/projects/list.php');
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de l\'ajout du projet: ' . $e->getMessage();
            header('Location: ../views/projects/add.php');
            exit();
        }
    }

    /**
     * Affiche le formulaire d'édition d'un projet
     */
    public function edit($id) {
        $project = $this->projectModel->getProjectById($id);
        if (!$project) {
            $_SESSION['error'] = 'Projet non trouvé.';
            header('Location: ../views/projects/list.php');
            exit();
        }
        
        // Passer les données du projet à la vue
        require __DIR__ . '/../views/projects/edit.php';
    }

    /**
     * Met à jour un projet existant
     */
    public function update(array $data) {
        if (empty($data['id']) || empty($data['title'])) {
            $_SESSION['error'] = 'ID et titre du projet sont requis.';
            header('Location: ../views/projects/list.php');
            exit();
        }
        
        try {
            $this->projectModel->updateProject(
                $data['id'],
                $data['title'],
                $data['description'] ?? null
            );
            $_SESSION['success'] = 'Projet mis à jour avec succès.';
            header('Location: ../views/projects/list.php');
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la mise à jour du projet: ' . $e->getMessage();
            header('Location: ../views/projects/edit.php?id=' . $data['id']);
            exit();
        }
    }

    /**
     * Supprime un projet
     */
    public function delete($id) {
        try {
            $this->projectModel->deleteProject($id);
            $_SESSION['success'] = 'Projet supprimé avec succès.';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la suppression du projet: ' . $e->getMessage();
        }
        
        header('Location: ../views/projects/list.php');
        exit();
    }

    public function create() {
        require_once __DIR__ . '/../views/projects/create.php';
    }

    public function store($data) {
        try {
            // Validation des données
            if (empty($data['name']) || empty($data['description']) || empty($data['start_date']) || empty($data['end_date'])) {
                throw new Exception("Tous les champs sont obligatoires");
            }

            // Vérification des dates
            if (strtotime($data['start_date']) > strtotime($data['end_date'])) {
                throw new Exception("La date de fin doit être postérieure à la date de début");
            }

            // Insertion dans la base de données
            $stmt = $this->pdo->prepare("
                INSERT INTO projects (name, description, start_date, end_date, status, created_at)
                VALUES (:name, :description, :start_date, :end_date, :status, NOW())
            ");

            $stmt->execute([
                'name' => $data['name'],
                'description' => $data['description'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'status' => $data['status']
            ]);

            $_SESSION['success'] = 'Projet créé avec succès !';
            header('Location: /projet/public/dashboard.php');
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $_SESSION['old_input'] = $data;
            header('Location: /projet/public/projects.php?action=create');
            exit();
        }
    }

    public function index() {
        try {
            $stmt = $this->pdo->query("
                SELECT p.*, 
                       COUNT(t.id) as task_count,
                       COUNT(DISTINCT e.id) as employee_count
                FROM projects p
                LEFT JOIN tasks t ON p.id = t.project_id
                LEFT JOIN project_employees pe ON p.id = pe.project_id
                LEFT JOIN employees e ON pe.employee_id = e.id
                GROUP BY p.id
                ORDER BY p.created_at DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la récupération des projets";
            return [];
        }
    }

    public function show($id) {
        try {
            // Récupérer les informations du projet
            $stmt = $this->pdo->prepare("
                SELECT p.*, 
                       COUNT(t.id) as task_count,
                       COUNT(DISTINCT e.id) as employee_count
                FROM projects p
                LEFT JOIN tasks t ON p.id = t.project_id
                LEFT JOIN project_employees pe ON p.id = pe.project_id
                LEFT JOIN employees e ON pe.employee_id = e.id
                WHERE p.id = :id
                GROUP BY p.id
            ");
            $stmt->execute(['id' => $id]);
            $project = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$project) {
                throw new Exception("Projet non trouvé");
            }

            // Récupérer les tâches du projet
            $stmt = $this->pdo->prepare("
                SELECT t.*, e.name as employee_name
                FROM tasks t
                LEFT JOIN employees e ON t.assigned_to = e.id
                WHERE t.project_id = :id
                ORDER BY t.created_at DESC
            ");
            $stmt->execute(['id' => $id]);
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Récupérer les employés du projet
            $stmt = $this->pdo->prepare("
                SELECT e.*
                FROM employees e
                JOIN project_employees pe ON e.id = pe.employee_id
                WHERE pe.project_id = :id
            ");
            $stmt->execute(['id' => $id]);
            $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'project' => $project,
                'tasks' => $tasks,
                'employees' => $employees
            ];
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            return null;
        }
    }

    public function showCreateForm() {
        try {
            // Récupérer les employés pour le formulaire
            $stmt = $this->pdo->query("SELECT id, name FROM employees");
            $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Inclure la vue
            require __DIR__ . '/../views/projects/create.php';
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des employés : " . $e->getMessage();
            exit();
        }
    }
}

// Instantiation et traitement automatique des requêtes si ce fichier est appelé directement
if (basename($_SERVER['SCRIPT_NAME']) === basename(__FILE__)) {
    require_once __DIR__ . '/../config/config.php';
    session_start();
    
    $controller = new ProjectController($pdo);
    $controller->handleRequest();
}