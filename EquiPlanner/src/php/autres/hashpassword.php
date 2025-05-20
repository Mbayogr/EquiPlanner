<?php
require_once 'models/database.php';

try {
    // Connexion à la base de données
    $db = Database::getConnection();

    // Récupération de tous les utilisateurs
    $sql = "SELECT user_id, password FROM t_user";
    $result = $db->query($sql);

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $userId = $row['user_id'];
        $plainPassword = $row['password'];
        // Vérifie si le mot de passe est déjà haché
        $hashInfo = password_get_info($plainPassword);
        if (strlen($plainPassword)<60) { 
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

            // Mise à jour en base de données
            $updateSql = "UPDATE t_user SET password = :password WHERE user_id = :id";
            $updateStmt = $db->prepare($updateSql);
            $updateStmt->execute([
                'password' => $hashedPassword,
                'id' => $userId
            ]);

            echo "Mot de passe de l'utilisateur ID $userId haché avec succès.<br>";
        } else {
            echo "Utilisateur ID $userId : mot de passe déjà haché, ignoré.<br>";
        }
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}