<?php
include 'config.php';

// Vérifiez que la clé 'REQUEST_METHOD' est définie
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données et effectuer la mise à jour
    $id = intval($_POST['id']);
    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);
    $deadline = $_POST['deadline'];
    $etat = htmlspecialchars($_POST['etat']);

    $sql = "UPDATE projets SET nom=?, description=?, deadline=?, etat=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nom, $description, $deadline, $etat, $id);

    if ($stmt->execute()) {
        echo "Projet mis à jour avec succès.";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Aucune donnée soumise.";
}

$conn->close();
?>
