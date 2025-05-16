<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Projet</title>
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
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
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
        .btn-primary {
            background-color: #4CAF50;
        }
        .btn-primary:hover {
            background-color: #45a049;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .section-title {
            color: #333;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #eee;
        }
        .members-list, .tasks-list {
            margin-top: 1rem;
        }
        .member-item, .task-item {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-bottom: 1px solid #eee;
        }
        .member-item:last-child, .task-item:last-child {
            border-bottom: none;
        }
        .btn-remove {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            cursor: pointer;
            margin-left: auto;
        }
        .btn-remove:hover {
            background-color: #c82333;
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
        </div>
        <div>
            <span style="color: white; margin-right: 1rem;"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Utilisateur') ?></span>
            <a href="/projet/public/logout.php" class="btn" style="background-color: #f44336;">Déconnexion</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="section-title">Nouveau Projet</h1>
        
        <form action="/projet/public/dashboard.php?action=store" method="POST" class="card">
            <!-- Informations de base du projet -->
            <div class="form-group">
                <label for="title">Titre du projet *</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="start_date">Date de début *</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>

            <div class="form-group">
                <label for="end_date">Date de fin *</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>

            <div class="form-group">
                <label for="status">Statut *</label>
                <select id="status" name="status" required>
                    <option value="en_cours">En cours</option>
                    <option value="en_attente">En attente</option>
                    <option value="termine">Terminé</option>
                </select>
            </div>

            <!-- Membres de l'équipe -->
            <h2 class="section-title">Membres de l'équipe</h2>
            <div class="form-group">
                <label for="team_members">Sélectionner les membres</label>
                <select id="team_members" name="team_members[]" multiple></select>
            </div>

            <!-- Tâches -->
            <h2 class="section-title">Tâches</h2>
            <div id="tasks-container">
                <div class="task-item">
                    <div class="form-group" style="flex: 1; margin-right: 1rem;">
                        <label for="task_title">Titre de la tâche</label>
                        <input type="text" name="tasks[0][title]" required>
                    </div>
                    <div class="form-group" style="flex: 1; margin-right: 1rem;">
                        <label for="task_assignee">Assigné à</label>
                        <select name="tasks[0][assignee_id]" class="assignee-select"></select>
                    </div>
                    <div class="form-group" style="flex: 1; margin-right: 1rem;">
                        <label for="task_deadline">Date limite</label>
                        <input type="date" name="tasks[0][deadline]" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" onclick="addTask()">Ajouter une tâche</button>

            <!-- Commentaires -->
            <h2 class="section-title">Commentaires initiaux</h2>
            <div class="form-group">
                <textarea id="initial_comments" name="initial_comments" placeholder="Ajoutez des commentaires initiaux sur le projet..."></textarea>
            </div>

            <!-- Boutons d'action -->
            <div style="display: flex; justify-content: space-between; margin-top: 2rem;">
                <a href="/projet/public/dashboard.php" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Créer le projet</button>
            </div>
        </form>
    </div>

    <script>
    // Remplir dynamiquement les utilisateurs dans les <select>
    fetch('/projet/public/get_users.php')
        .then(res => res.json())
        .then(users => {
            const teamSelect = document.getElementById('team_members');
            users.forEach(u => {
                const opt = document.createElement('option');
                opt.value = u.id;
                opt.textContent = u.name;
                teamSelect.appendChild(opt);
            });
            // Pour tous les select d'assignation de tâche
            document.querySelectorAll('.assignee-select').forEach(sel => {
                users.forEach(u => {
                    const opt = document.createElement('option');
                    opt.value = u.id;
                    opt.textContent = u.name;
                    sel.appendChild(opt.cloneNode(true));
                });
            });
        });

    // Si on ajoute dynamiquement des tâches, il faut aussi remplir le select
    function addTask() {
        const tasksContainer = document.getElementById('tasks-container');
        const taskCount = tasksContainer.querySelectorAll('.task-item').length;
        const div = document.createElement('div');
        div.className = 'task-item';
        div.innerHTML = `
            <div class="form-group" style="flex: 1; margin-right: 1rem;">
                <label for="task_title">Titre de la tâche</label>
                <input type="text" name="tasks[${taskCount}][title]" required>
            </div>
            <div class="form-group" style="flex: 1; margin-right: 1rem;">
                <label for="task_assignee">Assigné à</label>
                <select name="tasks[${taskCount}][assignee_id]" class="assignee-select"></select>
            </div>
            <div class="form-group" style="flex: 1; margin-right: 1rem;">
                <label for="task_deadline">Date limite</label>
                <input type="date" name="tasks[${taskCount}][deadline]" required>
            </div>
        `;
        tasksContainer.appendChild(div);
        // Remplir le select nouvellement ajouté
        fetch('/projet/public/get_users.php')
            .then(res => res.json())
            .then(users => {
                const sel = div.querySelector('.assignee-select');
                users.forEach(u => {
                    const opt = document.createElement('option');
                    opt.value = u.id;
                    opt.textContent = u.name;
                    sel.appendChild(opt);
                });
            });
    }
    </script>
</body>
</html> 