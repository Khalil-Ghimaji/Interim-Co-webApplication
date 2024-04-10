<?php
session_start();
if(isset($_SESSION['authenticated_drh'])){
    header('Location:/home');
    exit;
}
include ('authentification.php');
$formErrors=login('agentsdrh',$_GET['next']??'/home');
include ('form_login.php');
