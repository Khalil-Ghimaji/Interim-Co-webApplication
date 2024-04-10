<?php
    session_start();
    require_once 'functions.php';
    require_once 'ConnexionBD.php';

    if(!isset($_SESSION['authenticated_admin'])||$_SESSION['authenticated_role']!="admin"){
        header('Location:/login');
        exit;
    }

    $table="employes";
    $id=null;
    if(isset($_GET['id'])){
        $id=$_GET['id'];
    }
    else{
        redirect("/employees","No id found.","danger");
        return false;
    }
    if(empty($id)){
        redirect("/employees","No id given.","danger");
        return false;
    }
    $pdo = ConnexionBD::openConnexion();
    $employee=getById($pdo,$table,$id);
    if(!$employee){
        redirect("/employees","Employee not found","danger");
        return false;
    }

    $pdo=ConnexionBD::openConnexion();
    $sql="DELETE from competence_employe WHERE id_employe=$id";
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
    $sql="DELETE from $table WHERE id=$id";
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
    $pdo=null;
    ConnexionBD::close();
    redirect("/employees","Employé retiré avec succès.","success");
?>