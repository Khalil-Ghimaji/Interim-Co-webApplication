<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$title??'' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
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
        <ul class="navbar-nav mr-auto justify-content-end" style="width: 100%">
            <li class="nav-item ">
                <a class="nav-link navigation-title" href="/">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link navigation-title" href="/tarifs">Tarifs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link navigation-title" href="/login">Se connecter</a>
            </li>
            <li class="nav-item">
                <a class="nav-link navigation-title" href="/inscription">S'inscrire</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
