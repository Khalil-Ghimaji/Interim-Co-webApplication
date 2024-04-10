<?php
    require 'functions.php';
    require 'ConnexionBD.php';

    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(isset($_SESSION['authenticated_admin'])&&$_SESSION['authenticated_role']=="admin"){
        header('Location:/');
        exit;
    }
    $pdo = ConnexionBD::openConnexion();
    $formErrors=login("admin",$_GET['next']??'/',$pdo);
    $pdo=null;
    ConnexionBD::close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
    <h1 class="text-center">Bienvenue sur InterimCo</h1>
    <p class="text-center">Connectez-vous en tant que Admin</p>
    <form method="POST" class="col-md-6 mx-auto border p-4">
        <div class="mb-3">
            <label for="username" class="form-label ">Login</label>
            <input type="text" name="username" id="username" class="form-control <?=$formErrors?'is-invalid':'';?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control <?=$formErrors?'is-invalid':'';?>" required>
            <div class="invalid-feedback mb-3">
                <?php echo $formErrors;?>
            </div>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>
    </form>
</div>
    
</body>
</html>