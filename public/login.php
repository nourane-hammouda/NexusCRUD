<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si l'utilisateur est déjà connecté, rediriger vers le dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: /projet/public/dashboard.php");
    exit();
}

// Gestion de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/config.php';
    require_once __DIR__ . '/../controllers/UserController.php';
    
    $userController = new UserController($pdo);
    
    if ($userController->login($_POST)) {
        header("Location: /projet/public/dashboard.php");
        exit();
    }
}

$title = "Connexion - Gestion de Projets";

ob_start();
?>
<div class="card">
    <h1>Connexion</h1>
    
    <form action="/projet/public/login.php" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required 
                   value="<?= isset($_SESSION['old_input']['email']) ? htmlspecialchars($_SESSION['old_input']['email']) : '' ?>">
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>
    </form>

    <p>Vous n'avez pas de compte ? <a href="/projet/public/register.php">Inscrivez-vous</a></p>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../views/layouts/base.php';
?>
