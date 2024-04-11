<?php
    session_start();
    require_once 'functions.php';
require_once '../../ConnexionBD.php';

//    if(!isset($_SESSION['authenticated_admin'])||$_SESSION['authenticated_role']!="admin"){
    if(!isset($_SESSION['authenticated_admin'])){
        header('Location:/login');
        exit;
    }

    $table="agentsdrh";
    $id=null;
    if(isset($_GET['id'])){
        $id=$_GET['id'];
    }
    else{
        redirect("/agentsDrh","No id found.","danger");
        return false;
    }
    if(empty($id)){
        redirect("/agentsDrh","No id given.","danger");
        return false;
    }
    $pdo = ConnexionBD::openConnexion();
    $user=getById($pdo,$table,$id);
    if(!$user){
        redirect("/agentsDrh","User not found","danger");
        return false;
    }

    $pdo=ConnexionBD::openConnexion();
    $sql="DELETE from $table WHERE id=$id";
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
    $pdo=null;
    ConnexionBD::close();
    redirect("/agentsDrh","Compte supprimé avec succès.","success");
?>