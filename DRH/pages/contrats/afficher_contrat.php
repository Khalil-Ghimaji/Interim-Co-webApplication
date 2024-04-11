<?php
function afficher_contrats($statut,$action,$value) {
    session_start();
    $contrats = get_contrats($statut);
    if ($statut === 'En cours de traitement') $titre = 'En cours de traitement';
    else $titre = ucfirst($statut) . 's';
    ?>
    <?php
    $title='Contrats '.$titre;
    include(__DIR__.'/../_header.php');?>
    <?php
    $lien_retour='/home';
    include(__DIR__.'/../entete.php');
    ?>
    <?php
    if (!$contrats) {
    include 'aucun_contrat_existant.php';
    exit();
    }
    ?>

        <br>
    <div class="container">
        <h1>Contrats <?php echo $titre ?> </h1>
    </div>
    <br>
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Libellé</th>
                <th>Date de soumission</th>
                <th>Date de réponse</th>
                <th>Prix(dinars)</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($contrats as $contrat): ?>
                <tr>
                    <td><?php echo $contrat['id']; ?></td>
                    <td><?php echo $contrat['libelle']; ?></td>
                    <td><?php echo $contrat['date_soumission']; ?></td>
                    <td><?php echo $contrat['date_reponse']; ?></td>
                    <td><?php echo $contrat['prix']; ?></td>
                    <td>
                        <form action=<?=$action?> method="post">
                            <input type="hidden" name="id_contrat" value="<?php echo $contrat['id']; ?>">
                            <input type="submit" value=<?=$value?> class="btn btn-primary">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php } ?>
