<!--
    ETML
    auteur : Gregory Mbayo
    Date : 02.05.25
    Description :page modèle du site web Equiplanner permetant la connexion à la base de données
-->
<?php
class Database {
    // Cette méthode permet de se connecter à la base de données
    public static function getConnection() {
        $host = 'localhost';
        $dbname = 'db_equiplanner'; 
        $username = 'mbayogr';
        $password = 'M12345';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}
?>
