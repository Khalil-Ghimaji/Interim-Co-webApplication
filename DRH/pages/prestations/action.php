<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];


        $id_employe = $_POST['id_employe'];
        $id_prestation = $_POST['id_prestation'];
        echo $id_prestation;
        echo $id_employe;
        switch ($action) {
            case 'ajouter':
                inserer_employe_prestation($id_employe, $id_prestation);
                break;
            case 'supprimer':
                supprimer_employe_prestation($id_employe, $id_prestation);
                break;
            default:
                break;
        }
        header("Location: /gestion_employes");
        exit();
    }
}
?>
