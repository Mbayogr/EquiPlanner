<?php

class ResourceModel {
    private $db;

    public function __construct() {
        require_once __DIR__ . '/Database.php';
        $this->db = Database::getConnection();
    }

    public function getAllTypes() {
        try {
            $stmt = $this->db->prepare("SELECT DISTINCT type FROM t_resource");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Erreur SQL : " . $e->getMessage();
            return [];
        }
    }

    public function getResourcesByType($type) {
    $stmt = $this->db->prepare("SELECT * FROM t_resource WHERE type = :type");
    $stmt->execute(['type' => $type]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



public function getAvailableResources($type, $date, $time) {
    try {
        $stmt = $this->db->prepare("
            SELECT r.* FROM t_resource r
            WHERE r.type = :type
            AND r.available = 1
            AND r.resource_id NOT IN (
                SELECT resource_fk FROM t_reservation 
                WHERE date_ = :date AND hour_ = :time AND status = 'active'
            )
        ");
        $stmt->execute([
            'type' => $type,
            'date' => $date,
            'time' => $time
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}
}
