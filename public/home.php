<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Si l'utilisateur est déjà connecté, rediriger vers le dashboard
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: /projet/public/dashboard.php");
    exit();
}

$title = "Accueil - Gestion de Projets";

ob_start();
?>
<div class="card">
    <h1>Bienvenue dans NexusCRUD</h1>
    <div class="buttons">
        <a href="/projet/public/login.php" class="btn btn-login">Se connecter</a>
        <a href="/projet/public/register.php" class="btn btn-register">S'inscrire</a>
    </div>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../views/layouts/base.php';
?> 