<?php
    require_once 'header.php';
?>
<?php
        $conn=ConnexionBD::openConnexion();

        $filter_nom = isset($_POST['filter_nom']) ? $_POST['filter_nom'] : '';
        $filter_prenom = isset($_POST['filter_prenom']) ? $_POST['filter_prenom'] : '';
        $filter_email = isset($_POST['filter_email']) ? $_POST['filter_email'] : '';
        $filter_competence = $_POST['filter_competence'] ?? '';
        $filter_niveau_competence = $_POST['filter_niveau_competence'] ?? '';

        $whereClause = '';

        if (!empty($filter_nom)) {
            $whereClause .= "nom LIKE '%$filter_nom%' AND ";
        }
        if (!empty($filter_prenom) && !empty($filter_competence)) {
            $whereClause .= "prenom = '$filter_prenom' AND ";
        }
        if (!empty($filter_email)) {
            $whereClause .= "email = '$filter_email' AND ";
        }
        if (!empty($filter_competence)) {
            $whereClause .= "competences.competence = '$filter_competence' AND ";
        }
        if (!empty($filter_niveau_competence) && !empty($filter_competence)) {
            $whereClause .= "competences.niveau_competence = '$filter_niveau_competence' AND ";
        }
        



        if (!empty($whereClause)) {
            $whereClause = 'WHERE ' . rtrim($whereClause, ' AND ');
        }

        $query = "SELECT employes.*, competences.competence, competences.niveau_competence
                FROM employes
                LEFT JOIN competence_employe ON employes.id = competence_employe.id_employe
                LEFT JOIN competences ON competence_employe.id_competence = competences.id
                $whereClause order by employes.id";
        $table = $conn->query($query);
        
?>
<div class="container mt-5">
        <?=alertMessage();?>
        <h2 class="text-center">Gestion des Employés</h2>
        
        <form class="mb-3" action="" method="post">
            <div class="form-group">
                <label>Nom:</label>
                <input type="text" class="form-control" name="filter_nom" value="<?php echo htmlspecialchars($filter_nom); ?>">
            </div>
            <div class="form-group">
                <label>Prenom:</label>
                <input type="text" class="form-control" name="filter_prenom" value="<?php echo htmlspecialchars($filter_prenom); ?>">
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="text" class="form-control" name="filter_email" value="<?php echo htmlspecialchars($filter_email); ?>">
            </div>
            <div class="form-group">
                <label>Competence:</label>
                <input type="text" class="form-control" name="filter_competence"  value="<?php echo htmlspecialchars($filter_competence); ?>">
            </div>
            <div class="form-group">
                <label>Niveau Competence:</label>
                <select class="form-control" name="filter_niveau_competence" oninput="checkCompetence()" >
                        <option value=""></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Appliquer le filtre</button>
        </form>
</div>
<div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h4>Liste des Employés</h4>
            <a href="/addEmployeeForm" class="btn btn-success">Ajouter</a>
        </div>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Email</th>
                    <th>Numéro de téléphone</th>
                    <th>Compétences</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $employee_competences=array();
                $unique=array();
                foreach($table as $employee){
                    if(!in_array($employee['id'],$employee_competences)){
                        $employee_competences[$employee['id']]=[];
                        $unique[]=$employee;
                    }
                    $employee_competences[$employee['id']][]=$employee['competence'].'('.$employee['niveau_competence'].')';
                }
                foreach ($unique as $employee){
                ?>
                <tr>
                    <td><?=$employee['id'];?></td>
                    <td><?=$employee['nom'];?></td>
                    <td><?=$employee['prenom'];?></td>
                    <td><?=$employee['email'];?></td>
                    <td><?=$employee['numero_telephone'];?></td>
                    <td>
                        <select>
                            <?php
                            foreach ($employee_competences[$employee['id']] as $competence) {
                                echo '<option value="'.$competence.'">'.$competence.'</option>';
                            }?>
                        </select>
                    <td>
                        <a href="/deleteEmployee?id=<?=$employee['id'];?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ces données ?')">Supprimer</a>
                    </td>
                </tr>
            <?php
                }

                $conn=null;
                ConnexionBD::close();
                ?>
                
            </tbody>
        </table>
        <script>
            function checkOptions() {
                let select = document.getElementById("competence-select");
                let form = document.getElementById("new-competence-form");
                if (select.value === '0') {
                    form.style.display = "block";
                } else {
                    form.style.display = "none";
                }
            }
            function checkCompetence() {
                var competence = document.getElementsByName('filter_competence')[0];
                var niveauCompetence = document.getElementsByName('filter_niveau_competence')[0];

                if (niveauCompetence.value !== '') {
                    competence.required = true;
                } else {
                    competence.required = false;
                }
            }
        </script>

        
        

    
</div>

<?php 
    require_once 'footer.php';
?>
    




