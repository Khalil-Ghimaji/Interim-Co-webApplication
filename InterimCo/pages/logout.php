<?php
unset($_SESSION['authenticated_user']);
$_SESSION['msg']="Déconnecté avec succès";
$_SESSION['msg_type']="success";
header('Location:/');
exit;