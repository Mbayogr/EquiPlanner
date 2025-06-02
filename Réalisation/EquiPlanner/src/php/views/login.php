<!--
    ETML
    auteur : Gregory Mbayo
    Date : 02.05.25
    Description :page vue du site web Equiplanner permetant d'afficher la page de login du site.
-->
<?php

?>
<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <!--css-->
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: white;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
            position: relative;
        }

        .login-box h2 {
            margin-bottom: 1em;
            text-align: center;
        }

        .login-box input[type="email"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 0.7em;
            margin: 0.5em 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-box button {
            width: 100%;
            padding: 0.7em;
            background: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }

        .modal {
            display: block; 
            position: fixed;
            z-index: 999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.6);
        }

        .modal-content {
            background-color: #fff;
            margin: 20% auto;
            padding: 2em;
            border: 1px solid #ccc;
            width: 300px;
            border-radius: 10px;
            text-align: center;
            position: relative;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            font-weight: bold;
            color: #c0392b;
        }

        .close {
            position: absolute;
            top: 10px; right: 15px;
            font-size: 20px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }

        .close:hover {
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Connexion</h2>

        <?php if (!empty($_SESSION['login_error'])): ?>
        <!-- Affiche un modal d'erreur si une erreur de login est présente dans la session -->
        <div id="loginErrorModal" class="modal">
            <div class="modal-content">
                <!-- Bouton pour fermer le modal -->
                <span class="close" onclick="closeModal()">&times;</span>
                <p>❌ <?= htmlspecialchars($_SESSION['login_error']) ?></p>
            </div>
        </div>
        <?php 
        // Supprime le message d'erreur de la session pour ne pas le réafficher
        unset($_SESSION['login_error']); ?>
        <?php endif; ?>
        <!-- Formulaire de connexion envoyé en POST à la page login -->
        <form action="index.php?page=login" method="POST">
            <label>Email : <input type="email" name="email" required></label><br>
            <label>Mot de passe : <input type="password" name="password" required></label><br>
            <button type="submit">Connexion</button>
        </form>
    </div>
<script>
// Fonction JavaScript pour cacher le modal d'erreur lorsqu'on clique sur la croix
function closeModal() {
    const modal = document.getElementById("loginErrorModal");
    if(modal) {
        modal.style.display = "none";
    }
}
</script>
</body>
</html>
