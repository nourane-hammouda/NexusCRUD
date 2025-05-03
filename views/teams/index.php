<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Équipes</title>
    <link rel="stylesheet" href="/projet/public/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Liste des Équipes</h1>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                echo htmlspecialchars($_SESSION['success']);
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <a href="/projet/teams/add" class="btn btn-primary">Ajouter une Équipe</a>

        <div class="teams-grid">
            <?php foreach ($teams as $team): ?>
                <div class="team-card" style="border-color: <?php echo htmlspecialchars($team['etat']); ?>">
                    <h3><?php echo htmlspecialchars($team['equipe']); ?></h3>
                    <p><strong>Membres:</strong> <?php echo htmlspecialchars($team['membres']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($team['description']); ?></p>
                    <p><strong>Tâches:</strong> <?php echo htmlspecialchars($team['taches']); ?></p>
                    <div class="team-actions">
                        <a href="/projet/teams/edit/<?php echo $team['id']; ?>" class="btn btn-warning">Modifier</a>
                        <a href="/projet/teams/delete/<?php echo $team['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette équipe ?')">Supprimer</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html> 