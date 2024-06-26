<?php
$title="Connexion-InterimCo";
include(__DIR__.'/../_header.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="login-page">
<div class="col-md-6" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
    <h1 class="text-center">Bienvenue sur InterimCo</h1>
    <p class="text-center">Connectez-vous en tant qu'agent DRH</p>
    <form method="POST" class="col-md-6 mx-auto ">
        <div class="mb-3">
            <label for="username" class="form-label">Nom d'utilisateur</label>
            <input type="text" name="username" id="username" class="form-control <?=$formErrors?'is-invalid':'';?>" placeholder="Entrez votre nom d'utilisateur"required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control <?=$formErrors?'is-invalid':'';?>" placeholder="Entrez votre mot de passe" required>
            <div class="invalid-feedback mb-3">
                <?php echo $formErrors;?>
            </div>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
