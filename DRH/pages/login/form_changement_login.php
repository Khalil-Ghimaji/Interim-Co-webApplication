<?php
$title='Changement infos login';
include(__DIR__.'/../_header.php');
?>

<?php
$formErrors = [];
$successMessages = [];
$nombre_changements = 0;
$changement_correct = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $ancien_mot_de_passe = $_POST["password"];
        $ancien_nom_utilisateur = $_POST["username"];
        $user = get_user($ancien_nom_utilisateur);

        if ($user !== false && isset($user['nom_utilisateur'], $user['mot_de_passe'], $user['id'])) {
            if (password_verify($ancien_mot_de_passe, $user['mot_de_passe'])) {
                $id_user = $user['id'];
            } else {
                $formErrors[] = "Nom d'utilisateur ou mot de passe incorrect";
                $changement_correct = false;
            }
        } else {
            $formErrors[] = "Nom d'utilisateur ou mot de passe incorrect";
            $changement_correct = false;
        }

        if (empty($formErrors) && isset($id_user)) {
            if (!empty($_POST["nouveau_mot_de_passe"]) && !empty($_POST["confirmer_nouveau_mot_de_passe"])) {
                if ($_POST["nouveau_mot_de_passe"] !== $_POST["confirmer_nouveau_mot_de_passe"]) {
                    $formErrors[] = 'Les nouveaux mots de passe ne correspondent pas.';
                    $changement_correct = false;
                }
            }

            if (!empty($_POST["nouveau_nom_utilisateur"])) {
                if (data_exists('nom_utilisateur', $_POST['nouveau_nom_utilisateur']) !== false) {
                    $formErrors[] = "Le nom d'utilisateur existe déjà.";
                    $changement_correct = false;
                }
            }

            if (!empty($_POST["nouveau_email"])) {
                if (data_exists('email', $_POST['nouveau_email']) !== false) {
                    $formErrors[] = "L'email existe déjà.";
                    $changement_correct = false;
                }
            }

            if (empty($formErrors) && $changement_correct) {
                if (!empty($_POST["nouveau_mot_de_passe"])) {
                    mettre_a_jour_login($id_user, 'mot_de_passe', password_hash($_POST['nouveau_mot_de_passe'], PASSWORD_DEFAULT));
                    $successMessages[] = 'Mot de passe changé avec succès.';
                    $nombre_changements++;
                }

                if (!empty($_POST["nouveau_nom_utilisateur"])) {
                    mettre_a_jour_login($id_user, 'nom_utilisateur', $_POST['nouveau_nom_utilisateur']);
                    $successMessages[] = "Nom d'utilisateur changé avec succès.";
                    $nombre_changements++;
                }

                if (!empty($_POST["nouveau_email"])) {
                    mettre_a_jour_login($id_user, 'email', $_POST['nouveau_email']);
                    $successMessages[] = 'Email changé avec succès.';
                    $nombre_changements++;
                }

                if ($nombre_changements == 0) {
                    $formErrors[] = 'Aucun changement effectué.';
                }
            }
        }
    } else {
        $formErrors[] = "Veuillez remplir l'ancien mot de passe et l'ancien nom d'utilisateur";
    }
}

?>

<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
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
                    <a class="nav-link" href="javascript:history.back()">Retour</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout" >Se Connecter de nouveau</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <h2 class="mt-5">Changement d'infos de login</h2>
    <form method="post" id="myForm">
        <div class="mb-3">
            <?php foreach ($formErrors as $error): ?>
                <div class="alert alert-danger" role="alert"><?= $error ?></div>
            <?php endforeach; ?>
            <?php if (empty($formErrors)): ?>
                <?php foreach ($successMessages as $message): ?>
                    <div class="alert alert-success" role="alert"><?= $message ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="ancien_nom_utilisateur">Ancien nom d'utilisateur :</label>
            <input type="text" class="form-control" id="ancien_nom_utilisateur" name="username" placeholder="Entrez l'ancien nom d'utilisateur" required>
        </div>
        <div class="form-group">
            <label for="ancien_mot_de_passe">Ancien mot de passe :</label>
            <input type="password" class="form-control" id="ancien_mot_de_passe" name="password" placeholder="Entrez l'ancien mot de passe" required>
        </div>
        <div class="form-group">
            <label for="nouveau_mot_de_passe">Nouveau mot de passe :</label>
            <input type="password" class="form-control" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" placeholder="Entrez le nouveau mot de passe" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Le mot de passe doit contenir au moins 8 caractères, avec au moins une lettre majuscule, une lettre minuscule et un chiffre." required>
        </div>
        <div class="form-group">
            <label for="confirmer_nouveau_mot_de_passe">Confirmer nouveau mot de passe :</label>
            <input type="password" class="form-control" id="confirmer_nouveau_mot_de_passe" name="confirmer_nouveau_mot_de_passe" placeholder="Confirmez le nouveau mot de passe">
        </div>
        <div class="form-group">
            <label for="nouveau_nom_utilisateur">Nouveau nom d'utilisateur :</label>
            <input type="text" class="form-control" id="nouveau_nom_utilisateur" name="nouveau_nom_utilisateur" placeholder="Entrez le nouveau nom d'utilisateur">
        </div>
        <div class="form-group">
            <label for="nouveau_email">Nouvel email :</label>
            <input type="email" class="form-control" id="nouveau_email" name="nouveau_email" placeholder="Entrez le nouvel email">
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
