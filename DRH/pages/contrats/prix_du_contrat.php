
<?php

    $alerte = "";
    $nouveau_prix=null;
    $contrat=get_data('contrats',$id_contrat);

    if ($_SERVER["REQUEST_METHOD"] === "POST" && (isset($_POST["action"])))  {
        if ($_POST["action"] === "Calculer Prix" && ((!isset($_POST["taux_tva"]) || $_POST["taux_tva"] === '') || (!isset($_POST["taux_remise"]) || $_POST["taux_remise"] === '') || (!isset($_POST["frais_supplementaires"]) || $_POST["frais_supplementaires"] === ''))) {
            $alerte = "Les champs ne doivent pas être vides.";
        } else {
            $taux_tva = $_POST["taux_tva"] ?? null;
            $taux_remise = $_POST["taux_remise"] ?? null;
            $frais_supplementaires = $_POST["frais_supplementaires"] ?? null;

            if ((!is_numeric($taux_tva) || !is_numeric($taux_remise) || $taux_tva < 0 || $taux_tva > 100 || $taux_remise < 0 || $taux_remise > 100 || $frais_supplementaires < 0)&&($_POST["action"] === "Calculer Prix")) {
                $alerte = "Les taux de TVA et de remise doivent être des nombres entre 0 et 100 et les frais supplémentaires ne peuvent pas être négatifs.";
            } else {
                // Calculer le nouveau prix si l'action est "Calculer Prix"
                if ($_POST["action"] === "Calculer Prix") {
                    if ($taux_tva === null || $taux_remise === null || $frais_supplementaires === null) {
                        $alerte = "Veuillez remplir tous les champs pour calculer le prix.";
                    } else {

                        $nouveau_prix = (($contrat['prix']+$frais_supplementaires)*(1-$taux_remise/100))*(1+$taux_tva/100);
                        mettre_a_jour_prix($contrat['id'],$nouveau_prix,'contrats');
                        echo '<script>';
                        echo 'setTimeout(function(){ window.location.href = "' . $_SERVER['REQUEST_URI'] . '"; }, 0);'; // Redirection après 1 seconde (1000 ms)
                        echo '</script>';
                    }
                }
            }
        }
    }


    ?>
    <!-- Afficher l'alerte si elle est définie -->
    <?php if (($alerte !== "")): ?>
        <div class="alert alert-danger" role="alert">
            <?= $alerte; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <h2>Gérer le Prix du Contrat</h2>
        <label for="taux_tva">Taux de TVA :</label>
        <input type="text" name="taux_tva" id="taux_tva">
        <label for="taux_remise">Taux de Remise :</label>
        <input type="text" name="taux_remise" id="taux_remise">
        <label for="frais_supplementaires">Frais Supplémentaires :</label>
        <input type="text" name="frais_supplementaires" id="frais_supplementaires">
        <button type="submit" class="btn btn-primary" name="action" value="Calculer Prix">Changer Prix</button>
    </form>



