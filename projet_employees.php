<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT employe.nom, employe.mail, employe.equipe 
            FROM projets_employe 
            JOIN employe ON projets_employe.employe_id = employe.id 
            WHERE projets_employe.projet_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h3>Employés assignés au projet</h3>";
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr><th>Nom</th><th>Email</th><th>Équipe</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nom']}</td>
                    <td>{$row['mail']}</td>
                    <td>{$row['equipe']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Aucun employé assigné.";
    }

    $stmt->close();
}
$conn->close();
?>
