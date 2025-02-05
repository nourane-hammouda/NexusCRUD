<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM employe WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Employé supprimé avec succès.";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
