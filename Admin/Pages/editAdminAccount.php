<?php
    require_once 'header.php';
?>

<div class="container mt-5">
        <?=alertMessage();?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Modifier mot de passe
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="oldPassword">Ancien mot de passe</label>
                                <input type="password" class="form-control" id="oldPassword" name="oldPassword"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="newPassword">Nouveau mot de passe:</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary">modifier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $pdo=ConnexionBD::openConnexion();
    $admin=getAdmin($pdo);
    $currentPassword = $admin['mot_de_passe'];
    if(password_verify($oldPassword,$currentPassword)) {
        updatePassword($pdo,$newPassword);
        redirect('/','Mot de passe mis à jour avec succès.',"success");
    } else {
        redirect('/editAdminAccount','Mot de passe incorrect!',"danger");
    }

    $pdo=null;
    ConnexionBD::close();
}
?>

<?php require_once 'footer.php'; ?>
