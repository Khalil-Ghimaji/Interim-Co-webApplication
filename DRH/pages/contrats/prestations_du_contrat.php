<?php
function afficher_prestations_contrat($id_contrat, $action, $value) {

    $prestations = get_prestations($id_contrat);

    if (!$prestations) {
        ?>
        <br>
            <h2>Aucune prestation trouvée pour ce contrat.</h2>
        <?php
        exit();
    }
    ?>

    <h2>Prestations:</h2>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Date de Début</th>
            <th>Date de Fin</th>
            <th>Durée(jours)</th>
            <th>Prix(dinars)</th>
            <th>Description</th>
            <th>Compétence requise</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($prestations as $prestation): ?>
            <tr>
                <td><?php echo $prestation['id']; ?></td>
                <td><?php echo $prestation['date_debut']; ?></td>
                <td><?php echo $prestation['date_fin']; ?></td>
                <td><?php echo $prestation['duree']; ?></td>
                <td><?php echo $prestation['prix']; ?></td>
                <td><?php echo $prestation['description']; ?></td>
                <td><?php echo get_competence_prestation($prestation)['competence'] . '(' . get_competence_prestation($prestation)['niveau_competence'] . ')'; ?></td>
                <td>
                    <form action="<?php echo $action; ?>" method="post">
                        <input type="hidden" name="id_prestation" value="<?php echo $prestation['id']; ?>">
                        <input type="submit" value="<?php echo $value; ?>" class="btn btn-primary">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php } ?>
