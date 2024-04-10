<?php
if (!isset($_SESSION['authenticated_user']) or !isset($_POST['contrat_id']) or !check_permission($_POST['contrat_id'],$_SESSION['authenticated_user'])){
    header($_SERVER['SERVER_PROTOCOL'].'404 Not Found');
    include (__DIR__.'/404.php');
    exit;
}
validate_contrat($_POST['contrat_id']);
header('Location: /liste-contrats');
exit;
?>