<?php

$employes_affectes = get_employes_affectes($id_prestation);
$niveau_competence_correspondance = ['Debutant','Intermédiaire','Expert'];

?>


    <h2 class="mt-5">Employés affectés a la prestation</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Date d'inscription</th>
            <th>Adresse</th>
            <th>Numéro de téléphone</th>
            <th>Compétences</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($employes_affectes as $employe) : ?>
            <tr>
                <td><?php echo $employe['nom']; ?></td>
                <td><?php echo $employe['prenom']; ?></td>
                <td><a href="mailto:<?php echo $employe['email']; ?>"><?php echo $employe['email']; ?></a></td>
                <td><?php echo $employe['date_inscription']; ?></td>
                <td><?php echo $employe['adresse']; ?></td>
                <td><?php echo $employe['numero_telephone']; ?></td>
                <td>
                    <select name="competence_<?php echo $employe['id']; ?>" class="form-select">
                        <?php
                        $competences = get_competences_employe($employe['id']);

                        foreach ($competences as $competence) {
                            echo '<option value="' . $competence['competence'] . '">' . $competence['competence'] . ' (' . $niveau_competence_correspondance[$competence['niveau_competence']-1] . ')</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
