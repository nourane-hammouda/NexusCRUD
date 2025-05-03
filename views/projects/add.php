<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Projet</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Ajouter un Projet</h2>
        <form action="index.php?action=create" method="POST">
            <label for="title">Titre du projet :</label>
            <input type="text" id="title" name="title" required><br>

            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea><br>

            <label for="start_date">Date de début :</label>
            <input type="date" id="start_date" name="start_date" required><br>

            <label for="end_date">Date de fin :</label>
            <input type="date" id="end_date" name="end_date" required><br>

            <label for="status">Statut :</label>
            <select id="status" name="status" required>
                <option value="en_cours">En cours</option>
                <option value="termine">Terminé</option>
                <option value="en_attente">En attente</option>
            </select><br>

            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>
</html>
<!-- Champ de recherche -->
<input type="text" id="search-input" placeholder="Rechercher un projet...">

<table id="projects-table">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Projet A</td>
            <td>Description du projet A</td>
            <td><a href="#">Modifier</a> | <a href="#">Supprimer</a></td>
        </tr>
        <tr>
            <td>Projet B</td>
            <td>Description du projet B</td>
            <td><a href="#">Modifier</a> | <a href="#">Supprimer</a></td>
        </tr>
        <!-- Ajoute d'autres lignes ici -->
    </tbody>
</table>
