<?php
require_once 'config/config.php';

try {
    // Vérifier si la table users existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    $tableExists = $stmt->rowCount() > 0;

    if ($tableExists) {
        echo "<h2>Structure de la base de données</h2>";
        echo "<p style='color: green;'>✅ La table 'users' existe</p>";
        
        // Afficher la structure de la table
        $stmt = $pdo->query("DESCRIBE users");
        $columns = $stmt->fetchAll();
        
        echo "<h3>Structure de la table 'users' :</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Champ</th><th>Type</th><th>Null</th><th>Clé</th><th>Valeur par défaut</th><th>Extra</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>" . $column['Field'] . "</td>";
            echo "<td>" . $column['Type'] . "</td>";
            echo "<td>" . $column['Null'] . "</td>";
            echo "<td>" . $column['Key'] . "</td>";
            echo "<td>" . $column['Default'] . "</td>";
            echo "<td>" . $column['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'>❌ La table 'users' n'existe pas</p>";
        echo "<p>Création de la table...</p>";
        
        // Créer la table users
        $sql = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $pdo->exec($sql);
        echo "<p style='color: green;'>✅ La table 'users' a été créée avec succès</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Erreur : " . $e->getMessage() . "</p>";
} 