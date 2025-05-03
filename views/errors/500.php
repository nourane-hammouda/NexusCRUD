<?php
http_response_code(500);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Erreur interne du serveur</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <style>
        .error-container {
            text-align: center;
            padding: 50px 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 20px;
        }
        .error-message {
            font-size: 24px;
            margin-bottom: 30px;
        }
        .btn-home {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-home:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">500</div>
        <div class="error-message">Erreur interne du serveur</div>
        <p>Nous sommes désolés, mais quelque chose s'est mal passé de notre côté.</p>
        <p>Notre équipe technique a été informée et travaille à résoudre le problème.</p>
        <p>Vous pouvez essayer de rafraîchir la page ou revenir plus tard.</p>
        <a href="../../index.php" class="btn-home">Retour à l'accueil</a>
    </div>
    
    <?php if (isset($_SESSION['debug_mode']) && $_SESSION['debug_mode'] === true): ?>
    <div class="debug-info">
        <h3>Informations de débogage</h3>
        <?php if (isset($error_message)): ?>
            <p><strong>Message d'erreur:</strong> <?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>
        
        <?php if (isset($error_file)): ?>
            <p><strong>Fichier:</strong> <?= htmlspecialchars($error_file) ?></p>
        <?php endif; ?>
        
        <?php if (isset($error_line)): ?>
            <p><strong>Ligne:</strong> <?= htmlspecialchars($error_line) ?></p>
        <?php endif; ?>
        
        <?php if (isset($error_trace)): ?>
            <p><strong>Trace:</strong></p>
            <pre><?= htmlspecialchars($error_trace) ?></pre>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</body>
</html>