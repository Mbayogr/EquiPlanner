<?php

class Database {
    public static function getConnection() {
        $host = 'localhost';
        $dbname = 'db_equiplanner'; // À adapter
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
