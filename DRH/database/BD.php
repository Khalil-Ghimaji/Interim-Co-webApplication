<?php
function get_data(string $nom_table, int $id_table)
{
    $bdd = ConnexionBD::openConnexion();
    $query = "select * from $nom_table where id=? ";
    $request = $bdd->prepare($query);
    $request->execute(array($id_table));
    $response = $request->fetch(PDO::FETCH_ASSOC);
    $bdd = null;
    ConnexionBD::close();
    return $response;
}

function get_contrats(string $etat_contrat)
{
    $bdd = ConnexionBD::openConnexion();
    $query = "select * from contrats where etat_contrat=? ";
    $request = $bdd->prepare($query);
    $request->execute(array($etat_contrat));
    $response = $request->fetchAll(PDO::FETCH_ASSOC);
    $bdd = null;
    ConnexionBD::close();
    return $response;
}

function get_employes_adequats(int $id_prestation)
{
    $prestation_data = get_data("prestations", $id_prestation);

    $competence_data = get_data("competences", $prestation_data["id_competence"]);

    $bdd = ConnexionBD::openConnexion();
    $query = "SELECT e.*
              FROM employes e
              INNER JOIN competence_employe ce ON e.id = ce.id_employe
              WHERE ce.id_competence = ?
              AND e.id NOT IN (
                  SELECT ep.id_employe
                  FROM employe_prestation ep
                  INNER JOIN prestations p ON p.id = ep.id_prestation
                  WHERE ((p.date_debut >= ? AND p.date_debut < ?) OR (p.date_fin > ? AND p.date_fin <= ?))
              )";

    $request = $bdd->prepare($query);

    $request->execute(array(
        $competence_data["id"],
        $prestation_data["date_debut"],
        $prestation_data["date_fin"],
        $prestation_data["date_debut"],
        $prestation_data["date_fin"],
    ));

    $response = $request->fetchAll(PDO::FETCH_ASSOC);

    $bdd = null;
    ConnexionBD::close();

    return $response;
}

function get_employes_affectes($id_prestation)
{
    $bdd = ConnexionBD::openConnexion();
    $query = "select * from employes e 
         inner join employe_prestation ep on e.id=ep.id_employe
         where id_prestation=? ";
    $request = $bdd->prepare($query);
    $request->execute(array($id_prestation));
    $response = $request->fetchAll(PDO::FETCH_ASSOC);
    $bdd = null;
    ConnexionBD::close();
    return $response;
}

function inserer_employe_prestation(int $id_employe, int $id_prestation)
{
    $bdd = ConnexionBD::openConnexion();

    // vérifier si l'employé est déjà affecté à la prestation
    $query_check = "SELECT COUNT(*) FROM employe_prestation WHERE id_employe = ? AND id_prestation = ?";
    $request_check = $bdd->prepare($query_check);
    $request_check->execute(array($id_employe, $id_prestation));
    $count = $request_check->fetchColumn();

    if ($count == 0) {
        // insérer l'entrée uniquement si l'employé n'est pas déjà affecté à la prestation
        $query_insert = "INSERT INTO employe_prestation (id_employe, id_prestation) VALUES (?, ?)";
        $request_insert = $bdd->prepare($query_insert);
        $request_insert->execute(array($id_employe, $id_prestation));
    }

    $bdd = null;
    ConnexionBD::close();
}

function supprimer_employe_prestation(int $id_employe, int $id_prestation)
{
    $bdd = ConnexionBD::openConnexion();

    $query = "DELETE FROM employe_prestation WHERE id_employe = ? AND id_prestation = ?";
    $request = $bdd->prepare($query);
    $request->execute(array($id_employe, $id_prestation));

    $bdd = null;
    ConnexionBD::close();
}

function update_prix_contrat(int $id_contrat)
{
    $bdd = ConnexionBD::openConnexion();

    $query = "SELECT SUM(prix) AS prix_total FROM prestations WHERE id_contrat = ?";
    $request = $bdd->prepare($query);
    $request->execute(array($id_contrat));
    $prix_total = $request->fetch(PDO::FETCH_ASSOC)['prix_total'];


    $query = "UPDATE contrats 
              SET prix = ?
              WHERE id = ?";

    $request = $bdd->prepare($query);
    $request->execute(array(
        $prix_total,
        $id_contrat
    ));

    $bdd = null;
    ConnexionBD::close();
}

