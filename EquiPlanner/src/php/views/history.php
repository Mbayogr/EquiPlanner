<!DOCTYPE html>
<html>
<head><title>Mes réservations</title>
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




session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
    exit();
}
?>

<body>

<header>
    <?php
$current = $_GET['page'] ?? 'home';
?>
    <nav>
        <a href="home.php?page=home"class="<?= $current === 'home' ? 'active' : '' ?>">Accueil</a>
        <a href="resourceChoice.php?page=resourceChoice"class="<?= $current === 'resourceChoice' ? 'active' : '' ?>">Réserver</a>
        <a href="history.php?page=mesReservation"class="<?= $current === 'history' ? 'active' : '' ?>">Mes réservations</a>
        <a href="index.php?page=logout">Déconnexion</a>
    </nav>
</header>
<main>
 <h1>Mes réservation</h1>


        

     
    </main>

<footer>
    <p>&copy; 2025 - EquiPlanner - Gregory Mbayo</p>
</footer>

</body>
</html>



