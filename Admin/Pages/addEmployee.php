<?php
    require_once 'functions.php';
    require_once 'ConnexionBD.php';
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(!isset($_SESSION['authenticated_admin'])||$_SESSION['authenticated_role']!="admin"){
        header('Location:/login');
        exit;
    }


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $competences = $_POST["competence"];
    $autreCompetences=$_POST["autreCompetence"];
    $niveaux = $_POST["niveau"];
    $prices=$_POST["prix"];

    $pdo = ConnexionBD::openConnexion();
    
    
    $stmt = $pdo->prepare("SELECT * FROM employes WHERE LOWER(email) = :email ");
    $stmt->execute(['email' => strtolower($email)]);
    if ($stmt->rowCount() > 0) {
        redirect('/addEmployeeForm','Email déja utilisé!',"danger");
    }
    else{
        $data=[
            'nom'=>$nom,
            'prenom'=>$prenom,
            'email'=>$email,
            'numero_telephone'=>$tel
        ];
        insert($pdo,'employes',$data);
    }

    $employeeId = $pdo->lastInsertId();

    foreach ($competences as $key => $competence) {
        
        $competence=strtolower($competence);
        $niveau = $niveaux[$key];
        $prix=$prices[$key];

        if($competence==""){
            $competence=strtolower($autreCompetences[$key]);
        }

        $sql = "SELECT id FROM competences WHERE LOWER(competence) = :competence AND niveau_competence = :niveau";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['competence'=>$competence,'niveau'=>$niveau]);

        $competenceId=null;

        if ($stmt->rowCount()==0) {
            $sql = "INSERT INTO competences (competence, niveau_competence,prix_estime) VALUES (:competence, :niveau, :prix_estime)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['competence'=>$competence,'niveau'=>$niveau,'prix_estime'=>$prix]);
            $competenceId = $pdo->lastInsertId();
        } else {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $competenceId = $result['id'];
        }

        $sql = "INSERT INTO competence_employe (id_employe, id_competence) VALUES (:id_employe, :id_competence)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_employe'=>$employeeId,'id_competence'=>$competenceId]);
    }
    $pdo=null;
    ConnexionBD::close();

    redirect('/employees','Employé ajouté avec succès!','success');

}
?>





