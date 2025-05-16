<?php
// Vérification de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: /projet/public/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .navbar {
            background-color: #333;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 1rem;
        }
        .navbar a:hover {
            color: #ddd;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s;
        }
        .btn-danger {
            background-color: #f44336;
        }
        .btn-danger:hover {
            background-color: #d32f2f;
        }
        .welcome-message {
            margin-bottom: 2rem;
            color: #333;
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1.5rem;
            text-align: center;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #2196F3;
            margin: 0.5rem 0;
        }
        .list-item {
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        .list-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div>
            <a href="/projet/public/dashboard.php">Tableau de bord</a>
            <a href="/projet/public/projects.php">Projets</a>
            <a href="/projet/public/tasks.php">Tâches</a>
            <a href="/projet/public/employees.php">Employés</a>
            <a href="/projet/public/teams.php">Équipes</a>
            <a href="/projet/public/projects.php?action=create" class="btn" style="background-color: #4CAF50;">Nouveau Projet</a>
        </div>
        <div>
            <span style="color: white; margin-right: 1rem;"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Utilisateur') ?></span>
            <a href="/projet/public/logout.php" class="btn btn-danger">Déconnexion</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="welcome-message">Bienvenue sur votre tableau de bord</h1>

        <div class="stats-container">
            <div class="stat-card">
                <h3>Projets</h3>
                <div class="stat-number" id="projects-count"><?= is_array($projects) ? count($projects) : 0 ?></div>
                <a href="/projet/public/projects.php">Voir tous les projets</a>
            </div>
            <div class="stat-card">
                <h3>Tâches</h3>
                <div class="stat-number" id="tasks-count"><?= is_array($tasks) ? count($tasks) : 0 ?></div>
                <a href="/projet/public/tasks.php">Voir toutes les tâches</a>
            </div>
            <div class="stat-card">
                <h3>Employés</h3>
                <div class="stat-number" id="users-count"><?= is_array($users) ? count($users) : 0 ?></div>
                <a href="/projet/public/employees.php">Voir tous les employés</a>
            </div>
        </div>

        <div class="card">
            <h2>Projets récents</h2>
            <?php if (!empty($projects)): ?>
                <div>
                    <?php foreach (array_slice($projects, 0, 5) as $project): ?>
                        <div class="list-item">
                            <h3><?= htmlspecialchars($project['name']) ?></h3>
                            <p><?= htmlspecialchars($project['description'] ?? 'Pas de description') ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucun projet trouvé.</p>
            <?php endif; ?>
        </div>

        <div class="card">
            <h2>Tâches récentes</h2>
            <?php if (!empty($tasks)): ?>
                <div>
                    <?php foreach (array_slice($tasks, 0, 5) as $task): ?>
                        <div class="list-item">
                            <h3><?= htmlspecialchars($task['title']) ?></h3>
                            <p><?= htmlspecialchars($task['description'] ?? 'Pas de description') ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucune tâche trouvée.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
    // Fonction pour mettre à jour les statistiques
    function updateStats() {
        // Mettre à jour les projets
        fetch('/projet/public/get_projects.php')
            .then(response => response.json())
            .then(projects => {
                document.getElementById('projects-count').textContent = projects.length;
            })
            .catch(error => console.error('Erreur lors de la mise à jour des projets:', error));

        // Mettre à jour les tâches
        fetch('/projet/public/get_tasks.php')
            .then(response => response.json())
            .then(tasks => {
                document.getElementById('tasks-count').textContent = tasks.length;
            })
            .catch(error => console.error('Erreur lors de la mise à jour des tâches:', error));

        // Mettre à jour les employés
        fetch('/projet/public/get_users.php')
            .then(response => response.json())
            .then(users => {
                document.getElementById('users-count').textContent = users.length;
            })
            .catch(error => console.error('Erreur lors de la mise à jour des employés:', error));
    }

    // Mettre à jour les statistiques toutes les 5 secondes
    setInterval(updateStats, 5000);

    // Mettre à jour les statistiques immédiatement après l'ajout d'un projet
    if (window.location.href.includes('action=store')) {
        updateStats();
    }
    </script>
</body>
</html> 