<?php
    include 'header.php';
?>
<?php
    $pdo = ConnexionBD::openConnexion();

    $filter_id = $_POST['filter_id'] ?? '';
    $filter_nom_utilisateur = $_POST['filter_nom_utilisateur'] ?? '';
    $filter_nom = $_POST['filter_nom'] ?? '';
    $filter_locale = $_POST['filter_locale'] ?? '';

    $filter_nom=strtolower($filter_nom);
    $filter_nom_utilisateur=strtolower($filter_nom_utilisateur);

    $whereClause = '';
    if (!empty($filter_nom)) {
        $whereClause .= "LOWER(nom) LIKE '%$filter_nom%' AND ";
    }
    if (!empty($filter_locale)) {
        $whereClause .= "locale = '$filter_locale' AND ";
    }
    if (!empty($filter_nom_utilisateur)) {
        $whereClause .= "LOWER(nom_utilisateur) LIKE '%$filter_nom_utilisateur%' AND ";
    }
    


    if (!empty($whereClause)) {
        $whereClause = 'WHERE ' . rtrim($whereClause, ' AND ');
    }
    $query = "SELECT * FROM clients $whereClause";
    $table = $pdo->query($query);

?>
<body>
<div class="container mt-5">
        <?=alertMessage();?>
        <h2 class="text-center">Gestion des Clients </h2>
        <form class="mb-3" action="" method="post">
            <div class="form-group">
                <label>Nom d'utilisateur:</label>
                <input type="text" class="form-control" name="filter_nom_utilisateur" value="<?php echo htmlspecialchars($filter_nom_utilisateur); ?>">
            </div>
            <div class="form-group">
                <label>Nom:</label>
                <input type="text" class="form-control" name="filter_nom" value="<?php echo htmlspecialchars($filter_nom); ?>">
            </div>
            <div class="form-group">
                <label>Locale:</label>
                <input type="text" class="form-control" name="filter_locale" value="<?php echo htmlspecialchars($filter_locale); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Appliquer le filtre</button>
        </form>
</div>
<div class="container mt-5">
    <h4>Liste des Clients</h4>
    
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom d'utilisateur</th>
                <th>Nom</th>
                <th>Locale</th>
                <th>Email</th>
                <th>Numero de téléphone</th>
            </tr>
        </thead>
        <tbody>
            <?php                
                foreach($table as $user){
            ?>
            <tr>
                <td><?=$user['id'];?></td>
                <td><?=$user['nom_utilisateur'];?></td>
                <td><?=$user['nom'];?></td>
                <td><?=$user['locale'];?></td>
                <td><?=$user['email'];?></td>
                <td><?=$user['numero_telephone'];?></td>
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