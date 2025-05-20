<?php

/*session_start();
require_once '../controllers/mainController.php';
$controller = new mainController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->login();
} else {
    include 'login.php'; // formulaire
}*/









/*session_start();
require_once '../controllers/MainController.php';

$controller = new MainController();

// Si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    $page = $_GET['page'] ?? 'home'; // Par défaut : home

    if ($page === 'resourceChoice') {
        $controller->resourceChoice();
    } else {
        require_once 'home.php';
    }
} else {
    // Pas connecté : montre la page de login
    require_once 'login.php';
}
*/





session_start();
require_once 'controllers/MainController.php';

$controller = new MainController();

// Récupère la page demandée ou par défaut 'login'
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

// Gestion spéciale de la déconnexion
if ($page === 'logout') {
    session_unset();
    session_destroy();
    header('Location: index.php?page=login');
    exit;
}

// Redirection vers login si pas connecté et page protégée
$protectedPages = ['home', 'resourceChoice']; // ajoute d'autres pages si besoin
if (!isset($_SESSION['user_id']) && in_array($page, $protectedPages)) {
    header('Location: index.php?page=login');
    exit;
}

// Appel de la méthode correspondante dans le contrôleur
switch ($page) {
    case 'login':
        $controller->loginForm(); // affiche juste le formulaire de login
        break;
    case 'doLogin':
        $controller->login(); // traite le formulaire
        break;
    case 'home':
        $controller->home();
        break;
    case 'resourceChoice':
        $controller->resourceChoice();
        break;
    // Ajoute d'autres pages ici...
    default:
        echo "Page inconnue.";
}
?>