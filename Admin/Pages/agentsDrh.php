<?php
    include 'header.php';
?>

<?php
        $conn=ConnexionBD::openConnexion();


        $filter_nom = isset($_POST['filter_nom']) ? $_POST['filter_nom'] : '';
        $filter_prenom = isset($_POST['filter_prenom']) ? $_POST['filter_prenom'] : '';
        $filter_username = $_POST['filter_username'] ?? '';

        $filter_nom=strtolower($filter_nom);
        $filter_prenom=strtolower($filter_prenom);
        $filter_username=strtolower($filter_username);

        $whereClause = '';

        if (!empty($filter_nom)) {
            $whereClause .= "LOWER(nom) LIKE '%$filter_nom%' AND ";
        }
        if (!empty($filter_prenom)) {
            $whereClause .= "LOWER(prenom) LIKE = '$filter_prenom' AND ";
        }
        if (!empty($filter_username)) {
            $whereClause .= "LOWER(nom_utilisateur) = '$filter_username' AND ";
        }



        if (!empty($whereClause)) {
            $whereClause = 'WHERE ' . rtrim($whereClause, ' AND ');
        }

        $query = "SELECT * from agentsdrh $whereClause";
        $table = $conn->query($query);
?>

<div class="container mt-5">
        <?=alertMessage();?>
        <h2 class="text-center">Gestion des Agents DRH</h2>
        
        <form class="mb-3" action="" method="post">
            <div class="form-group">
                <label>Nom d'utilisateur:</label>
                <input type="text" class="form-control" name="filter_username" value="<?php echo htmlspecialchars($filter_nom); ?>">
            </div>
            <div class="form-group">
                <label>Nom:</label>
                <input type="text" class="form-control" name="filter_nom" value="<?php echo htmlspecialchars($filter_nom); ?>">
            </div>
            <div class="form-group">
                <label>Prenom:</label>
                <input type="text" class="form-control" name="filter_penom" value="<?php echo htmlspecialchars($filter_nom); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Appliquer le filtre</button>
        </form>
</div>
<div class="container mt-5">
    <div class="d-flex justify-content-between">
        <h4>Liste des Agents DRH</h4>
        <a href="/createAccount" class="btn btn-success">Ajouter</a>
    </div>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom d'utilisateur</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Numero de téléphone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $pdo = ConnexionBD::openConnexion();
                foreach($table as $agent){
            ?>
            <tr>
                <td><?=$agent['id'];?></td>
                <td><?=$agent['nom_utilisateur'];?></td>
                <td><?=$agent['nom'];?></td>
                <td><?=$agent['prenom'];?></td>
                <td><?=$agent['email'];?></td>
                <td><?=$agent['numero_telephone'];?></td>
                <td>
                    <a href="/deleteAccount?id=<?=$agent['id'];?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ces données ?')">Supprimer</a>
                </td>
            </tr>
            <?php
                }


                $pdo=null;
                ConnexionBD::close();
            ?>
        </tbody>
    </table>
</div>
<?php require_once 'footer.php'?>