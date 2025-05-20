<?php

class Database {
    private static $host ='localhost';
    private static $dbname = 'db_equiplanner';
    private static $username = 'mbayogr';
    private static $password ='M12345';
    private static $conn = null;

    //Fonction pour la connexion PDO

    public static function getConnection() {
        if(self::$conn === null) {
            try {
                $dsn = 'mysql:host=' . self::$host. ';dbname=' . self::$dbname . ';charset=utf8';
                self::$conn = new PDO($dsn, self::$username, self:: $password);

                self::$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                            } catch(PDOException $e) {
                                die('Erreur de connexion à la base de données : ' . $e->getMessage());
                        
                            }
        }
                                    return self::$conn;

    }
}
?>