<?php
if (!isset($_SESSION['authenticated_user']) or !isset($_GET['id']) or !check_permission($_GET['id'],$_SESSION['authenticated_user'])){
    header($_SERVER['SERVER_PROTOCOL'].'404 Not Found');
    include (__DIR__.'/404.php');
    exit;
}
$user = $_SESSION['authenticated_user'];
$id_contrat = $_GET['id'];
$contrat_info=get_contrat($id_contrat);

if(in_array($contrat_info['etat_contrat'],['Accepté','Refusé','Finalisé'])){
    include (__DIR__.'/contrat-traite.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD']==='POST'){
    set_contrat_libelle($id_contrat,$_POST['libelle']);
    for ($i=1;$i<=$_POST['nb_prestation'];$i++){
        $is_deleted=$_POST['is_deleted'.$i];
        $id_prestation=$_POST['id_prestation'.$i];
        if($id_prestation!=-1){
            if($is_deleted=='true'){
                delete('prestations',$id_prestation);
            }
            else{
                update_prestation($id_prestation,$id_contrat,$_POST['date_debut'.$i],$_POST['date_fin'.$i],$_POST['description'.$i],$_POST['duree'.$i],$_POST['competence'.$i],$_POST['niveau_competence'.$i]);
            }
        }
        elseif ($is_deleted=='false'){
            insert_prestation($id_contrat,$_POST['date_debut'.$i],$_POST['date_fin'.$i],$_POST['description'.$i],$_POST['duree'.$i],$_POST['competence'.$i],$_POST['niveau_competence'.$i]);
        }
    }
    estimate_price($id_contrat);
    header('Location:/liste-contrats');
    exit;
}
?>
<script>
    let prestations_content=<?= json_encode(get_prestations($id_contrat));?>;
    let ce_contrat = <?= json_encode(get_contrat($id_contrat));?>;
    let libelle_valeur = ce_contrat['libelle'];
    let etat_valeur = ce_contrat['etat_contrat']
</script>
<?php
$title='Details Contrat';
include (__DIR__.'/../_header.php');
?>
<h1 class="text-center"><?=$title?></h1>
<script>
    let disable_fields = !localStorage.getItem('disable_fields');
    if(!disable_fields) {
        localStorage.removeItem('disable_fields');
    }
    let mode_modif = !disable_fields;
</script>
<?php
include (__DIR__.'/../pages/snippets/form_contract.php');
?>
<script>
    let enregistrement = document.getElementById('enregistrement');
    ajout.hidden = !mode_modif;
    enregistrement.hidden = !mode_modif;
    if (etat_valeur==='En attente de validation') {
        let form_html = document.getElementById('contrat');
        let div_bouton_modif = document.createElement('div');
        let bouton_modif = document.createElement('button');
        bouton_modif.id = 'bouton_modif';
        bouton_modif.classList.add('btn');
        bouton_modif.classList.add('btn-secondary')
        bouton_modif.textContent = 'Modifier';
        bouton_modif.hidden = mode_modif;
        bouton_modif.addEventListener('click', (event) => {
            event.preventDefault();
            localStorage.setItem('disable_fields', false);
            location.reload();
        })
        div_bouton_modif.appendChild(bouton_modif);
        form_html.appendChild(div_bouton_modif);
    }
</script>
<?php
include (__DIR__.'/../_footer.php');
?>