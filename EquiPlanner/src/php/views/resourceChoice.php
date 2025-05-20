<!DOCTYPE html>
<html>
<head><title>Choix de l'équipement</title>
   <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #333;
            padding: 20px;
            color: white;
            text-align: center;
        }

        nav {
            background-color: #444;
            display: flex;
            justify-content: center;
        }

        nav a {
            color: white;
            padding: 14px 20px;
            display: block;
            text-decoration: none;
        }

        nav a:hover,
        nav a.active {
            background-color: #666;
        }

        main {
            padding: 2em;
            min-height: 70vh;
        }

        h1 {
            text-align: center;
            margin-bottom: 1.5em;
        }

        .types {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1.5em;
        }

        .type-card {
            background-color: #f5f5f5;
            padding: 1em;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 200px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .type-card:hover {
            transform: scale(1.05);
        }

        .type-card a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .type-card a:hover {
            color: #007bff;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1em;
            margin-top: 2em;
        }
    </style>
    </head>
</html>
<?php


/*
if (!isset($types)){
    $types =[];
}*/

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
 <h1>Choisissez un type de ressource</h1>

<pre><?php var_dump($types); ?></pre>
        

       <div class="types">
            <?php  if (!empty($types)): ?>
                <?php foreach ($types as $type): ?>
                    <div class="type-card">
                        <a href="index.php?page=resourceList&type=<?= urlencode($type['type']) ?>">
                            <?= htmlspecialchars($type['type']) ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune ressource disponible.</p>
            <?php endif; ?>
        </div>
    </main>

<footer>
    <p>&copy; 2025 - EquiPlanner - Gregory Mbayo</p>
</footer>

</body>
</html>



