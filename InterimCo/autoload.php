<?php
function autoloader($name) {
    require_once "class/$name.php";
}
spl_autoload_register("autoloader");