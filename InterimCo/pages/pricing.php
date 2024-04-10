<?php
    $competences=load_competences();
    $niveau_competence_correspondance = ['Debutant','Intermédiaire','Expert'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$title??'' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<?php
$title='Accueil';
if(isset($_SESSION['authenticated_user'])){
    include (__DIR__.'/../_header.php');
}else{
    include (__DIR__.'/../_public_header.php');
}?>

<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>Competence</th>
            <th>Niveau de Competence</th>
            <th>Prix Moyen (DT/jour)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($competences as $competence){?>
        <tr>
            <td><?=$competence['competence'];?></td>
            <td><?=$niveau_competence_correspondance[$competence['niveau_competence']-1];?></td>
            <td><?=$competence['prix_estime'];?></td>
        </tr>
        <?php }?>
    </tbody>
</table>
<?php
include (__DIR__.'/../_footer.php');