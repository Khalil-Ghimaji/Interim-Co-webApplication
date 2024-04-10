<?php
session_start();

$user_id =$_SESSION['authenticated_drh'];
$user=get_data('agentsdrh',$user_id);
$user_email = $user['email'];
$user_username = $user['nom_utilisateur'];
$user_phone_number = $user['numero_telephone'];
$user_nom=$user['nom'];
$user_prenom=$user['prenom'];
?>

<?php
$title='Profil';
include(__DIR__.'/../_header.php');?>
<?php
$lien_retour="javascript:history.back()";
include(__DIR__.'/../entete.php');
?>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="user-info">
                <h1>Mon Profil</h1>
                <div class="detail">
                    <strong>Nom d'Utilisateur:</strong>
                    <span><?php echo $user_username; ?></span>
                </div>
                <div class="detail">
                    <strong>Nom :</strong>
                    <span><?php echo $user_nom; ?></span>
                </div>
                <div class="detail">
                    <strong>Prenom :</strong>
                    <span><?php echo $user_prenom; ?></span>
                </div>
                <div class="detail">
                    <strong>Email:</strong>
                    <span><?php echo $user_email; ?></span>
                </div>
                <div class="detail">
                    <strong>Numéro de Téléphone:</strong>
                    <span><?php echo $user_phone_number; ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>