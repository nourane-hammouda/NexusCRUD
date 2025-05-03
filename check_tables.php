<?php
require_once 'config/config.php';

try {
    // Vérifier et créer la table projects si elle n'existe pas
    $stmt = $pdo->query("SHOW TABLES LIKE 'projects'");
    if ($stmt->rowCount() == 0) {
        $sql = "CREATE TABLE projects (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            description TEXT,
            status ENUM('ongoing', 'completed', 'pending') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $pdo->exec($sql);
        echo "<p style='color: green;'>✅ Table 'projects' créée avec succès</p>";
    } else {
        echo "<p style='color: green;'>✅ Table 'projects' existe déjà</p>";
    }

    // Vérifier et créer la table tasks si elle n'existe pas
    $stmt = $pdo->query("SHOW TABLES LIKE 'tasks'");
    if ($stmt->rowCount() == 0) {
        $sql = "CREATE TABLE tasks (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            project_id INT,
            status ENUM('pending', 'in progress', 'completed') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $pdo->exec($sql);
        echo "<p style='color: green;'>✅ Table 'tasks' créée avec succès</p>";
    } else {
        echo "<p style='color: green;'>✅ Table 'tasks' existe déjà</p>";
    }

    // Vérifier et créer la table employees si elle n'existe pas
    $stmt = $pdo->query("SHOW TABLES LIKE 'employees'");
    if ($stmt->rowCount() == 0) {
        $sql = "CREATE TABLE employees (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        $pdo->exec($sql);
        echo "<p style='color: green;'>✅ Table 'employees' créée avec succès</p>";
    } else {
        echo "<p style='color: green;'>✅ Table 'employees' existe déjà</p>";
    }

} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Erreur : " . $e->getMessage() . "</p>";
} 