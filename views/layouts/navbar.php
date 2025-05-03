<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar">
    <div class="navbar-brand">
        <a href="/projet/public/index.php">Gestion de Projets</a>
    </div>
    
    <div class="navbar-menu">
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Menu pour utilisateurs connectés -->
            <a href="/projet/public/dashboard.php" class="nav-item">Tableau de bord</a>
            <a href="/projet/public/projects.php" class="nav-item">Projets</a>
            <a href="/projet/public/users.php" class="nav-item">Utilisateurs</a>
            <a href="/projet/public/teams.php" class="nav-item">Équipes</a>
            <div class="nav-item dropdown">
                <span class="dropdown-toggle"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                <div class="dropdown-menu">
                    <a href="/projet/public/profile.php" class="dropdown-item">Mon profil</a>
                    <a href="/projet/public/logout.php" class="dropdown-item">Déconnexion</a>
                </div>
            </div>
        <?php else: ?>
            <!-- Menu pour utilisateurs non connectés -->
            <a href="/projet/public/login.php" class="nav-item">Connexion</a>
            <a href="/projet/public/register.php" class="nav-item">Inscription</a>
        <?php endif; ?>
    </div>
</nav> 