<?php
session_start();
if (isset($_SESSION['id_prestation_selectionnee'])) {
    $id_prestation = $_SESSION['id_prestation_selectionnee'];
}
$employes_adequats = get_employes_adequats($id_prestation);
$employes_affectes = get_employes_affectes($id_prestation);
function genererLigneEmploye($employe, $action, $id_prestation) {
    $niveau_competence_correspondance = ['Debutant','Intermédiaire','Expert'];
    $action_text = ($action == 'ajouter') ? 'ajouter' : 'supprimer';
    ?>
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

        <td>
            <form action="/action" method="post">
                <input type="hidden" name="id_employe" value="<?php echo $employe['id']; ?>">
                <input type="hidden" name="id_prestation" value="<?php echo $id_prestation; ?>">
                <input type="hidden" name="action" value="<?php echo $action; ?>"> <!-- Add this hidden field -->
                <button type="submit" class="btn btn-<?php echo ($action == 'ajouter') ? 'success' : 'danger'; ?>"><?php echo ucfirst($action_text); ?></button>
            </form>
        </td>
    </tr>
    <?php
}

function afficherTableauEmployes($employes, $action, $id_prestation, $titre) {
    ?>
    <h2 class="mt-5"><?php echo $titre; ?></h2>
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
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($employes as $employe) : ?>
            <?php echo genererLigneEmploye($employe, $action, $id_prestation); ?>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}
?>
<?php
$title="Gestion des affectations d'employés";
include(__DIR__.'/../_header.php');?>
<body>
<?php //entete("traitement_prestation.php")?>
<?php
$lien_retour="/traitement_prestation";
include(__DIR__.'/../entete.php');?>
<div class="container mt-5">
    <h1>Gestion des affectations d'employés pour la prestation</h1>

    <?php afficherTableauEmployes($employes_affectes, 'supprimer', $id_prestation, 'Employés déjà affectés'); ?>

    <?php afficherTableauEmployes($employes_adequats, 'ajouter', $id_prestation, 'Employés adéquats'); ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
