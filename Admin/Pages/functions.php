<?php
    function insert($pdo,$table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_map(function ($value) {
            return "'" . $value . "'";
        }, $data));

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
    function getAll($pdo,$table){
        $stmt = $pdo->prepare("SELECT * FROM $table");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    function getById($pdo,$table,$id){
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    function redirect($page,$message,$type){
        $_SESSION['status_type']=$type;
        $_SESSION['status']=$message;
        header('Location: '.$page);
        exit(0);
    }
    function alertMessage(){
        
        if(isset($_SESSION['status'])){
            $type=$_SESSION['status_type'];
            echo "<div class=\"alert alert-$type mt-3\" role=\"alert\">
                    ".$_SESSION['status']."</div>";
            unset($_SESSION['status']);
            unset($_SESSION['status_type']);
        }
    }
    
    function getAdmin($pdo){
        $stmt = $pdo->prepare("SELECT * FROM admin ");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function login(string $tableName,string $redirection,$pdo)
    {
        if (isset($_POST['username'], $_POST['password'])) {
            $login=$_POST['username'];
            $password=$_POST['password'];
            $pdo=ConnexionBD::openConnexion();
            $admin=getAdmin($pdo);
            if ($admin['login']===$login and password_verify($password,$admin['mot_de_passe'])){
                $_SESSION['authenticated_admin']=$admin["login"];
//                $_SESSION['authenticated_role']=$tableName;
                header('Location: '.$redirection);
                exit;
            }
            return "nom d'utilisateur ou mot de passe erroné";
        }
        else return '';
    }
    
    function updatePassword($pdo,$newPassword){
        $hashedPassword=password_hash($newPassword, PASSWORD_DEFAULT);
        $sql="UPDATE admin
                SET mot_de_passe ='$hashedPassword'
                where login='admin' ";
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
    }
    
    
?>