<?php
require_once 'header.php';

$conn=ConnexionBD::openConnexion();

if(isset($_POST['update_id']) && isset($_POST['new_prix_estime'])) {
    $update_id = $_POST['update_id'];
    $new_prix_estime = $_POST['new_prix_estime'];
    $query = "UPDATE competences SET prix_estime = :prix_estime WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':prix_estime', $new_prix_estime);
    $stmt->bindParam(':id', $update_id);
    $stmt->execute();
}

$filter_competence = isset($_POST['filter_competence']) ? $_POST['filter_competence'] : '';
$filter_niveau = isset($_POST['filter_niveau']) ? $_POST['filter_niveau'] : '';
$filter_prix = isset($_POST['filter_prix']) ? $_POST['filter_prix'] : '';

$whereClause = '';

if (!empty($filter_competence)) {
    $whereClause .= "competence LIKE '%$filter_competence%' AND ";
}
if (!empty($filter_niveau)) {
    $whereClause .= "niveau_competence = '$filter_niveau' AND ";
}
if (!empty($filter_prix)) {
    $whereClause .= "prix_estime = '$filter_prix' AND ";
}

if (!empty($whereClause)) {
    $whereClause = 'WHERE ' . rtrim($whereClause, ' AND ');
}

$query = "SELECT * FROM competences $whereClause order by id";
$table = $conn->query($query);
?>

<div class="container mt-5">
    <?=alertMessage();?>
    <h2 class="text-center">Gestions des Competences</h2>
    
    <form action="" method="post">
        <div class="form-group">
                <label>Compétence:</label>
                <input type="text" class="form-control" name="filter_competence">
            </div>
            <div class="form-group">
                <label>Niveau Compétence:</label>
                <select class="form-control" name="filter_niveau" oninput="checkCompetence()" >
                        <option value=""></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                </select>
            </div>
            <div class="form-group">
                <label>Prix estime:</label>
                <input type="number" class="form-control" name="filter_prix">
            </div>
            <button type="submit" class="btn btn-primary">Appliquer filtre</button>
    </form>
    <br><br>
</div>
<div class="container mt-5">
    <div class="d-flex justify-content-between">
        <h4>Liste des Competences</h4>
        <a href="/addCompetences" class="btn btn-success">Ajouter</a>
    </div>
    <table class="table mt-3">
        <caption>Competences</caption>
        <thead>
            <tr>
                <th>ID</th>
                <th>Competence</th>
                <th>Niveau de Competence</th>
                <th>Prix Estime</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while($row = $table->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>".$row["id"]."</td>
                        <td>".$row["competence"]."</td>
                        <td>".$row["niveau_competence"]."</td>
                        <td>
                            <form method='post'>
                                <input type='hidden' name='update_id' value='".$row["id"]."'>
                                <input type='number' step='0.1' name='new_prix_estime' value='".$row["prix_estime"]."' class='form-control'>
                                <button type='submit' class='btn btn-primary'>Modifier</button>
                            </form>
                        </td>
                      </tr>";
            }

            $conn=null;
            ConnexionBD::close();
            ?>
        </tbody>
    </table>
</div>

<?php
    require_once 'footer.php';
?>