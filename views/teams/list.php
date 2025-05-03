<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Équipes</title>
    <link rel="stylesheet" href="/projet/public/css/style.css">
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #4CAF50;
        }
        .btn-danger {
            background-color: #f44336;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .table th {
            background-color: #f5f5f5;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-danger {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Liste des Équipes</h1>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <a href="/projet/public/teams.php?action=create" class="btn btn-primary">Créer une nouvelle équipe</a>

            <table class="table">
                <thead>
                    <tr>
                        <th>Nom de l'équipe</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($teams as $team): ?>
                        <tr>
                            <td><?= htmlspecialchars($team['name']) ?></td>
                            <td>
                                <a href="/projet/public/teams.php?action=update&id=<?= $team['id'] ?>" class="btn btn-primary">Modifier</a>
                                <a href="/projet/public/teams.php?action=delete&id=<?= $team['id'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette équipe ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html> 