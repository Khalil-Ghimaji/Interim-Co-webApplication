<?php
require '../pages/functions/user.php';
if(isset($_SESSION['authenticated_user'])){
    header('Location:/');
    exit;
}
$form_errors=[];
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $_POST['mot_de_passe']=password_hash($_POST['mot_de_passe'],PASSWORD_DEFAULT);
    if(create_new_client($_POST)){
        header('Location:/login');
        exit;
    }
    else{
        $form_errors['nom_utilisateur']="Le nom d'utilisateur existe déjà";
    }
}?>
<script>
    let form_errors=<?= json_encode($form_errors);?>;
    let user_data=[];
</script>

<?php
$title = 'inscription';
include (__DIR__.'/../_public_header.php');
?>
    <h1 class="text-center">Bienvenue sur InterimCo</h1>
    <p class="text-center">Inscrivez-vous</p>
<?php
include (__DIR__.'/../pages/snippets/user_info.php');
?>
<script>
    enable_fields();
    add_username_error();
    add_password_field('mot_de_passe');
    document.getElementById('mot_de_passe').required=true;
    add_submit_button("S'inscrire");
</script>
<?php
include (__DIR__.'/../_footer.php');
?>