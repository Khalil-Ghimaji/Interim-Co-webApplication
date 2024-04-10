<?php
function login(string $tableName,string $redirection)
{
    if (isset($_POST['username'], $_POST['password'])) {
        $username=$_POST['username'];
        $password=$_POST['password'];
        $user=get_user_by_username($username);
        if ($user and password_verify($password,$user['mot_de_passe'])) {
            $_SESSION['authenticated_user'] = $user['id'];
            $_SESSION['authenticated_role'] = $tableName;
            header('Location: /' . $redirection);
            exit;
        }
        return "nom d'utilisateur ou mot de passe erroné";
    }
    else return '';
}
function update_user(int $id,$new_user_data)
{
    $new_user_data['id']=$id;
    $bdd=ConnexionBD::openConnexion();
    $query = "update clients set nom_utilisateur= :nom_utilisateur,email=:email,nom=:nom,numero_telephone=:numero_telephone,locale=:locale where id=:id";
    $request=$bdd->prepare($query);
    try{
        $result=$request->execute($new_user_data);
    }catch(PDOException $e){
        $result=false;
    }
    $bdd=null;
    ConnexionBD::close();
    return $result;
}
function update_password(int $id,string $nouveau_pwd)
{
    $bdd=ConnexionBD::openConnexion();
    $query = "update clients set mot_de_passe=?  where id=?";
    $request=$bdd->prepare($query);
    $request->execute(array(password_hash($nouveau_pwd,PASSWORD_DEFAULT),$id));
    $bdd=null;
    ConnexionBD::close();
}
function create_new_client(array $client_data)
{
    $bdd=ConnexionBD::openConnexion();
    $query = "insert into clients (nom_utilisateur,email,nom,numero_telephone,locale,mot_de_passe) values (:nom_utilisateur,:email,:nom,:numero_telephone,:locale,:mot_de_passe)";
    $request=$bdd->prepare($query);
    try{
        $result=$request->execute($client_data);
    }catch(PDOException $e){
        $result=false;
    }
    $bdd=null;
    ConnexionBD::close();
    return $result;
}