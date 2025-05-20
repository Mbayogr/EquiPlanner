<?php
session_start();  // Très important : démarrer la session TOUT EN HAUT

require_once __DIR__ . '/controllers/MainController.php';

$controller = new MainController();

// Récupérer le paramètre 'page' dans l'URL, ex: index.php?page=history
$page = $_GET['page'] ?? 'home';

// En fonction de la page, appeler la méthode correspondante
switch ($page) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            $controller->renderView('login');
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
            exit;
        }
        break;

    case 'history':
        $controller->history();
        break;

    case 'logout':
        session_destroy();
        header('Location: index.php?page=login');
        exit;
        break;

    case 'home':
    default:
        $controller->renderView('home');
        break;

    case 'cancelReservation':
        require_once 'controllers/MainController.php';
        $controller = new MainController();
        $controller->cancelReservation();
        break;
}
