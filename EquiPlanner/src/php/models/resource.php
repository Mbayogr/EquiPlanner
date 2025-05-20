<?php

class ResourceModel {
    private $db;

    public function __construct() {
        require_once 'models/Database.php';
        $this->db = Database::getConnection();
    }

    // Récupère tous les types de ressources distincts
 

        public function getAllTypes() {
        $this->db = Database::getConnection();
        $stmt = $this->db->query("SELECT DISTINCT type FROM t_resource");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>