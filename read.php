<?php
include 'config.php'; // Assurez-vous que ce fichier contient bien la connexion

// Vérification si la connexion est active
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérification de l'existence de la table
$checkTable = $conn->query("SHOW TABLES LIKE 'projets'");
if ($checkTable->num_rows == 0) {
    die("Erreur : La table 'projets' n'existe pas.");
}

// Exécution de la requête
$sql = "SELECT * FROM projets";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "Projet : " . $row['nom'] . "<br>";
    }
} else {
    echo "Erreur SQL : " . $conn->error;
}
?>
