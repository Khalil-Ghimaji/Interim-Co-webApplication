<?php
function load_competences()
{
    $bdd=ConnexionBD::openConnexion();
    $query="select * from competences order by competence,niveau_competence";
    $request=$bdd->query($query);
    $response=$request->fetchAll(PDO::FETCH_ASSOC);
    $bdd=null;
    ConnexionBD::close();
    return $response;
}
function get_user_by_username(string $username){
    $bdd=ConnexionBD::openConnexion();
    $query='select * from clients where nom_utilisateur=?';
    $request=$bdd->prepare($query);
    $request->execute(array($username));
    $response=$request->fetch(PDO::FETCH_ASSOC);
    $bdd=null;
    ConnexionBD::close();
    return $response;
}
function get_user_by_id(int $id ){
    $bdd=ConnexionBD::openConnexion();
    $query='select * from clients where id=?';
    $request=$bdd->prepare($query);
    $request->execute(array($id));
    $response=$request->fetch(PDO::FETCH_ASSOC);
    $bdd=null;
    ConnexionBD::close();
    return $response;
}
function get_contrats (string $id_client){
    $bdd=ConnexionBD::openConnexion();
    $query='select * from contrats where id_client=? order by etat_contrat';
    $request=$bdd->prepare($query);
    $request->execute(array($id_client));
    $response=$request->fetchAll(PDO::FETCH_ASSOC);
    $bdd=null;
    ConnexionBD::close();
    return $response;
}
function load_notifications($id_client)
{
    $bdd=ConnexionBD::openConnexion();
    $query='select n.* from notifications n left join contrats c on c.id=n.id_contrat where c.id_client=?';
    $request=$bdd->prepare($query);
    $request->execute(array($id_client));
    $response=$request->fetchAll(PDO::FETCH_ASSOC);
    $bdd=null;
    ConnexionBD::close();
    return $response;
}
?>