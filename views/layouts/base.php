<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Gestion de Projets' ?></title>
    <link rel="stylesheet" href="/projet/public/css/style.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f5f5f5;
        }
        .container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/navbar.php'; ?>
    
    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </div>

    <script>
        // Script pour le menu responsive
        document.addEventListener('DOMContentLoaded', function() {
            const navbarMenu = document.querySelector('.navbar-menu');
            const toggleButton = document.createElement('button');
            toggleButton.className = 'btn btn-primary';
            toggleButton.innerHTML = '☰';
            toggleButton.style.margin = '0';
            toggleButton.addEventListener('click', function() {
                navbarMenu.classList.toggle('active');
            });
            document.querySelector('.navbar').appendChild(toggleButton);
        });
    </script>
</body>
</html> 