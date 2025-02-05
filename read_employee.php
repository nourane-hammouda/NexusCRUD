<?php
include 'config.php';

$sql = "SELECT * FROM employe";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>ID</th><th>Nom</th><th>Email</th><th>Équipe</th><th>Projet</th><th>Actions</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nom']}</td>
                <td>{$row['mail']}</td>
                <td>{$row['equipe']}</td>
                <td>{$row['nom_projet']}</td>
                <td>
                    <a href='update_employee.php?id={$row['id']}'>Modifier</a> | 
                    <a href='delete_employee.php?id={$row['id']}' onclick='return confirm(\"Supprimer cet employé ?\")'>Supprimer</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Aucun employé trouvé.";
}
$conn->close();
?>
