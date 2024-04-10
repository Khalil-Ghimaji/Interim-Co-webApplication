<?php
session_start();


include 'prestations_du_contrat.php';

if (isset($_POST['id_contrat'])) {
    $id_contrat = $_POST['id_contrat'];
    $_SESSION['id_contrat_selectionne'] = $id_contrat;
} else {
    // Rediriger ou gérer l'erreur selon votre logique
    $id_contrat = $_SESSION['id_contrat_selectionne'];
}
$contrat = get_data("contrats", $id_contrat);

if (isset($_POST['notifier_succes'])) {
    $contrat['prix']=$contrat['prix_final'];
    notifier_client($contrat['id'], $_SESSION['authenticated_drh'],"succes", $contrat['libelle']);
    mettre_a_jour_etat_contrat($contrat['id'], "Accepté");
    header("location:/contrats_en_cours_de_traitement");
    exit();

}
if (isset($_POST['notifier_echec'])) {
    $contrat['prix']=$contrat['prix_final'];
    notifier_client($contrat['id'], $_SESSION['authenticated_drh'],"echec", $contrat['libelle']);
    mettre_a_jour_etat_contrat($contrat['id'], "Refusé");
    header("location:/contrats_en_cours_de_traitement");
    exit();
}

$etat_contrat = $contrat['etat_contrat'];

?>
<?php
$title = 'Traitement Contrat';
include(__DIR__ . '/../_header.php'); ?>
<?php
$lien_retour = '/contrats_en_cours_de_traitement';
include(__DIR__ . '/../entete.php'); ?>
<br>
<div class="container">
    <h1>Traitement du Contrat</h1>
    <h2>Détails du Contrat</h2>
    <p>ID : <?= $contrat['id']; ?></p>
    <p>Libellé : <?= $contrat['libelle']; ?></p>
    <p>Date de Soumission : <?= $contrat['date_soumission']; ?></p
    <p>Prix(dinars) : <?= $contrat['prix']; ?></p>
    <p>Prix Final(dinars) : <?= $contrat['prix_final']; ?></p>
</div>
<div class="container">
    <?php
    afficher_prestations_contrat($id_contrat,"/traitement_prestation","Traiter Prestation");
    ?>
</div>
<div class="container">
    <?php
    include 'prix_du_contrat.php';
    ?>
</div>


<div class="container">
    <div class="text-center"> 
        <button id="boutonConfirmer" class="btn btn-primary">Confirmer les données du contrat</button>
    </div>
</div>
<br>
<div class="container" id="conteneurFormulaires" style="display: none;">
    <div class="text-center">
        <form method="post">
            <input type="hidden" name="id_contrat" value="<?php echo $contrat['id']; ?>">
            <?php
            $prestations_sans_employe = prestations_sans_employe_contrat($contrat['id']);
            if (empty($prestations_sans_employe)) {
                echo '<button type="submit" class="btn btn-success" name="notifier_succes">Notifier Client de Succès</button>';
            }
            ?>
            <button type="submit" class="btn btn-danger" name="notifier_echec">Notifier Client d'Échec</button>
        </form>
    </div>
</div>


<script>
    document.getElementById("boutonConfirmer").onclick = function () {
        var conteneurFormulaires = document.getElementById("conteneurFormulaires");
        conteneurFormulaires.style.display = "block";
    };
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
