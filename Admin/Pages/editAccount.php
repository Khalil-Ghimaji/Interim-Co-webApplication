<?php
    include 'header.php';
?>
    <div>
        <h2>Modifier Compte
            <a href="/users">Back</a>
        </h2>
        
    </div>
    <form method="POST" action="">
        <?php
            $table=null;
            $id=null;
            if(isset($_GET['id_hr'])){
                $table="agentsdrh";
                $id=$_GET['id_hr'];
            }
            else if(isset($_GET['id_cl'])){
                $table="clients";
                $id=$_GET['id_cl'];
            }
            else{
                redirect("/users","No id found.","danger");
                return false;
            }
            if(empty($id)){
                redirect("/users","No id given.","danger");
                return false;
            }
            $pdo = ConnexionBD::openConnexion();
            $user=getById($pdo,$table,$id);
            if(!$user){
                redirect("/users","User not found","danger");
                return false;
            }
        ?>
        <label>Nom d'utilisateur:</label><br>
        <input type="text" name="username" required value="<?=$user['nom_utilisateur'];?>"><br>
        <label>Email:</label><br>
        <input type="email" name="email" required value="<?=$user['email'];?>"><br>
        <label>Mot de Passe:</label><br>
        <input type="password" name="password" required ><br>
        <br>
        <input type="submit" value="Modifier compte">
    </form>
    
</body>
</html>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($username) || empty($email) || empty($password)) {
        echo "Please fill in all fields.";
    } else {
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $pdo = ConnexionBD::openConnexion();
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE nom_utilisateur = :username");
        $stmt->execute(['username' => $username]);
        
        if ($stmt->rowCount() > 0 && $username!=$user['nom_utilisateur']) {
            echo "Username already taken.";
            return false;
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format.";
                return false;
            } else {
                $sql="UPDATE $table
                      SET nom_utilisateur='$username', mot_de_passe='$password',email='$email'
                      where id=$id ";
                $stmt=$pdo->prepare($sql);
                $stmt->execute();
            }
        }
        $pdo=null;
        ConnexionBD::close();
        redirect("/users","Compte modifié avec succès","success");
        
    }
}
?>
