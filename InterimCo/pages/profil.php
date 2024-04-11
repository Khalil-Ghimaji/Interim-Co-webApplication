<?php
require '../pages/functions/user.php';
if (!isset($_SESSION['authenticated_user'])) {
    header('Location:/login?next=profil');
    exit;
}
$user_id = $_SESSION['authenticated_user'];
$user=get_user_by_id($user_id);
$form_errors=[];
$enable_modif=false;
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $enable_modif = true;
    $old_pwd=$_POST['ancien_pwd'];
    $new_pwd=$_POST['nouveau_pwd'];
    unset($_POST['ancien_pwd']);
    unset($_POST['nouveau_pwd']);

    if($old_pwd) {
        if (!$new_pwd) {
            $form_errors['nouveau_pwd'] = 'Ce champ est obligatoire';
        }
        elseif(!password_verify($old_pwd, $user['mot_de_passe'])){
            $form_errors['ancien_pwd'] = "Mot de passe erroné";
        }
        else{
            if(update_user($user_id,$_POST)) {
                $enable_modif = false;
                $_SESSION['msg']="Profil mis à jour avec succès";
                $_SESSION['msg_type']="success";
                update_password($user_id, $new_pwd);
            }
            else{
                $form_errors['nom_utilisateur']="Le nom d'utilisateur existe déjà";
            }
        }
    }
    elseif($new_pwd){
        $form_errors['ancien_pwd'] = 'Ce champ est obligatoire';
    }
    else{
        if(update_user($user_id,$_POST)) {
            $_SESSION['msg']="Profil mis à jour avec succès";
            $_SESSION['msg_type']="success";
            $enable_modif = false;
        }else{
            $form_errors['nom_utilisateur']="Le nom d'utilisateur existe déjà";
        }
    }
    $user=$_POST;
}
?>

<script>
    let user_data=<?= json_encode($user);?>;
    let form_errors=<?= json_encode($form_errors);?>;
    let enable_modif=<?=$enable_modif?"true":"false"?>;
</script>

<?php
$title='Mon Profil';
include (__DIR__.'/../_header.php');?>
<h1 class="text-center">Mon Profil</h1>
<?php
include (__DIR__.'/../pages/snippets/user_info.php');
?>
<script>
    let modif_profil_btn=document.createElement('button');
    modif_profil_btn.id="changeProfileBtn";
    modif_profil_btn.textContent='Modifier le profil';
    modif_profil_btn.type='button';
    document.getElementById('formFields').appendChild(modif_profil_btn);
    if (enable_modif) {
        enable_profile_modif();
    }
    document.getElementById('changeProfileBtn').addEventListener('click', function() {
        enable_profile_modif();
    });
</script>
<?php
include (__DIR__.'/../_footer.php');
?>