<?php
// session_start(); // Décommente si ce n'est pas déjà fait avant l'inclusion

?>
<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
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

        /* Modal styles */
        .modal {
            display: block; /* affichée par défaut si erreur */
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
        <div id="loginErrorModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <p>❌ <?= htmlspecialchars($_SESSION['login_error']) ?></p>
            </div>
        </div>
        <?php unset($_SESSION['login_error']); ?>
        <?php endif; ?>

        <form action="index.php?page=login" method="POST">
            <label>Email : <input type="email" name="email" required></label><br>
            <label>Mot de passe : <input type="password" name="password" required></label><br>
            <button type="submit">Connexion</button>
        </form>
    </div>

<script>
function closeModal() {
    const modal = document.getElementById("loginErrorModal");
    if(modal) {
        modal.style.display = "none";
    }
}
</script>
</body>
</html>
