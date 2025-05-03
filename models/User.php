<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Retourne une instance PDO (évite cette méthode si possible)
     */
    public function getPdo() {
        return $this->pdo;
    }

    /**
     * Récupère un utilisateur par son ID
     */
    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un utilisateur par son email
     */
    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute un nouvel utilisateur
     */
    public function addUser($name, $email, $password) {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
    }

    /**
     * Récupère tous les utilisateurs
     */
    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT id, name, email, created_at FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateUser($id, $name, $email) {
        $stmt = $this->pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $id]);
    }
}
