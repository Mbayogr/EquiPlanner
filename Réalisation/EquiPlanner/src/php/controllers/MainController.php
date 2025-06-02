<!--
    ETML
    auteur : Gregory Mbayo
    Date : 02.05.25
    Description :page Controleur du site web Equiplanner 
-->
<?php
class MainController {

    // Cette fonction gère la connexion de l'utilisateur
    public function login() {
        require_once __DIR__ . '/../models/Database.php';

        // Récupération des données envoyées via le formulaire de connexion (méthode POST)
        $email = $_POST['email'];
        $password = $_POST['password'];

        $db = Database::getConnection();
        // Préparation et execution de la requête SQL pour sélectionner l'utilisateur correspondant à l'email fourni
        $stmt = $db->prepare("SELECT * FROM t_user WHERE email = :email");
        $stmt->execute(['email' => $email]);
        // Récupération des données de l'utilisateur sous forme de tableau associatif
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification que l'utilisateur existe et que le mot de passe fourni correspond à celui stocké (haché)
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['firstname'] = $user['firstname'];
            // Redirection vers la page d'accueil après une connexion réussie
            header('Location: index.php?page=home');
            exit();
        } else {
            // Si la connexion échoue, stockage d'un message d'erreur dans la session
            $_SESSION['login_error'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
            // Redirection vers la page de connexion
            header('Location: index.php?page=login');
            exit();
        }
    }

    // Affiche le formulaire de connexion à l'utilisateur.
    public function showLoginForm() {
        $this->renderView('login');
    }

    // Cette fonction sert à afficher les vue
    public function renderView($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }
    // Cette fonction prépare et affiche la page de choix des types de ressources.
    public function resourceChoice() {
        require_once __DIR__ . '/../models/Resource.php';
        $model = new ResourceModel();
        $types = $model->getAllTypes();
        $this->renderView('resourceChoice', ['types' => $types]);
    }

    // cette fonction permet d'afficher la page de réservation et gère les réservations.
    public function reserve() {
        if (!isset($_GET['type'])) {
            echo "Type non spécifié.";
            return;
        }

        $type = $_GET['type'];
        $date = $_GET['selected_date'] ?? null;
        $time = $_GET['selected_time'] ?? null;

        require_once __DIR__ . '/../models/Resource.php';
        require_once __DIR__ . '/../models/Reservation.php';

        $model = new ResourceModel();
        $reservationModel = new ReservationModel();

        $reservationModel->updateExpiredReservations();

        if ($date && $time) {
            $resources = $model->getAvailableResources($type, $date, $time);
        } else {
            $resources = $model->getResourcesByType($type);
        }

        $this->renderView('reserve', [
            'resources' => $resources,
            'type' => $type,
            'selected_date' => $date,
            'selected_time' => $time
        ]);
    }
    // Cette fonction traite la soumission du formulaire de réservation.
    public function confirmReservation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../models/Reservation.php';
            require_once __DIR__ . '/../models/Resource.php';

            $model = new ReservationModel();
            $resourceModel = new ResourceModel();

            $user_id = $_SESSION['user_id'];
            $resource_id = $_POST['resource_id'];
            $date = $_POST['selected_date'];
            $time = $_POST['selected_time'];
            $type = $_POST['type'];

            $selectedDateTime = DateTime::createFromFormat('Y-m-d H:i', $date . ' ' . $time);
            $now = new DateTime();

            if ($selectedDateTime < $now) {
                $error = "Vous ne pouvez pas réserver dans le passé.";
                $resources = $resourceModel->getResourcesByType($type);

                $this->renderView('reserve', [
                    'resources' => $resources,
                    'type' => $type,
                    'selected_date' => $date,
                    'selected_time' => $time,
                    'error' => $error
                ]);
                return;
            }

            //  Création de la réservation
            $model->createReservation($user_id, $resource_id, $date, $time);

            header("Location: index.php?page=reserve&type=" . urlencode($type) . "&selected_date=" . urlencode($date) . "&selected_time=" . urlencode($time) . "&success=1");
            exit();
        }
    }

    // Affiche l'historique des réservations de l'utilisateur connecté.
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
    // Cette méthode annule une réservation existante.
    public function cancelReservation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservation_id'])) {
            require_once __DIR__ . '/../models/Reservation.php';
            $reservationModel = new ReservationModel();

            $reservationId = $_POST['reservation_id'];
            $reservationModel->cancelReservationById($reservationId);
        }

        header("Location: index.php?page=history&success_cancel=1");
        exit();
    }
    // Cette méthode déconnecte l'utilisateur de la session.
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php?page=login');
        exit();
    }
}
