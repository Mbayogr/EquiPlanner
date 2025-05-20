<?php
session_start();
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
        }

        .login-box h2 {
            margin-bottom: 1em;
            text-align: center;
        }

        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 0.7em;
            margin: 0.5em 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-box input[type="submit"] {
            width: 100%;
            padding: 0.7em;
            background: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .error {
            color: red;
            margin-bottom: 1em;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Connexion</h2>

        <?php if (!empty($_SESSION['login_error'])): ?>
            <div class="error"><?= $_SESSION['login_error'] ?></div>
            <?php unset($_SESSION['login_error']); ?>
        <?php endif; ?>

        <form method="POST" action="index.php?page=doLogin">
            <input type="text" name="email" placeholder="Email" required><br><br>
            <input type="password" name="password" placeholder="Mot de passe" required><br><br>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>