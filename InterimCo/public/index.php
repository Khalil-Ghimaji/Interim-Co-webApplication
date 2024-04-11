<?php
include(__DIR__.'/../_bootstrap.php');
require '../pages/functions/BD.php';
require '../../ConnexionBD.php';
require '../pages/functions/authentification.php';
require '../pages/functions/contrat.php';


$urlMap=[
    '/'=>'home.php',
    '/login'=>'login.php',
    '/liste-contrats'=>'list_contrats.php',
    '/logout'=>'logout.php',
    '/contrat'=>'contrat_detail.php',
    '/ajout-contrat'=>'ajout_contrat.php',
    '/suppression-contrat'=>'delete_contrat.php',
    '/profil'=>'profil.php',
    '/inscription'=>'inscription.php',
    '/validation-contrat'=>'validate_contrat.php',
    '/finalisation-contrat'=>'finalisation_contrat.php',
    '/tarifs'=>'pricing.php',
    '/pdf'=>'generer_contrat.php',
    '/te'=> '404.php'
];
$link=$_SERVER['PATH_INFO'] ?? '/';
if(isset($urlMap[$link])){
    include (__DIR__.'/../pages/'.$urlMap[$link]);
}else{
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
    include (__DIR__.'/../pages/404.php');
}
