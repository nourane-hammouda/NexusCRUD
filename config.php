<?php
$config = include 'config.inc.php';

$conn = new mysqli($config['host'], $config['user'], $config['password'], $config['database']);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}
?>
