<?php
function check_permission(int $id_contrat,string $user){
    $bdd=ConnexionBD::openConnexion();
    $query='select * from contrats where id=? and id_client=?';
    $request=$bdd->prepare($query);
    $request->execute(array($id_contrat,$user));
    $response=$request->fetch(PDO::FETCH_ASSOC);
    $bdd=null;
    ConnexionBD::close();
    return !!($response);
}
function insert_prestation($id_contrat,$date_debut,$date_fin,$description,$duree,$competence,$niveau_competence)
{
    $bdd=ConnexionBD::openConnexion();


    $query1='SELECT id FROM competences WHERE competence = ? AND niveau_competence= ?';
    $request1=$bdd->prepare($query1);
    $request1->execute(array($competence,$niveau_competence));
    $response=$request1->fetch(PDO::FETCH_ASSOC);
    $id_competence = $response['id'];

    $query='insert into prestations (id_contrat,date_debut,date_fin,description,duree,id_competence) values (?,?,?,?,?,?)';
    $request=$bdd->prepare($query);
    $request->execute(array($id_contrat,$date_debut,$date_fin,$description,$duree,$id_competence));
    $prestationId=$bdd->lastInsertId();
    $bdd=null;
    ConnexionBD::close();
    return $prestationId;
}
function insert_contrat($id_client,$libelle)
{
    $bdd=ConnexionBD::openConnexion();
    $query="insert into contrats (id_client,etat_contrat,libelle) values (?,'En attente de validation',?)";
    $request=$bdd->prepare($query);
    $request->execute(array($id_client,$libelle));
    $contratId=$bdd->lastInsertId();
    $bdd=null;
    ConnexionBD::close();
    return $contratId;
}
function get_contrat (int $id_contrat){
    $bdd=ConnexionBD::openConnexion();
    $query='select libelle,etat_contrat,prix from contrats where id=?';
    $request=$bdd->prepare($query);
    $request->execute(array($id_contrat));
    $response=$request->fetch(PDO::FETCH_ASSOC);
    $bdd=null;
    ConnexionBD::close();
    return $response;
}
function set_contrat_libelle(int $id_contrat, string $libelle)
{
    $bdd=ConnexionBD::openConnexion();
    $query='update contrats set libelle = ? where id= ?';
    $request=$bdd->prepare($query);
    $request->execute(array($libelle,$id_contrat));
    $bdd=null;
    ConnexionBD::close();
}
function get_prestations(int $id_contrat){
    $bdd=ConnexionBD::openConnexion();
    $query='select p.id,p.description,p.date_debut,p.date_fin,p.duree,c.competence,c.niveau_competence,p.prix from prestations p inner join competences c on c.id = p.id_competence where id_contrat=?';
    $request=$bdd->prepare($query);
    $request->execute(array($id_contrat));
    $response=$request->fetchAll(PDO::FETCH_ASSOC);
    $bdd=null;
    ConnexionBD::close();
    return $response;
}
function delete(string $Tablename,int $id)
{
    $bdd=ConnexionBD::openConnexion();
    $query='delete from '.$Tablename.' where id=?';
    $request=$bdd->prepare($query);
    $request->execute(array($id));
    $bdd=null;
    ConnexionBD::close();
}
function update_prestation($id_prestation,$id_contrat,$date_debut,$date_fin,$description,$duree,$competence,$niveau_competence)
{
    $bdd=ConnexionBD::openConnexion();

    $query1='SELECT id FROM competences WHERE competence = ? AND niveau_competence= ?';
    $request1=$bdd->prepare($query1);
    $request1->execute(array($competence,$niveau_competence));
    $response=$request1->fetch(PDO::FETCH_ASSOC);
    $id_competence = $response['id'];

    $query='UPDATE prestations
            SET id_contrat = ?, date_debut = ?, date_fin = ?, description = ?, duree = ?, id_competence = ?
            WHERE id = ?;';
    $request=$bdd->prepare($query);
    $request->execute(array($id_contrat,$date_debut,$date_fin,$description,$duree,$id_competence,$id_prestation));
    $bdd=null;
    ConnexionBD::close();
}
function validate_contrat(int $id_contrat)
{
    $bdd=ConnexionBD::openConnexion();
    $query="update contrats set etat_contrat = 'En cours de traitement', date_soumission='".date("Y-m-d")."' where id= ?";
    $request=$bdd->prepare($query);
    $request->execute(array($id_contrat));
    $bdd=null;
    ConnexionBD::close();
}
function estimate_price($id_contrat){
    $bdd=ConnexionBD::openConnexion();
    $query="update contrats set prix =(select sum(c.prix_estime*p.duree)from prestations p left join competences c on p.id_competence =c.id where p.id_contrat =?) where id=?";
    $request=$bdd->prepare($query);
    $request->execute(array($id_contrat,$id_contrat));
    $query="update prestations p set prix =(select c.prix_estime*p.duree from prestations p left join competences c on p.id_competence =c.id where p.id_contrat =?) where p.id_contrat =?";
    $request=$bdd->prepare($query);
    $request->execute(array($id_contrat,$id_contrat));
    $bdd=null;
    ConnexionBD::close();
}

function set_status($id_contrat,string $status){
    $bdd=ConnexionBD::openConnexion();
    $query="update contrats set etat_contrat = ? where id= ?";
    $request=$bdd->prepare($query);
    $request->execute(array($status,$id_contrat));
    $bdd=null;
    ConnexionBD::close();
}