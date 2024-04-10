<?php
if (!isset($_SESSION['authenticated_user'])){
    header('Location:/login?next=ajout-contrat');
    exit;
}
$user = $_SESSION['authenticated_user'];
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $id_contrat = insert_contrat($user,$_POST['libelle']);
    $nb_prestation = $_POST['nb_prestation'];
    for($i=1;$i<=$nb_prestation;$i++){
        if($_POST['is_deleted'.$i]=='false'){
            insert_prestation($id_contrat,$_POST['date_debut'.$i],$_POST['date_fin'.$i],$_POST['description'.$i],$_POST['duree'.$i],$_POST['competence'.$i],$_POST['niveau_competence'.$i]);
        }
    }
    estimate_price($id_contrat);
    header('Location:/liste-contrats');
    exit;
}?>
<script>
    let disable_fields=false;
    prestations_content=[];
    let libelle_valeur='';
    let mode_modif=!disable_fields;
</script>
<?php
$title='Nouveau Contrat';
include (__DIR__.'/../_header.php');
?>
<h1 class="text-center"><?=$title?></h1>
<?php
include (__DIR__.'/../pages/snippets/form_contract.php');
include (__DIR__.'/../_footer.php');
?>

