<?php
require_once 'header.php';
$conn = ConnexionBD::openConnexion();

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $name = $_GET['libelle'];

    $query = "SELECT * FROM prestations WHERE id_contrat = :contract_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':contract_id', $id);
    $stmt->execute();
    $prestations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("Location: /contrats");
    exit();
}

if(isset($_POST['update_prix'])) {
    $prestation_id = $_POST['prestation_id'];
    $new_prix = $_POST['new_prix'];

    $update_query = "UPDATE prestations SET prix = :new_prix WHERE id = :prestation_id";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bindParam(':new_prix', $new_prix);
    $update_stmt->bindParam(':prestation_id', $prestation_id);
    $update_stmt->execute();

    $conn=null;
    ConnexionBD::close();
}
?>

<div class="container">
    <h2 class="text-center">Prestations pour contrat : <?php echo $name; ?></h2>

    <table class="table">
        <caption>Prestations</caption>
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Date Debut</th>
                <th>Date Fin</th>
                <th>Durée</th>
                <th>Prix</th>
                
                
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($prestations as $prestation) {
                echo "<tr>
                        <td>".$prestation['id']."</td>
                        <td>".$prestation['description']."</td>
                        <td>".$prestation['date_debut']."</td>
                        <td>".$prestation['date_fin']."</td>
                        <td>".$prestation['duree']."</td>
                        <td>".$prestation['prix']."</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php require_once 'footer.php' ?>