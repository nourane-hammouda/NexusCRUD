<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM projets WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Projet supprimé.";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
