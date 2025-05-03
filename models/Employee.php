<?php
require_once __DIR__ . '/../config/config.php';
class Employee {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère un employé par son ID
     */
    public function getEmployeeById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM employees WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un employé par son email
     */
    public function getEmployeeByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM employees WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute un nouvel employé
     */
    public function addEmployee($name, $email) {
        $stmt = $this->pdo->prepare("INSERT INTO employees (name, email) VALUES (:name, :email)");
        return $stmt->execute([
            'name' => $name,
            'email' => $email
        ]);
    }

    /**
     * Récupère tous les employés
     */
    public function getAllEmployees() {
        $stmt = $this->pdo->query("SELECT id, name, email, created_at FROM employees");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Supprime un employé
     */
    public function deleteEmployee($id) {
        $stmt = $this->pdo->prepare("DELETE FROM employees WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Met à jour un employé
     */
    public function updateEmployee($id, $name, $email) {
        $stmt = $this->pdo->prepare("UPDATE employees SET name = :name, email = :email WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'email' => $email
        ]);
    }
}
?>
