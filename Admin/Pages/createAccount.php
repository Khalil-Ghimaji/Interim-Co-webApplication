<?php
    include "header.php";
?>
<div class="container mt-5">
    
    <?=alertMessage();?>
    <form method="POST" action="" >
        <div class="form-group">
            <label for="name">Nom :</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>
        <div class="form-group">
            <label for="first_name">Prénom :</label>
            <input type="text" class="form-control" name="first_name" id="first_name" required>
        </div>
        <div class="form-group">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" class="form-control" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de Passe :</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <div class="form-group">
            <label for="tel">Numéro de téléphone :</label>
            <input type="text" class="form-control" name="tel" id="tel" pattern="\d{8}" title="Veuillez donner un numéro valide" required>
        </div>
        <input type="submit" class="btn btn-primary" value="Créer compte">
    </form>
</div>
    
<?php require_once 'footer.php'?>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name=$_POST["first_name"];
    $name=$_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $tel=$_POST["tel"];

    if (empty($username) || empty($email) || empty($password)||empty($first_name)||empty( $name)) {
        echo "Veuillez remplir tous les champs.";
    } else {

        if(!is_numeric($tel)||strlen($tel)!=8){
            echo "<h4>Veuillez donner un numéro de téléphone valide !</h4>";
            return false;
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $table="agentsdrh";
        $pdo = ConnexionBD::openConnexion();
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE nom_utilisateur = :username");
        $stmt->execute(['username' => $username]);
        if ($stmt->rowCount() > 0) {
            echo "Nom d'utilisateur déjà pris.";
            return false;
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Format d'email invalide !";
                return false;
            } else {
                $data = [
                    'nom_utilisateur' => $username,
                    'email' => $email,
                    'mot_de_passe' => $hashedPassword,
                    'numero_telephone' =>$tel,
                    'nom' =>$name,
                    'prenom' =>$first_name
                ];
                insert($pdo,$table,$data);
                redirect("/agentsDrh","Compte creé avec succes!","success");
            }
        }
        $pdo=null;
        ConnexionBD::close();
    }
}
?>
