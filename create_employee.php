<?php
include 'config.php';

// Vérification de la méthode de requête
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = htmlspecialchars($_POST['nom']);
    $mail = htmlspecialchars($_POST['mail']);
    $equipe = htmlspecialchars($_POST['equipe']);
    $nom_projet = htmlspecialchars($_POST['nom_projet']);
    $projet = intval($_POST['projet']);

    // Vérification si l'email existe déjà
    $check = $conn->prepare("SELECT id FROM employe WHERE mail=?");
    $check->bind_param("s", $mail);
    $check->execute();
    $check->store_result();

    if ($check->num_rows == 0) {
        $sql = "INSERT INTO employe (nom, mail, equipe, nom_projet, projet) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nom, $mail, $equipe, $nom_projet, $projet);

        if ($stmt->execute()) {
            echo "Employé ajouté avec succès.";
        } else {
            echo "Erreur : " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Un employé avec cet email existe déjà.";
    }

    $check->close();
} else {
    // Si la méthode n'est pas POST
    echo "Aucune donnée soumise.";
}

$conn->close();
?>
