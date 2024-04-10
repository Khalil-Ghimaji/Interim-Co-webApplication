<?php
if(isset($_SESSION['authenticated_user'])){
    header('Location:/');
    exit;
}
$formErrors=login('clients',$_GET['next']??'');
$title='login';
include (__DIR__.'/../_public_header.php');
include (__DIR__.'/../pages/snippets/form_login.php');
include (__DIR__.'/../_footer.php');