<!--
    ETML
    auteur : Gregory Mbayo
    Date : 02.05.25
    Description :Page vue du site web Equiplanner permetant d'afficher l'acceuil du site.
-->
<!DOCTYPE html>
<html>
<head><title>Accueil</title>

    <!--css-->
<style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        h1 {
            text-align: center;
            margin-bottom: 1.5em;
        }

        header {
            background: #333;
            color: white;
            padding: 3em;
            text-align: center;
        }

        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }

        main {
            flex: 1; 
            padding: 2em;
        }

        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 1em;
        }

        nav a.active {
            background-color: #555;
            padding: 1em 2em;
            border-radius: 4px;
        }
    </style>
    </head>
</html>
<?php
//session_start();
// Vérifie si l'utilisateur est connecté via la variable de session 'user_id'
// Sinon, redirige vers la page d'accueil (index.php)
if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
    exit();
}
?>

<body>

<header>
    <?php
// Récupère le nom de la page courante via le paramètre GET 'page', ou 'home' par défaut
$current = $_GET['page'] ?? 'home';
?>
    <nav>
        <!-- Menu avec classe active sur le lien correspondant à la page courante -->
        <a href="index.php?page=home"class="<?= $current === 'home' ? 'active' : '' ?>">Accueil</a>
        <a href="index.php?page=resourceChoice"class="<?= $current === 'resourceChoice' ? 'active' : '' ?>">Réserver</a>
        <a href="index.php?page=history"class="<?= $current === 'history' ? 'active' : '' ?>">Mes réservations</a>
        <a href="index.php?page=logout">Déconnexion</a>
    </nav>
</header>
<main>
    <!-- Affiche un message de bienvenue personnalisé avec le prénom de l'utilisateur -->
    <h1>Bienvenue <?php echo htmlspecialchars($_SESSION['firstname']);?></h1>
</main>
    <!-- Footer -->
<footer>
    <p>&copy; 2025 - EquiPlanner - Gregory Mbayo</p>
</footer>

</body>
</html>






