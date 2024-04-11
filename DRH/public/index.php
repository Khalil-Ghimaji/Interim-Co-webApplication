<?php
require '../database/BD.php';
require '../../ConnexionBD.php';
require '../pages/contrats/afficher_contrat.php';


$urlMap = [
    '/action' =>'prestations/action.php',
    '/home' => 'home.php',
    '/' => 'login/login.php',
    '/logout' => 'login/logout.php',
    '/changement_login' => 'login/form_changement_login.php',
    '/contrats_en_cours_de_traitement' => 'contrats/contrats_en_cours_de_traitement.php',
    '/contrats_acceptes' => 'contrats/contrats_acceptes.php',
    '/contrats_finalises' => 'contrats/contrats_finalises.php',
    '/aucun_contrat_existant' => 'contrats/aucun_contrat_existant.php',
    '/traitement_contrat' => 'contrats/traitement_contrat.php',
    '/traitement_prestation' => 'prestations/traitement_prestation.php',
    '/gestion_employes' => 'prestations/employes.php',
    '/detail_prestation' => 'prestations/detail_prestation.php',
    '/detail_contrat' => 'contrats/detail_contrat.php',
    '/contrats_refuses' => 'contrats/contrats_refuses.php',
    '/employes_detail' => 'prestations/employes_detail.php',
    '/info' => 'login/user_info.php',

];
$link = $_SERVER['PATH_INFO'] ?? '/';
if (isset($urlMap[$link])) {
        include(__DIR__ . '/../pages/' . $urlMap[$link]);
}
 else {
    header($_SERVER['SERVER_PROTOCOL'] . '404 Not Found');
    include(__DIR__ . '/../pages/404.php');
}
