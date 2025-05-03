<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Équipe</title>
    <link rel="stylesheet" href="/projet/public/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter une Équipe</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form action="/projet/teams/add" method="POST" class="form">
            <div class="form-group">
                <label for="equipe">Nom de l'équipe :</label>
                <input type="text" id="equipe" name="equipe" required 
                       value="<?php echo htmlspecialchars($_SESSION['old_input']['equipe'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="membres">Membres :</label>
                <input type="text" id="membres" name="membres" required 
                       value="<?php echo htmlspecialchars($_SESSION['old_input']['membres'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="description">Description :</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($_SESSION['old_input']['description'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="taches">Tâches :</label>
                <textarea id="taches" name="taches" required><?php echo htmlspecialchars($_SESSION['old_input']['taches'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="etat">État :</label>
                <input type="color" id="etat" name="etat" required 
                       value="<?php echo htmlspecialchars($_SESSION['old_input']['etat'] ?? '#ffffff'); ?>">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Ajouter l'équipe</button>
                <a href="/projet/teams" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>
