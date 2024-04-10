<?php
    session_start();
    unset($_SESSION['authenticated_admin']);
    header('Location: /login'); 
    exit;
?>