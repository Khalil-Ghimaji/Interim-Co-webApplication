<?php

    require_once 'header.php';
    $conn=ConnexionBD::openConnexion();
    $query = "SELECT * FROM competences";
    $competences = $conn->query($query);
    $competences=$competences->fetchAll(PDO::FETCH_ASSOC);

?>

<script>
    let competences_array = <?= json_encode($competences); ?>;
    let competences= new Map();
    competences_array.forEach((element)=>{
        let competence= element['competence'];
        if (!competences.has(competence)){
            competences.set(competence,[]);
        }
        competences.get(competence).push(element['niveau_competence']);
    });
</script>


<div class="container mt-5">
        <?=alertMessage();?>
        <h2>Ajouter Employé</h2>
        <form method="POST" action="/addEmployee">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control"  name='nom' required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" class="form-control"  name="prenom" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control"  name="email" required>
            </div>
            <div class="form-group">
                <label for="tel">Numéro de téléphone:</label>
                <input type="text" class="form-control"  name="tel" required>
            </div>
            <div id="competences">
                
                <div class="form-row competence-row">
                    <div class="form-group col-md">
                        <label for="competence">Competence:</label>
                        <select class="form-control competences" name="competence[]" onchange="checkOption(this)">
                        <?php
                
                        $query = "SELECT distinct(competence) FROM competences";
                        $competencesList = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
                        foreach($competencesList as $row ) {
                            echo "<option value='".$row["competence"]."'>".$row["competence"]."</option>";
                        }
                        ?>
                        <option value="">Autre</option>
                        </select>
                        <input type="text" name="autreCompetence[]" style="display: none;">
                    </div>
                    <div class="form-group col-md">
                        <label for="niveau">Niveau de Competence:</label>
                        <select class="form-control" name="niveau[]" required onchange="enablePrice(this)">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                    <div class="form-group col-md" hidden>
                        <label for="prix">Prix:</label>
                        <input type="number" min=1  step=0.1 class="form-control"  name="prix[]" >
                    </div>
                    
                    
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="addCompetence">Autre Competence</button>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add competence row
            $('#addCompetence').click(function() {
                let competenceRow = `
                    <div class="form-row competence-row">
                        <div class="form-group col-md">
                            <label for="competence">Competence:</label>
                            <select class="form-control competences" name="competence[]" onchange="checkOption(this)" >
                        <?php
                        
                        foreach( $competencesList as $row ) {
                            echo "<option value='".$row["competence"]."'>".$row["competence"]."</option>";
                        }
                        ?>
                        <option value="">Autre</option>
                        </select>
                        <input type="text" name="autreCompetence[]" style="display: none;">

                        </div>
                        <div class="form-group col-md">
                            <label for="niveau">Niveau de Competence:</label>
                            <select class="form-control" name="niveau[]" required onchange="enablePrice(this)">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <div class="form-group col-md" hidden>
                            <label for="prix">Prix:</label>
                            <input type="number" class="form-control"  name="prix[]"  >
                        </div>
                        <div class="form-group col-md-1">
                            <button type="button" class="close delete-competence" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    </div>
                `;
                $('#competences').append(competenceRow);
            });

            $('#competences').on('click', '.delete-competence', function() {
                $(this).closest('.competence-row').remove();
            });
        });

        function checkOption(select) {
            let newCompetenceInput = select.nextElementSibling;
            console.log(newCompetenceInput.nextElementSibling);

            select.parentNode.nextElementSibling.children[1].selectedIndex=-1;
            
            if (select.value === "") {
                newCompetenceInput.style.display = "inline";
                newCompetenceInput.required=true;

            } else {
                newCompetenceInput.value="";
                newCompetenceInput.style.display = "none";
                newCompetenceInput.required=false;
            }
        }

        function enablePrice(select){
            let prixInput=select.parentNode.nextElementSibling;
            let competenceValue=select.parentNode.previousElementSibling.children[1].value;
            if(competences.has(competenceValue)&&competences.get(competenceValue).includes(select.value)){
                prixInput.hidden=true;
                prixInput.children[1].required=false;
            }
            else{
                prixInput.hidden=false;
                prixInput.children[1].required=true;
            }

        }
</script>

<?php require_once 'footer.php';?>