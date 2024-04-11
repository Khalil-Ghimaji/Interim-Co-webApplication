<?php
session_start();
if(isset($_POST['id_prestation'])) {
    $id_prestation = $_POST['id_prestation'];
    $_SESSION['id_prestation_selectionnee'] = $id_prestation;
} elseif (isset($_SESSION['id_prestation_selectionnee'])) {
    $id_prestation = $_SESSION['id_prestation_selectionnee'];
}
$prestation=get_data("prestations",$id_prestation);
$competence=get_competence_prestation($prestation);
if( isset($_POST['confirmer']))
{
    update_prix_contrat($_SESSION['id_contrat_selectionne']);
    header("Location:/traitement_contrat");
    exit();
}
?>
<?php
$title='Traitement Prestation';
include(__DIR__.'/../_header.php');?>
<?php
$lien_retour="/traitement_contrat";
include(__DIR__.'/../entete.php');?>
<br>
<div class="container">
    <h1>Traitement de la Prestation</h1>
    <h2>Détails de la Prestation</h2>
    <p>ID : <?= $prestation['id']; ?></p>
    <p>Date de Début : <?= $prestation['date_debut']; ?></p>
    <p>Date de Fin : <?= $prestation['date_fin']; ?></p>
    <p>Date de Début Finale : <?= $prestation['date_deb_finale']; ?></p>
    <p>Date de Fin Finale: <?= $prestation['date_fin_finale']; ?></p>
    <p>Durée(jours) : <?= $prestation['duree']; ?></p>
    <p>Prix(dinars) : <?= $prestation['prix']; ?></p>
    <p>Prix Final(dinars) : <?= $prestation['prix_final']; ?></p>
    <p>Description : <?= $prestation['description']; ?></p>
    <p>Competence requise : <?= $competence['competence'].'('.$competence['niveau_competence'].')'?></p>

</div>
<div class="container">

<?php
include 'prix_prestation.php';
?>
</div>
<div class="container">

    <?php
    include 'selection_date.php';
    ?>
</div>

<div class="container">
    <div class="text-left">
        <a href="/gestion_employes" class="btn btn-primary">Gérer employés</a>
    </div>
</div>

<div class="container">
    <div class="text-left">
        <form method="post">
            <button type="submit" class="btn btn-primary" name="confirmer">Confirmer les données de la prestation</button>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>