<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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
        .btn-register {
            background-color: #2196F3;
        }
        .btn-register:hover {
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
            color: #4CAF50;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <form id="register-form" action="/projet/public/register.php" method="POST">
            <div class="form-group">
                <label for="name">Nom complet :</label>
                <input type="text" id="name" name="name" required value="<?= htmlspecialchars($_SESSION['old_input']['name'] ?? '') ?>">
                <small id="nameHelp" style="color: #888;">Ce champ peut être pré-rempli automatiquement à partir de votre email.</small>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_SESSION['old_input']['email'] ?? '') ?>">
                <small id="emailHelp" style="color: #888;">Ce champ doit contenir votre nom et prenom complet avec un @ et un .com.</small>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe :</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div>

            <button type="submit" class="btn btn-register">S'inscrire</button>
        </form>
        
        <p class="text-center">
            Déjà inscrit ? <a href="/projet/public/login.php">Se connecter</a>
        </p>
    </div>
    <script>
    // Pré-remplir le champ nom à partir de l'email
    document.getElementById('email').addEventListener('input', function() {
        const email = this.value.trim();
        const nameInput = document.getElementById('name');
        
        // Vérifier si l'email contient un @
        if (email.includes('@')) {
            // Récupérer la partie avant le @
            const namePart = email.split('@')[0];
            
            // Mettre la première lettre en majuscule et le reste en minuscules
            const formattedName = namePart.charAt(0).toUpperCase() + namePart.slice(1).toLowerCase();
            
            // Ne remplir que si le champ nom est vide
            if (!nameInput.value) {
                nameInput.value = formattedName;
            }
        }
    });
    </script>
</body>
</html>