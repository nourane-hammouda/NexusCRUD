<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $projet_id = intval($_POST['projet_id']);
    $employe_id = intval($_POST['employe_id']);

    // Vérifier si l'affectation existe déjà
    $check = $conn->prepare("SELECT id FROM projets_employe WHERE projet_id=? AND employe_id=?");
    $check->bind_param("ii", $projet_id, $employe_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows == 0) {
        $sql = "INSERT INTO projets_employe (projet_id, employe_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $projet_id, $employe_id);

        if ($stmt->execute()) {
            echo "Employé assigné au projet.";
        } else {
            echo "Erreur : " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Cet employé est déjà assigné à ce projet.";
    }
    $check->close();
}
$conn->close();
?>

<!-- Formulaire d'assignation -->
<form method="POST" action="assign_employee.php">
    <label>Projet :</label>
    <select name="projet_id">
        <?php
        $result = $conn->query("SELECT id, nom FROM projets");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['nom']}</option>";
        }
        ?>
    </select>
    <label>Employé :</label>
    <select name="employe_id">
        <?php
        $result = $conn->query("SELECT id, nom FROM employe");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['nom']}</option>";
        }
        ?>
    </select>
    <button type="submit">Assigner</button>
</form>
