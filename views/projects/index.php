<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Projets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        h1 {
            color: #333;
            margin: 0;
        }
        .btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s;
        }
        .btn-primary {
            background-color: #2196F3;
        }
        .btn-primary:hover {
            background-color: #1976D2;
        }
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        .project-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1.5rem;
            transition: transform 0.3s;
        }
        .project-card:hover {
            transform: translateY(-5px);
        }
        .project-title {
            color: #333;
            margin: 0 0 1rem 0;
            font-size: 1.2rem;
        }
        .project-description {
            color: #666;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        .project-meta {
            display: flex;
            justify-content: space-between;
            color: #888;
            font-size: 0.8rem;
        }
        .project-status {
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            font-size: 0.8rem;
        }
        .status-planning {
            background-color: #FFC107;
            color: #000;
        }
        .status-in_progress {
            background-color: #2196F3;
            color: white;
        }
        .status-completed {
            background-color: #4CAF50;
            color: white;
        }
        .error-message {
            color: #f44336;
            margin-bottom: 1rem;
            padding: 1rem;
            background-color: #ffebee;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Projets</h1>
            <a href="/projet/public/projects/create.php" class="btn btn-primary">Nouveau Projet</a>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="projects-grid">
            <?php foreach ($projects as $project): ?>
                <div class="project-card">
                    <h2 class="project-title"><?= htmlspecialchars($project['name']) ?></h2>
                    <p class="project-description"><?= htmlspecialchars($project['description']) ?></p>
                    <div class="project-meta">
                        <span>Tâches: <?= $project['task_count'] ?></span>
                        <span>Employés: <?= $project['employee_count'] ?></span>
                    </div>
                    <div class="project-meta">
                        <span>Début: <?= date('d/m/Y', strtotime($project['start_date'])) ?></span>
                        <span class="project-status status-<?= $project['status'] ?>">
                            <?php
                            switch($project['status']) {
                                case 'planning':
                                    echo 'En planification';
                                    break;
                                case 'in_progress':
                                    echo 'En cours';
                                    break;
                                case 'completed':
                                    echo 'Terminé';
                                    break;
                            }
                            ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html> 