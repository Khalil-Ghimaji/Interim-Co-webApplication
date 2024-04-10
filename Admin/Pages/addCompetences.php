<?php 
    require_once 'header.php';
?>
<div class="container mt-5">
        <form action="" method="post">
            <div class="form-group">
                <label>Compétence:</label>
                <input type="text" class="form-control" name="competence_name" required>
            </div>
            <div class="form-group">
                <label>Niveau Compétence:</label>
                <input type="number" class="form-control" name="niveau_competence" min="1" max="3" required>
            </div>
            <div class="form-group">
                <label>Prix estime:</label>
                <input type="number" class="form-control" name="prix_estime" required>
            </div>
            <button type="submit" class="btn btn-primary" >Ajouter Compétence</button>
        </form>
</div>

<?php 
$conn=ConnexionBD::openConnexion();

if(isset($_POST['niveau_competence']) && isset($_POST['prix_estime']) && isset($_POST['competence_name'])) {
    $competence_name = $_POST['competence_name'];
    $niveau_competence = $_POST['niveau_competence'];
    $prix_estime = $_POST['prix_estime'];
    
    $query = "INSERT INTO competences (competence, niveau_competence, prix_estime) VALUES (:competence_name, :niveau_competence, :prix_estime)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':competence_name', $competence_name);
    $stmt->bindParam(':niveau_competence', $niveau_competence);
    $stmt->bindParam(':prix_estime', $prix_estime);
    try {
        $stmt->execute();
        redirect('/competences','Compétence ajoutée avec succès','success');
    } catch(PDOException $e) {
        echo "Failed to execute: try looking in the selection menu";
    }
}

$conn=null;
ConnexionBD::close();

require_once 'footer.php'
?>