


<?php
$title='Accueil';
if(isset($_SESSION['authenticated_user'])){
    include (__DIR__.'/../_header.php');
}else{
    include (__DIR__.'/../_public_header.php');
}?>
<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
<style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        margin-top: 50px;
        padding-left: 5rem;
        padding-right: 5rem;

    }
    .jumbotron{
        background-color: rgba(0, 40.5, 222, 0.95);
        color: #fffffff6;
        padding:2rem 1rem;
        margin-bottom:2rem;
        border-radius:.3rem
    }
    @media (min-width:576px){
        .jumbotron{padding:4rem 2rem}
    }
    .lead{
        font-size:1.25rem;
        font-weight:300
    }


    .contact-info {
        margin-top: 30px;
    }
</style>
<body>
<div class="container">
    <div class="jumbotron">
        <h1 class="display-4">Bienvenue sur InterimCo</h1>
        <p class="lead">Votre partenaire de confiance pour la gestion efficace de vos besoins en personnel intérimaire.</p>
        <hr class="my-4">
        <p>Notre application web est conçue pour simplifier et automatiser vos processus, vous permettant ainsi de vous concentrer sur votre activité principale en toute tranquillité.</p>
    </div>

    <div class="row">
        <div class="col-md-6" id="about">
            <h2>À propos de nous</h2>
            <p>Chez InterimCo, nous mettons l'accent sur la qualité de nos services et sur la satisfaction de nos clients. Grâce à notre expertise dans le domaine de l'intérim, nous vous offrons des solutions personnalisées et adaptées à vos besoins spécifiques. Que vous recherchiez des travailleurs temporaires qualifiés pour des missions ponctuelles ou que vous ayez besoin d'une gestion complète de votre personnel intérimaire, nous sommes là pour vous accompagner à chaque étape.</p>
        </div>
        <div class="col-md-6" id="contact">
            <h2>Nous contacter</h2>
            <p>Vous avez des questions sur nos services ou vous souhaitez obtenir des informations supplémentaires ? N'hésitez pas à nous contacter par email à l'adresse <a href="mailto:contact@interimco.com">contact@interimco.com</a>. Notre équipe se fera un plaisir de répondre à toutes vos demandes dans les plus brefs délais.</p>
        </div>
    </div>
<?php if(!isset($_SESSION['authenticated_user'])){?>
    <div class="contact-info">
        <h2>Inscription et Connexion</h2>
        <p>Si vous êtes un client d'InterimCo, vous pouvez accéder à votre espace personnel en vous connectant <a href="/login">ici</a>. Si vous êtes nouveau chez nous, nous vous invitons à <a href="/inscription">vous inscrire</a> pour bénéficier de tous nos services et avantages.</p>
    </div>
    <?php }?>
</div>


<?php
include (__DIR__.'/../_footer.php');