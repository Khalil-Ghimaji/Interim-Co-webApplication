<script>function get_prestation(i,prestation_content) {
    let prestation_element = `<h2>prestation</h2>
    <input type="hidden" id="id_prestation${i}" name="id_prestation${i}" ${prestation_content['id']?"value="+prestation_content['id']:'value=-1'}>
<input type="hidden" id="is_deleted${i}" name="is_deleted${i}" value=false >
<div>
    <label class="form-label" for="description${i}">Description:</label>
    <input class="form-control" type="text" id="description${i}" name="description${i}" ${prestation_content['description']?"value="+prestation_content['description']:''} ${disable_fields ? 'disabled':''} required>
</div>
<div>
    <label class="form-label" for="competence${i}">Competence:</label>
    <select class="form-select" id="competence${i}" name="competence${i}" ${disable_fields ? 'disabled':''} required></select>
</div>
<div>
    <label class="form-label" for="niveau_competence${i}">Niveau de Competence:</label>
    <select class="form-select" id="niveau_competence${i}" ${disable_fields ? 'disabled':''} name="niveau_competence${i}" required></select>
</div>
<div>
    <label class="form-label" for="date_debut${i}">Date de Début:</label>
    <input class="form-control" type="date" id="date_debut${i}" ${disable_fields ? 'disabled':''} name="date_debut${i}" ${prestation_content['date_debut']?"value="+prestation_content['date_debut']:''} required>
</div>
<div>
    <label class="form-label" for="date_fin${i}">Date de Fin:</label>
    <input class="form-control" type="date" id="date_fin${i}" ${disable_fields ? 'disabled':''} name="date_fin${i}" ${prestation_content['date_fin']?"value="+prestation_content['date_fin']:''} required>
</div>
<div>
    <label class="form-label" for="duree${i}">Durée:</label>
    <input class="form-control" type="number" id="duree${i}" ${disable_fields ? 'disabled':''} name="duree${i}" ${prestation_content['duree']?"value="+prestation_content['duree']:''} required>
</div>
<div>
    <button class="btn btn-danger mt-3" type='button' id='suppression_prestation${i}'>Supprimer</button>
</div>`
return prestation_element;
}
function synchronize_niveau_competence(numero_prestation,competence_courante,niveau_courant){
    let niveau_competence_correspondance = ['Debutant','Intermédiaire','Expert'];
    let niveau=document.getElementById(`niveau_competence${numero_prestation}`);
    niveau.innerText='';
    competences.get(competence_courante).forEach((valeur)=>{
        let option=document.createElement('option');
        option.value=valeur;
        option.selected=(niveau_courant===valeur);
        option.text=niveau_competence_correspondance[valeur-1];
        niveau.appendChild(option);
    });
}
function generer_prestation(modif){
    let prestations = document.getElementById('prestations');
    let prestation = document.createElement('div');
    nb_prestation++;
    let prestation_content ={
        'id':-1,
        'description': '',
        'competence': '',
        'niveau_competence': '',
        'date_debut': '',
        'date_fin': '',
        'duree': 1
    };
    if(modif){
        prestation_content = prestations_content[nb_prestation-1];
    }
    document.getElementById('nb_prestation').value=nb_prestation;
    prestation.id = `prestation${nb_prestation}`;
    prestation.innerHTML=get_prestation(nb_prestation,prestation_content);
    prestations.appendChild(prestation);

    let competence=document.getElementById(`competence${nb_prestation}`);
    competences.keys().forEach((key)=>{
        let option=document.createElement('option');
        option.value=key;
        option.selected=(prestation_content['competence']===key);
        option.text=key;
        competence.appendChild(option);
    });
    if(modif) {
        synchronize_niveau_competence(competence.id.slice(10),prestation_content['competence'],prestation_content['niveau_competence']);
    }
    competence.addEventListener('change',(event)=>{
        numero_prestation=competence.id.slice(10);
        synchronize_niveau_competence(numero_prestation,event.target.value,'');
        let niveau = document.getElementById(`niveau_competence${numero_prestation}`);
        niveau.selectedIndex=-1;
    })
    if(!modif) {
        competence.selectedIndex = -1;
    }
    let tomorrow=new Date();
    tomorrow.setDate(tomorrow.getDate()+1)
    let date_debut=document.getElementById(`date_debut${nb_prestation}`);
    let date_fin=document.getElementById(`date_fin${nb_prestation}`);
    let duree   =document.getElementById(`duree${nb_prestation}`)
    duree.min=1;
    date_debut.min=tomorrow.toISOString().slice(0,10);
    date_debut.addEventListener('change',(event)=>{
        date_fin.min=event.target.value;
        duree.max=(new Date(date_fin.value)-new Date(date_debut.value))/86400000+1;
    })
    date_fin.addEventListener('change',(event)=>{
        date_debut.max=event.target.value;
        duree.max=(new Date(date_fin.value)-new Date(date_debut.value))/86400000+1;
    })
    let suppression = document.getElementById(`suppression_prestation${nb_prestation}`);
    suppression.hidden=!mode_modif;
    suppression.addEventListener('click',(event)=>{
        let numero_prestation =(Number)(prestation.id.slice(10));
        document.getElementById(`prestation${numero_prestation}`).hidden=true;
        document.getElementById(`is_deleted${numero_prestation}`).value=true;
        let inputs = document.querySelectorAll(`#prestation${numero_prestation} input,#prestation${numero_prestation} select`);
        inputs.forEach((item)=> document.getElementById(item.id).removeAttribute('required'));
        nb_prestations_supprimees++;
        if (nb_prestation===nb_prestations_supprimees){
            generer_prestation(false);
        }
    })
}
</script>