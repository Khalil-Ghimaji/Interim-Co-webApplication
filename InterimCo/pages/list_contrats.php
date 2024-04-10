<?php
if (!isset($_SESSION['authenticated_user'])){
    header('Location:/login?next=liste-contrats');
    exit;
}
$contrats=get_contrats($_SESSION["authenticated_user"]);

$title='liste des contrats';
include (__DIR__.'/../_header.php');?>
<h1><?=$title?></h1>
<div><a class="btn btn-primary mb-3" href="/ajout-contrat">Nouveau contrat</a></div>
<?php
if (count($contrats)===0){?>
    <h2>Il n'y a aucun contrat!</h2>
<?php
}
else{?>
<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>Libelle</th>
            <th>Date d'envoi</th>
            <th>Date de reponse</th>
            <th>Prix</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($contrats as $contrat){?>
        <tr>
            <td><?=$contrat['libelle'];?></td>
            <td><?=$contrat['date_soumission'];?></td>
            <td><?=$contrat['date_reponse'];?></td>
            <td><?=$contrat['prix'];?></td>
            <td><?=$contrat['etat_contrat'];?></td>
            <td>
                <div class="container text-center">
                    <div class="row">

                        <div class="col">
                            <a class="btn btn-info"  style="width: 100%"  href="/contrat?id=<?= $contrat['id'] ?>">Details</a>
                        </div>
                        <?php if($contrat['etat_contrat']==='En attente de validation'){?>
                        <form class="col" action="/validation-contrat" method="POST">
                            <input type="hidden" name='contrat_id' value="<?= $contrat['id'] ?>">
                            <button class="btn btn-success" style="width: 100%" type="submit">Valider</button>
                        </form>
                        <?php }elseif($contrat['etat_contrat']==='Accepté'){?>
                        <form class="col" action="/finalisation-contrat" method="POST">
                            <input type="hidden" name='contrat_id' value="<?= $contrat['id'] ?>">
                            <button class="btn btn-success" style="width: 100%" type="submit">Finaliser</button>
                        </form>
                        <?php }?>
                        <form class="col" action="/suppression-contrat" method="POST">
                            <input type="hidden" name='contrat_id' value="<?= $contrat['id'] ?>">
                            <button class="btn btn-danger" style="width: 100%" type="submit">Supprimer</button>
                        </form>
                    </div>
                </div>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script>
    contract_rows=document.querySelectorAll('tr');
    Array.from(contract_rows).slice(1).forEach(contract_row=>{
        const status = contract_row.querySelectorAll('td')[4].textContent;
        if(status === 'En attente de validation'){
            contract_row.classList.add('table-warning');
        }
        else if(status === 'En cours de traitement') {
            contract_row.classList.add('table-secondary');
        }
        else if(status === 'Accepté'){
            contract_row.classList.add('table-success');
        }
        else if(status === 'Refusé'){
            contract_row.classList.add('table-danger');
        }
        else{
            contract_row.classList.add('table-green');
        }

    })
</script>
<?php
}
include (__DIR__.'/../_footer.php');
?>

