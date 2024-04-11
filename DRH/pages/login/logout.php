<?php
session_start();
unset($_SESSION['authenticated_drh']);
header("Location:/");
exit;
