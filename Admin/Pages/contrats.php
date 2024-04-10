<?php
    require_once 'header.php';
    
$conn=ConnexionBD::openConnexion();

if(isset($_POST['view_prestations'])) {
    $contract_id = $_POST['contract_id'];
    header("Location: /prestations?contract_id=$contract_id");
    exit();
}


$filter_client = isset($_POST['filter_client']) ? $_POST['filter_client'] : "";
$filter_date = isset($_POST['filter_date']) ? $_POST['filter_date'] : '';
$filter_libelle = isset($_POST['filter_libelle']) ? $_POST['filter_libelle'] : '';
$filter_etat_contrat = isset($_POST['filter_etat_contrat']) ? $_POST['filter_etat_contrat'] : '';


$filter_client=strtolower($filter_client);

$whereClause = "";

if (!empty($filter_client)) {
    $whereClause .= " LOWER(clients.nom) LIKE '%$filter_client%' AND ";
}

if (!empty($filter_date)) {
    $whereClause .= " date_soumission = '$filter_date' AND ";
}
if (!empty($filter_libelle)) {
    $whereClause .= " libelle LIKE '%$filter_libelle%' AND ";
}
if (!empty($filter_etat_contrat)) {
    $whereClause .= " etat_contrat = '$filter_etat_contrat' AND ";
}

if (!empty($whereClause)) {
    $whereClause = 'WHERE '.rtrim($whereClause, ' AND ');
}

$query = "SELECT contrats.*, clients.nom 
            FROM contrats 
            LEFT JOIN clients ON contrats.id_client = clients.id 
            $whereClause";
$table = $conn->query($query);
?>
<div class="container mt-5">
        
        <h2 class="text-center">Gestion des Contrats</h2>
        <form class="mb-3" action="" method="post">
            <div class="form-group">
                <label>Client:</label>
                <input type="text" class="form-control" name="filter_client" value="<?php echo htmlspecialchars($filter_client); ?>">
            </div>
            <div class="form-group">
                <label>Libellé:</label>
                <input type="text" class="form-control" name="filter_libelle" value="<?php echo htmlspecialchars($filter_libelle); ?>">
            </div>
            <div class="form-group">
                <label>Date soumission:</label>
                <input type="date" class="form-control" name="filter_date" value="<?php echo htmlspecialchars($filter_date); ?>">
            </div>
            <div class="form-group">
                <label>Etat Contrat:</label>
                <select class="form-control" name="filter_etat_contrat">
                    <option value="">Tous</option>
                    <option value="En cours de traitement" <?php if ($filter_etat_contrat === 'En cours de traitement') echo 'selected'; ?>>En cours de traitement</option>
                    <option value="Accepté" <?php if ($filter_etat_contrat === 'Accepté') echo 'selected'; ?>>Accepté</option>
                    <option value="Refusé" <?php if ($filter_etat_contrat === 'Refusé') echo 'selected'; ?>>Refusé</option>
                    <option value="finalisé" <?php if ($filter_etat_contrat === 'finalisé') echo 'selected'; ?>>Finalisé</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Appliquer le filtre</button>
        </form>
<div>
<div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h4>Liste des Contrats</h4>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client ID</th>
                    <th>Nom du Client</th>
                    <th>Libellé</th>
                    <th>Date Soumission</th>
                    <th>Date Réponse</th>
                    <th>Etat Contrat</th>
                    <th>Prix</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row = $table->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>".$row["id"]."</td>
                            <td>".$row["id_client"]."</td>
                            <td>".$row["nom"]."</td>
                            <td>".$row["libelle"]."</td>
                            <td>".$row["date_soumission"]."</td>
                            <td>".$row["date_reponse"]."</td>
                            <td>".$row["etat_contrat"]."</td>
                            <td>".$row["prix"]."</td>
                            
                                <td><a href='/prestations?id=".$row["id"]."&libelle=".$row["libelle"]."'><button>View Prestations</button></a></td>
                            
                        </tr>";
                }
                $conn=null;
                ConnexionBD::close();
                ?>
            </tbody>
            </div>
        </table>
</div>

<?php
    require_once 'footer.php';
?>