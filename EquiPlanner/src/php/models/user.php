<?php
require_once 'database.php';

class User {
    public static function authenticate($email, $password){
        $db = database::getConnection();
        $stmt = $db->prepare("SELECT * FROM t_user WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $email = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($email && password_verify($password,$email['password'])){
            return $email;
        }
        return false;
    }
}
?>