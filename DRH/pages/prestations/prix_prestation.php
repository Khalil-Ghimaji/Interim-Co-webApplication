<?php
// Fonction pour gérer le calcul et l'affectation du prix pour un prestation
//require_once '../../database/BD.php';
//require_once '../../database/ConnexionBD.php';

$alerte = "";
$nouveau_prix = null;
$prestation = get_data('prestations', $id_prestation);
if ($_SERVER["REQUEST_METHOD"] === "POST" && (isset($_POST["action"]))) {
    if ($_POST["action"] === "Calculer Prix" && ((!isset($_POST["taux_tva"]) || $_POST["taux_tva"] === '') || (!isset($_POST["taux_remise"]) || $_POST["taux_remise"] === '') )) {
        $alerte = "Les champs ne doivent pas être vides.";
    } else {
        $taux_tva = $_POST["taux_tva"] ?? null;
        $taux_remise = $_POST["taux_remise"] ?? null;

        if ((!is_numeric($taux_tva) || !is_numeric($taux_remise) || $taux_tva < 0 || $taux_tva > 100 || $taux_remise < 0 || $taux_remise > 100) && ($_POST["action"] === "Calculer Prix")) {
            $alerte = "Les taux de TVA et de remise doivent être des nombres entre 0 et 100.";
        } else {
            if ($_POST["action"] === "Calculer Prix") {
                if ($taux_tva === null || $taux_remise === null) {
                    $alerte = "Veuillez remplir tous les champs pour calculer le prix.";
                } else {
                    $nouveau_prix=($prestation['prix']*(1-$taux_remise/100))*(1+$taux_tva/100);
                    mettre_a_jour_prix($prestation['id'], $nouveau_prix, 'prestations');
                    echo '<script>';
                    echo 'setTimeout(function(){ window.location.href = "' . $_SERVER['REQUEST_URI'] . '"; }, 0);'; // Redirection après 1 seconde (1000 ms)
                    echo '</script>';

                }
            }
        }
    }
}
?>
<?php if (($alerte !== "")): ?>
    <div class="alert alert-danger" role="alert">
        <?= $alerte; ?>
    </div>
<?php endif; ?>

<form method="post">
    <h2>Gérer le Prix de la prestation</h2>
    <label for="taux_tva">Taux de TVA :</label>
    <input type="text" name="taux_tva" id="taux_tva">
    <label for="taux_remise">Taux de Remise :</label>
    <input type="text" name="taux_remise" id="taux_remise">
    <button type="submit" class="btn btn-primary" name="action" value="Calculer Prix">Changer Prix</button>
    <?php if ($nouveau_prix !== null): ?>
        <h3>Nouveau Prix : <?= $nouveau_prix; ?></h3>
    <?php endif; ?>
</form>

