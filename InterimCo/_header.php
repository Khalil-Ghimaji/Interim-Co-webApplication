<?php 
$notifications = load_notifications($_SESSION['authenticated_user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$title??'' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .table-green{
            --bs-table-bg: rgba(49, 210, 88, 0.5);
            --bs-table-striped-bg: rgba(68, 141, 91, 0.5);
            --bs-table-active-bg: rgba(71, 146, 110, 0.5);
            --bs-table-hover-bg: rgba(84, 182, 131, 0.5);

            --bs-table-color:#000;
            --bs-table-border-color:#a7b9b1;
            --bs-table-striped-color:#000;
            --bs-table-active-color:#000;
            --bs-table-hover-color:#000;
            color:var(--bs-table-color);
            border-color:var(--bs-table-border-color)
        }
        @media (min-width: 992px){
            #profil-dropdown{
                text-align: center;
            }
        }
        .navbar{
            background-color: #001b94 ;
        }

        .navigation-title{
            color:#ffffff;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="/"><h1>Interim Co</h1></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto justify-content-center" style="width: 100%">
            <li class="nav-item ">
                <a class="nav-link navigation-title" href="/">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link navigation-title" href="/liste-contrats">Liste des Contrats</a>
            </li>
            <li class="nav-item">
                <a class="nav-link navigation-title" href="/ajout-contrat">Nouveau Contrat</a>
            </li>
            <li class="nav-item">
                <a class="nav-link navigation-title" href="/tarifs">Tarifs</a>
            </li>
        </ul>
        <ul class="navbar-nav mr-auto col-auto" >
            <li class="nav-item dropdown" >
                <a class="nav-link dropdown-toggle navigation-title" href="#" id="notif" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Notifications
                </a>
                <div aria-labelledby="notif">
                    <ul class="dropdown-menu">
                        <?php
                        if(count($notifications)===0) {?>
                            <li class="dropdown-item">Aucune notification</li>
                        <?php }
                        else{
                            foreach($notifications as $notification){?>
                                <li>
                                    <a class="dropdown-item" href="<?="/contrat?id=".$notification['id_contrat'];?>">
                                        <p>
                                            <?=$notification['message'];?><br>
                                            <small><?=$notification['date_envoi'];?></small>
                                        </p>
                                    </a>
                                </li>
                            <?php }
                        }?>
                    </ul>
                </div>
            </li>
            <li class="nav-item dropdown" style="min-width: 170px">
                <a class="nav-link dropdown-toggle navigation-title" href="#" id="profil-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= get_user_by_id($_SESSION['authenticated_user'])['nom_utilisateur'];?>
                </a>
                <div aria-labelledby="profil-dropdown">
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/profil">Mon Profil</a></li>
                        <li><a class="dropdown-item" href="/logout">Se Déconnecter</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">