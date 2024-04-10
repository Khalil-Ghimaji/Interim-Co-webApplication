<?php

    $urlMap = [
        '/' => 'home.php',
        '/login' => 'login.php',
        '/logout' => 'logout.php',
        '/createAccount' => 'createAccount.php',
        '/editAdminAccount' => 'editAdminAccount.php',
        '/deleteAccount' => 'deleteAccount.php',
        '/deleteEmployee'=>'deleteEmployee.php',
        '/clients' => 'clients.php',
        '/agentsDrh' => 'agentsDrh.php',
        '/employees' => 'employees.php',
        '/competences' => 'competences.php',
        '/contrats' => 'contrats.php',
        '/prestations' => 'prestations.php',
        '/addCompetences' => 'addCompetences.php',
        '/addEmployee' => 'addEmployee.php',
        '/addEmployeeForm' => 'addEmployeeForm.php',
    ];

    $link = $_SERVER['PATH_INFO'] ?? '/';
    if (isset($urlMap[$link])) {
        include(__DIR__ . '/../Pages/' . $urlMap[$link]);
    } else {
        header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
        include(__DIR__.'/../Pages/404.php');
    }
?>