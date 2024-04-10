<?php
include (__DIR__ . '/prestation_form.php');
?>
<script>let competences_array = <?= json_encode(load_competences()); ?>;
let competences= new Map();
competences_array.forEach((element)=>{
    let competence= element['competence'];
    if (!competences.has(competence)){
        competences.set(competence,[]);
    }
    competences.get(competence).push(element['niveau_competence']);
});
</script>
<form class="col-md-8 mx-auto border p-4" method="post" id="contrat">
    <div>
        <label for="libelle">Libelle:</label>
        <input type="hidden" name="nb_prestation" value=0 id="nb_prestation">
        <input type="text" name="libelle" id="libelle" required>
    </div>
    <div id = 'prestations'></div>
    <div>
        <button type="button" id ='ajout-prestation'>Ajouter prestation</button>
    </div>
    <div>
        <button id='enregistrement' type="submit">Enregistrer Contrat</button>
    </div>
</form>

<script>
    let ajout = document.getElementById('ajout-prestation');
    let nb_prestation = 0;
    let nb_prestations_supprimees=0;
    let libelle = document.getElementById('libelle');
    libelle.value = libelle_valeur || '';
    libelle.disabled = disable_fields;
    for(let i=1;i<=prestations_content.length;i++){
        generer_prestation(true);
    }
    if (prestations_content.length===0){
        generer_prestation(false);
    }
    ajout.addEventListener('click', (event) => {
        generer_prestation(false);
    });

</script>