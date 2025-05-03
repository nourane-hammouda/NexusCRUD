<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f5f5;
        }
        .container {
            text-align: center;
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 400px;
        }
        h2 {
            color: #333;
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
        }
        input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
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
            width: 100%;
            margin-top: 1rem;
        }
        .btn-login {
            background-color: #4CAF50;
        }
        .btn-login:hover {
            opacity: 0.9;
        }
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            color: white;
        }
        .alert-danger {
            background-color: #f44336;
        }
        .text-center {
            text-align: center;
            margin-top: 1rem;
        }
        a {
            color: #2196F3;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <form id="login-form" action="/projet/public/login.php" method="POST">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-login">Se connecter</button>
        </form>
        
        <p class="text-center">
            Pas encore inscrit ? <a href="/projet/public/register.php">S'inscrire</a>
        </p>
    </div>
</body>
</html>
