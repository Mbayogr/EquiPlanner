<?php class ReservationModel {
    private $db;

    public function __construct() {
        require_once 'database.php';
        $this->db = Database::getConnection();
    }

    public function createReservation($user_id, $resource_id, $date, $time) {
        try {
            $stmt = $this->db->prepare("INSERT INTO t_reservation (date_, hour_, resource_fk, user_fk, status) VALUES (:date, :time, :resource_id, :user_id, 'active')");
            $stmt->execute([
                'date' => $date,
                'time' => $time,
                'resource_id' => $resource_id,
                'user_id' => $user_id
            ]);
        } catch (PDOException $e) {
            echo "Erreur d'insertion : " . $e->getMessage();
        }
    }




public function updateExpiredReservations() {
    $db = Database::getConnection();

    // Seuil : maintenant - 1 heure, au format MySQL DATETIME
    $datetimeThreshold = (new DateTime())->modify('-1 hour')->format('Y-m-d H:i:s');

    // STR_TO_DATE permet de forcer la lecture correcte des champs date_ et hour_
    $query = "SELECT reservation_id, resource_fk FROM t_reservation 
              WHERE status = 'active' 
              AND STR_TO_DATE(CONCAT(date_, ' ', hour_), '%Y-%m-%d %H:%i:%s') <= :threshold";

    $stmt = $db->prepare($query);
    $stmt->execute(['threshold' => $datetimeThreshold]);
    $expiredReservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($expiredReservations as $res) {
        // Met à jour la réservation terminée
        $updateReservation = $db->prepare("UPDATE t_reservation SET status = 'terminée' WHERE reservation_id = :id");
        $updateReservation->execute(['id' => $res['reservation_id']]);

        // Rend la ressource à nouveau disponible
        $updateResource = $db->prepare("UPDATE t_resource SET available = 1 WHERE resource_id = :resource_id");
        $updateResource->execute(['resource_id' => $res['resource_fk']]);
    }
}


public function getUserReservations($userId) {
    try {
        $stmt = $this->db->prepare("
            SELECT r.*, t.name AS resource_name
            FROM t_reservation r
            JOIN t_resource t ON r.resource_fk = t.resource_id
            WHERE r.user_fk = :user_id
            ORDER BY r.date_ DESC, r.hour_ DESC
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}


public function cancelReservationById($reservationId) {
    try {
        // Annule la réservation
        $stmt = $this->db->prepare("UPDATE t_reservation SET status = 'annulée' WHERE reservation_id = :id");
        $stmt->execute(['id' => $reservationId]);

        // Rendre la ressource à nouveau disponible
        $stmt2 = $this->db->prepare("
            UPDATE t_resource 
            SET available = 1 
            WHERE resource_id = (
                SELECT resource_fk FROM t_reservation WHERE reservation_id = :id
            )
        ");
        $stmt2->execute(['id' => $reservationId]);

    } catch (PDOException $e) {
        echo "Erreur lors de l'annulation : " . $e->getMessage();
    }
}

}
?>