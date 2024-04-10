<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<?php
$prestations=get_prestations($id_contrat);
include (__DIR__."/../pages/functions/generer_contrat.php");
$title='Details Contrat';
include(__DIR__ . '/../_header.php');
?>

<h1>Contrat : <?= $contrat_info['libelle'];?></h1>
<h3 class="mt-3">Prestations:</h3>
<table class="table table-hover table-bordered mt-3 table-<?=$contrat_info['etat_contrat']==='Refusé'?"danger":"success";?>">
    <thead>
    <tr>
        <th>Description</th>
        <th>Date de Début</th>
        <th>Date de Fin</th>
        <th>Durée</th>
        <?php if($contrat_info['etat_contrat']!=="Refusé"){?>
            <th>Prix</th>
        <?php }?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($prestations as $prestation) {?>
        <tr>
            <td><?=$prestation['description'];?></td>
            <td><?=$prestation['date_debut'];?></td>
            <td><?=$prestation['date_fin'];?></td>
            <td><?=$prestation['duree'];?></td>
            <?php if($contrat_info['etat_contrat']!=="Refusé"){?>
                <td><?=$prestation['prix'];?></td>
            <?php }?>

        </tr>
    <?php } ?>
    </tbody>
</table>
<?php if($contrat_info['etat_contrat']!=="Refusé"){?>
    <h4 class="mt-3">Prix Total : <?=$contrat_info['prix'];?> DT</h4>
<?php }
include(__DIR__ . '/../_footer.php'); ?>