function notifier_client(int $id_contrat,int $id_agent_drh, string $type_de_notification, string $libelle)
{
    $bdd = ConnexionBD::openConnexion();
    $message = "";

    switch ($type_de_notification) {
        case "succes":
            $message = "Votre contrat(ID: $id_contrat) de libellé $libelle a été traité avec succès.";
            break;
        case "echec":
            supprimer_prestations_contrat($id_contrat);
            $message = "Nous regrettons de vous informer que nous ne pouvons pas satisfaire les prestations demandées dans votre contrat(ID: $id_contrat) de libellé $libelle aux dates spécifiées. Cependant, nous sommes déterminés à trouver une solution alternative pour répondre à vos besoins. Veuillez nous contacter pour discuter des options disponibles. Nous apprécions votre confiance en notre société et nous nous engageons à vous fournir un service de qualité.";
            break;
    }

    $query = "INSERT INTO notifications (id_contrat, message, date_envoi) VALUES (?, ?, NOW())";
    $request = $bdd->prepare($query);
    $request->execute(array($id_contrat, $message));
    $date_aujourdhui = date('Y-m-d');
    $sql = "UPDATE contrats SET date_reponse = ? ,id_agent_drh= ? WHERE id = ?";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(array($date_aujourdhui,$id_agent_drh,$id_contrat));
    $bdd = null;
    ConnexionBD::close();
}
function supprimer_prestations_contrat(int $id_contrat)
{
    $bdd = ConnexionBD::openConnexion();
    $sql = "Delete from employe_prestation WHERE id_prestation 
in(
    select id from prestations where id_contrat=?
)
";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(array($id_contrat));
    $bdd = null;
    ConnexionBD::close();
}
function prestations_sans_employe_contrat(int $id_contrat)
{
    $bdd = ConnexionBD::openConnexion();
    $sql = "SELECT id FROM prestations WHERE id_contrat = ? 
                                  AND id NOT IN (SELECT id_prestation FROM employe_prestation)";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(array($id_contrat));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $bdd = null;
    ConnexionBD::close();

    return $results;
}

function get_prestations(int $id_contrat)
{
    $bdd = ConnexionBD::openConnexion();
    $query = "select * from prestations where id_contrat=? ";
    $request = $bdd->prepare($query);
    $request->execute(array($id_contrat));
    $response = $request->fetchAll(PDO::FETCH_ASSOC);
    $bdd = null;
    ConnexionBD::close();
    return $response;
}


function mettre_a_jour_prix($id, $nouveau_prix, $nom_table)
{
    $bdd = ConnexionBD::openConnexion();

    $query = "UPDATE $nom_table SET prix = ? WHERE id = ?";
    $request = $bdd->prepare($query);
    $request->execute(array($nouveau_prix, $id));
    $bdd = null;
    ConnexionBD::close();
}

function get_user(string $username)
{
    $bdd = ConnexionBD::openConnexion();
    $query = 'select * from agentsdrh where nom_utilisateur=?';
    $request = $bdd->prepare($query);
    $request->execute(array($username));
    $response = $request->fetch(PDO::FETCH_ASSOC);
    $bdd = null;
    ConnexionBD::close();
    return $response;
}

function mettre_a_jour_etat_contrat(int $id_contrat, string $nouvel_etat)
{
    $bdd = ConnexionBD::openConnexion();

    $query = "UPDATE contrats SET etat_contrat = ? WHERE id = ?";
    $request = $bdd->prepare($query);
    $request->execute(array($nouvel_etat, $id_contrat));

    $bdd = null;
    ConnexionBD::close();
}

function get_competences_employe(int $id_employe)
{
    $bdd = ConnexionBD::openConnexion();
    $query = "select * from competences where id 
in (
 select id_competence from competence_employe
 where id_employe=?
)";
    $request = $bdd->prepare($query);
    $request->execute(array($id_employe));
    $response = $request->fetchAll(PDO::FETCH_ASSOC);
    $bdd = null;
    ConnexionBD::close();
    return $response;
}
function get_competence_prestation($prestation)
{
    $bdd = ConnexionBD::openConnexion();
    $query = "select * from competences where id=?";
    $request = $bdd->prepare($query);
    $request->execute(array($prestation['id_competence']));
    $response = $request->fetch(PDO::FETCH_ASSOC);
    $bdd = null;
    ConnexionBD::close();
    return $response;
}
function mettre_a_jour_login(int $id_user,string $type,string $new_data)
{
    $bdd = ConnexionBD::openConnexion();
    $query = "UPDATE agentsdrh SET $type = ? WHERE id=?";
    $request = $bdd->prepare($query);
    $request->execute(array($new_data,$id_user));
    $bdd = null;
    ConnexionBD::close();
}
function data_exists(string $data,string $value)
{
    $bdd = ConnexionBD::openConnexion();
    $query = "select * from agentsdrh where $data=?";
    $request = $bdd->prepare($query);
    $request->execute(array($value));
    $response = $request->fetch(PDO::FETCH_ASSOC);
    $bdd = null;
    ConnexionBD::close();
    return $response;
}
function inserer_date_prestation($id, $date_debut, $date_fin)
{
    $bdd = ConnexionBD::openConnexion();

    $query = "UPDATE prestations SET date_debut = ?, date_fin = ? WHERE id = ?";

    $request = $bdd->prepare($query);

    $request->execute(array($date_debut, $date_fin, $id));

    $bdd = null;

    ConnexionBD::close();
}
function get_etat_contrat($id_contrat)
{
    $bdd = ConnexionBD::openConnexion();
    $query = "select etat_contrat from contrats where id=?";
    $request = $bdd->prepare($query);
    $request->execute(array($id_contrat));
    $response = $request->fetch(PDO::FETCH_ASSOC);
    $bdd = null;
    ConnexionBD::close();
    return $response['etat_contrat'];
}