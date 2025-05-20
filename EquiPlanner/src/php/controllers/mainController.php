<?php
require_once 'models/user.php';

class MainController{


function login() {
    require_once 'models/database.php'; // 

    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = Database::getConnection(); // 
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
        echo "<a href=' ../views/index.php'><button>Retour</button></a>";
    }
}


protected function renderView($viewName, $data = []) {
    extract($data); 
    require_once "views/{$viewName}.php";
}

public function resourceChoice() {
    require_once 'models/resource.php';
    $model = new ResourceModel();
    $types = $model->getAllTypes();
    $this->renderView('resourceChoice',['types' => $types]);
}




public function loginForm() {
    $this->renderView('index'); // va chercher views/index.php
}


public function home() {
    $this->renderView('home'); // va chercher views/index.php
}






}







?>


