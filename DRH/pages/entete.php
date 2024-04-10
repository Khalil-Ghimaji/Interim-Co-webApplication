<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container  entete-container">
        <a class="navbar-brand" href="#"><h2 class="h2-container">InterimCo</h2></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/home">Acceuil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href=<?=$lien_retour??'/'?>>Retour</a>
                </li>

                <li class="nav-item dropdown">
                    <button class="btn dropdown-toggle" type="button" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?=$_SESSION['authenticated_drhname']?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="/info">Profil</a>
                        <a class="dropdown-item" href="/changement_login">Changement de login</a>
                        <a class="dropdown-item" href="/logout">Déconnexion</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>


