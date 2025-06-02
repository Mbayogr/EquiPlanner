<!--
    ETML
    auteur : Gregory Mbayo
    Date : 02.05.25
    Description :page index du site web Equiplanner permetant de redirger vers les différentes vue.
-->
<?php
/*session_start();
echo 'Session : ' . ($_SESSION['user_id'] ?? 'non connectée') . '<br>';
echo 'Page : ' . ($_GET['page'] ?? 'home') . '<br>';
exit;*/
session_start();  

require_once __DIR__ . '/controllers/MainController.php';

$controller = new MainController();

// Récupérer la page demandée, ou "home" par défaut
$page = $_GET['page'] ?? 'home';

$protectedPages = ['home', 'resourceChoice', 'reserve', 'confirmReservation', 'history', 'cancelReservation'];

if (in_array($page, $protectedPages) && !isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}
//redirige et affiche les vues
switch ($page) {
    case 'login':
            if (isset($_SESSION['user_id'])) {
        
        header('Location: index.php?page=home');
        exit();
    }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();  
        } else {
            $controller->showLoginForm();  
        }
        break;

    case 'resourceChoice':
        $controller->resourceChoice();
        break;

    case 'reserve':
        $controller->reserve();
        break;

    case 'confirmReservation':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->confirmReservation();
        } else {
            header('Location: index.php?page=resourceChoice');
            exit();
        }
        break;

    case 'history':
        $controller->history();
        break;

    case 'logout':
        session_destroy();
        header('Location: index.php?page=login');
        exit();
        break;

    case 'cancelReservation':
        $controller->cancelReservation();
        break;

    case 'home':
    default:
        $controller->renderView('home');
        break;

    case 'logout':
        $controller->logout();
        break;

}
