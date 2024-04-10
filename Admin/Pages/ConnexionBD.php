<?php

class ConnexionBD
{
    private static $_dbname = "Interim";
    private static $_user = "postgres";
    private static $_pwd = "khalil2004";
    private static $_host = "localhost";
    private static $_bdd = null;

    private function __construct()
    {
        try {
            self::$_bdd = new PDO("pgsql:host=" . self::$_host . ";dbname=" . self::$_dbname, self::$_user, self::$_pwd);
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public static function openConnexion()
    {
        if (!self::$_bdd) {
            new ConnexionBD();
        }
        return (self::$_bdd);
    }
    public static function close()
    {
        self::$_bdd=null;
    }
}