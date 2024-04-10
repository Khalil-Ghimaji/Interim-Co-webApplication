<?php
session_start();

if(isset($_POST['id_prestation'])) {
    $id_prestation = $_POST['id_prestation'];
    $_SESSION['id_prestation_selectionnee'] = $id_prestation;
} elseif (isset($_SESSION['id_prestation_selectionnee'])) {
    $id_prestation = $_SESSION['id_prestation_selectionnee'];
}
?>
<?php
$prestation=get_data("prestations",$id_prestation);
$competence=get_competence_prestation($prestation);
?>
<?php
$title='Detail Prestation';
include(__DIR__.'/../_header.php');?>
<?php
$lien_retour="/detail_contrat";
include(__DIR__.'/../entete.php');
?>
<br>
<div class="container">
    <h2>Détails de la Prestation</h2>
    <p>ID : <?= $prestation['id']; ?></p>
    <p>Date de Début : <?= $prestation['date_debut']; ?></p>
    <p>Date de Fin : <?= $prestation['date_fin']; ?></p>
    <p>Durée(jours) : <?= $prestation['duree']; ?></p>
    <p>Prix(dinars) : <?= $prestation['prix']; ?></p>
    <p>Description : <?= $prestation['description']; ?></p>
    <p>Competence requise : <?= $competence['competence'].'('.$competence['niveau_competence'].')'?></p>
</div>
<div class="container">
    <?php
    $status=get_etat_contrat($prestation['id_contrat']);
    if($status=="Accepté" or $status=="Finalisé"){
        include 'employes_detail.php';
    }
    ?>
</div>