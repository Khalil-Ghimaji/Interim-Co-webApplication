<?php
    require_once 'header.php';
    if(!isset($_SESSION['authenticated_admin'])){
        header('Location:/login');
        exit;
    }
?>
    

<div class="container mt-5">

    <h1>Bienvenue sur la Page Admin</h1>
    <p>Ici, vous pouvez gérer les clients, les agents DRH, les employés et les contrats.</p>
</div>




<?php require_once 'footer.php'?>
