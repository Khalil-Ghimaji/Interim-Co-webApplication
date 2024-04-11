<?php


function login(string $tableName, string $redirection)
{
    if (isset($_POST['username'], $_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user = get_user($username);

        if ($user !== false && isset($user['nom_utilisateur'], $user['mot_de_passe'])) {
            if ($user['nom_utilisateur'] === $username && password_verify($password, $user['mot_de_passe'])) {
                session_start();
                $_SESSION['authenticated_drh'] = $user['id'];
                $_SESSION['authenticated_drhname']=$username;
                if ($redirection!='')
                {
                    header("Location:$redirection");
                    exit;
                }
            }

        }
        return "Nom d'utilisateur ou mot de passe incorrect";
    } else {
        return '';
    }
}
?>
