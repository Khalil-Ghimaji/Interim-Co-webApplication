<?php
$prestation = get_data('prestations', $id_prestation);
$duree = $prestation['duree'];
$date_deb = $prestation['date_debut'];
$date_fin = $prestation['date_fin'];

$date_min = date('Y-m-d', strtotime($prestation['date_debut'] . ' + ' . ($duree - 1) . ' days'));
$date_max = date('Y-m-d', strtotime($prestation['date_fin'] . ' - ' . ($duree - 1) . ' days'));
$formErrors = '';
$successMessage = '';

if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['date_debut'],$_POST['date_fin'])){
    // Récupération des données soumises
    $dateDebut = $_POST['date_debut'];
    $dateFin = $_POST['date_fin'];
    $diff = strtotime($dateFin) - strtotime($dateDebut);
    $duree_diff = round(($diff) / (60 * 60 * 24))+1;
    if ($duree_diff < $duree) {
        $formErrors = "La durée entre les dates sélectionnées est inférieure à la durée minimale de la prestation.";
    }
    if (empty($formErrors)) {
        inserer_date_prestation($prestation['id'], $dateDebut, $dateFin);
        $successMessage = "Les dates de travail ont été mises à jour avec succès.";
        echo '<script>';
        echo 'setTimeout(function(){ window.location.href = "' . $_SERVER['REQUEST_URI'] . '"; }, 0);'; // Redirection après 1 seconde (1000 ms)
        echo '</script>';
    }
}
?>

<body>
<form  method="post">
    <h2>Gérer la date de la  prestation</h2>
    <label for="date_debut">Date de début :</label>
    <input name='date_debut' type="date" min="<?=$date_deb?>" max="<?=$date_max?>" value=""<?=$date_deb?>" required>
    <label for="date_fin">Date de fin :</label>
    <input name='date_fin' type="date" min="<?=$date_min?>" max="<?=$date_fin?>" value="<?=$date_fin?>" required>
    <!-- Bouton de soumission du formulaire -->
    <button type="submit" class="btn btn-primary" value="valider">Valider</button>
    <?php if ($formErrors): ?>
        <div class="alert alert-danger" role="alert"><?= $formErrors ?></div>
    <?php endif; ?>
    <?php if ($successMessage): ?>
        <div class="alert alert-success" role="alert"><?= $successMessage ?></div>
    <?php endif; ?>
</form>
</body>
