<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);
    $deadline = $_POST['deadline'];
    $etat = htmlspecialchars($_POST['etat']);

    $sql = "INSERT INTO projets (nom, description, deadline, etat) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nom, $description, $deadline, $etat);

    if ($stmt->execute()) {
        echo "Projet ajouté avec succès.";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
