<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusCRUD - Gestion de Projets</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Styles CSS -->
    <link rel="stylesheet" href="/projet/public/css/style.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/projet/public/images/favicon.png">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <a href="/projet/public/" class="navbar-brand">
                    <i class="fas fa-project-diagram"></i> NexusCRUD
                </a>
                
                <div class="navbar-nav">
                    <a href="/projet/public/" class="nav-link">
                        <i class="fas fa-home"></i> Accueil
                    </a>
                    <a href="/projet/public/?page=projects" class="nav-link">
                        <i class="fas fa-tasks"></i> Projets
                    </a>
                    <a href="/projet/public/?page=tasks" class="nav-link">
                        <i class="fas fa-list-check"></i> Tâches
                    </a>
                    <a href="/projet/public/?page=employees" class="nav-link">
                        <i class="fas fa-users"></i> Employés
                    </a>
                    <a href="/projet/public/?page=teams" class="nav-link">
                        <i class="fas fa-user-group"></i> Équipes
                    </a>
                </div>
                
                <div class="navbar-user">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-link nav-link dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="/projet/public/?page=profile"><i class="fas fa-user"></i> Profil</a></li>
                                <li><a class="dropdown-item" href="/projet/public/?page=settings"><i class="fas fa-cog"></i> Paramètres</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/projet/public/logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="/projet/public/login.php" class="nav-link">
                            <i class="fas fa-sign-in-alt"></i> Connexion
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success']; ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error']; ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html> 