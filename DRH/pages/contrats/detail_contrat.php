<?php
session_start();
include 'prestations_du_contrat.php';
if (isset($_POST['id_contrat'])) {
    $id_contrat = $_POST['id_contrat'];
    $_SESSION['id_contrat_selectionne'] = $id_contrat;
} else {
    $id_contrat = $_SESSION['id_contrat_selectionne'];
}
$contrat = get_data("contrats", $id_contrat);
$etat_contrat = $contrat['etat_contrat']; // Assurez-vous de remplacer $contrat['etat'] par la variable appropriée contenant l'état du contrat
$url_redirection = '';
switch ($etat_contrat) {
    case 'Refusé':
        $url_redirection = '/contrats_refuses';
        break;
    case 'Accepté':
        $url_redirection = '/contrats_acceptes';
        break;
    case 'Finalisé':
        $url_redirection = '/contrats_finalises';
        break;
}

?>
<?php
$title = 'Détail Contrat';
include(__DIR__ . '/../_header.php'); ?>
<?php
$lien_retour = $url_redirection;
include(__DIR__ . '/../entete.php'); ?>
<br>
<div class="container">
    <h2>Détails du Contrat</h2>
    <p>ID : <?= $contrat['id']; ?></p>
    <p>Libellé : <?= $contrat['libelle']; ?></p>
    <p>Date de Soumission : <?= $contrat['date_soumission']; ?></p
    <p>Date de Reponse : <?= $contrat['date_reponse']; ?></p>
    <p>Prix(dinars) : <?= $contrat['prix']; ?></p>
</div>
<div class="container">
    <?php
    afficher_prestations_contrat($id_contrat,'/detail_prestation','Detail Prestation');
    ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>