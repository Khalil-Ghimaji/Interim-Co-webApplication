<?php session_start(); ?>
<?php
$title = 'Accueil';
include(__DIR__ . '/_header.php');
?>
<?php
$lien_retour = '/logout';
include('entete.php');
?>

<div class="container">
    <h1 class="mt-5 text-center">Accueil</h1>
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="list-group" style="font-size: 20px; background-color: #ffffff; border: none; margin-top: 10px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <a href='/contrats_en_cours_de_traitement'' class="list-group-item list-group-item-action">Contrats en cours de traitement</a>
                <a href='/contrats_acceptes' class="list-group-item list-group-item-action">Contrats acceptés</a>
                <a href='/contrats_refuses' class="list-group-item list-group-item-action">Contrats refusés</a>
                <a href='/contrats_finalises' class="list-group-item list-group-item-action">Contrats finalisés</a>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
