<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: /projet/public/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un employé</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <?php require_once __DIR__ . '/../includes/header.php'; ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Ajouter un employé</h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                                ?>
                            </div>
                        <?php endif; ?>

                        <form action="?page=employees&action=create" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom complet</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="name" 
                                       name="name" 
                                       value="<?php echo isset($_SESSION['old_input']['name']) ? htmlspecialchars($_SESSION['old_input']['name']) : ''; ?>"
                                       required>
                                <?php unset($_SESSION['old_input']['name']); ?>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       value="<?php echo isset($_SESSION['old_input']['email']) ? htmlspecialchars($_SESSION['old_input']['email']) : ''; ?>"
                                       required>
                                <?php unset($_SESSION['old_input']['email']); ?>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="?page=employees" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Retour
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html> 