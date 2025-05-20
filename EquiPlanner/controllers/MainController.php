<?php
//require_once __DIR__ . '/../models/User.php';
//session_start();
class MainController {

    public function login() {
        require_once __DIR__ . '/../models/Database.php';

        $email = $_POST['email'];
        $password = $_POST['password'];

        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM t_user WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['firstname'] = $user['firstname'];
            header('Location: index.php?page=home');
            exit();
        } else {
            echo "<p style='color:red;'>Nom d'utilisateur ou mot de passe incorrect.</p>";
            echo "<a href='index.php?page=login'><button>Retour</button></a>";
        }
    }

    public function renderView($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }

    public function resourceChoice() {
        require_once __DIR__ . '/../models/Resource.php';
        $model = new ResourceModel();
        $types = $model->getAllTypes();
        $this->renderView('resourceChoice', ['types' => $types]);
    }


   public function reserve() {
    if (!isset($_GET['type'])) {
        echo "Type non spécifié.";
        return;
    }

    $type = $_GET['type'];
    $date = $_GET['selected_date'] ?? null;
    $time = $_GET['selected_time'] ?? null;

    // Inclure les modèles nécessaires
    require_once __DIR__ . '/../models/Resource.php';
    require_once __DIR__ . '/../models/Reservation.php';

    // Instancier les modèles
    $model = new ResourceModel();
    $reservationModel = new ReservationModel();

    // Mettre à jour les réservations expirées
    $reservationModel->updateExpiredReservations();

    // Récupérer les ressources disponibles selon date/heure
    if ($date && $time) {
        $resources = $model->getAvailableResources($type, $date, $time);
    } else {
        $resources = $model->getResourcesByType($type);
    }

    // Afficher la vue
    $this->renderView('reserve', [
        'resources' => $resources,
        'type' => $type,
        'selected_date' => $date,
        'selected_time' => $time
    ]);
}

public function confirmReservation() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once __DIR__ . '/../models/Reservation.php';
        $model = new ReservationModel();
       // $reservationModel->updateExpiredReservations();
 
        $user_id = $_SESSION['user_id'];
        $resource_id = $_POST['resource_id'];
        $date = $_POST['selected_date'];
        $time = $_POST['selected_time'];
        $type = $_POST['type'];

        // Créer la réservation
        $model->createReservation($user_id, $resource_id, $date, $time);

        // Redirection vers reserve avec paramètres et success=1
        header("Location: index.php?page=reserve&type=" . urlencode($type) . "&selected_date=" . urlencode($date) . "&selected_time=" . urlencode($time) . "&success=1");
        exit();
    }
}

public function history() {
    if (!isset($_SESSION['user_id'])) {
        echo "Vous devez être connecté pour voir l'historique.";
        return;
    }

    $userId = $_SESSION['user_id'];

    require_once __DIR__ . '/../models/Reservation.php';
    $reservationModel = new ReservationModel();
    $reservations = $reservationModel->getUserReservations($userId);

    $this->renderView('history', [
        'reservations' => $reservations
    ]);
}

public function cancelReservation() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservation_id'])) {
        require_once __DIR__ . '/../models/Reservation.php';
        $reservationModel = new ReservationModel();

        $reservationId = $_POST['reservation_id'];
        $reservationModel->cancelReservationById($reservationId);
    }

    // Retour à l'historique après annulation
    header("Location: index.php?page=history&success_cancel=1");
    exit();
}

}
