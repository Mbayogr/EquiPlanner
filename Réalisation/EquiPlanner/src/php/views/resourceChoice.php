<!--
    ETML
    auteur : Gregory Mbayo
    Date : 02.05.25
    Description :page vue du site web Equiplanner permetant d'afficher la page de choix des ressources du site.
-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix de l'équipement</title>
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

        nav a.active {
            background-color: #555;
            padding: 1em 2em;
            border-radius: 4px;
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
            margin-top: 2em;
        }

        .types {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1.5em;
        }

        .type-card {
            width: 200px;
            height: 150px;
            border-radius: 8px;
            overflow: hidden;
            text-align: center;
            background-size: cover;
            background-position: center;
            position: relative;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .type-card:hover {
            transform: scale(1.05);
        }

        .type-card a {
            text-decoration: none;
            font-weight: bold;
            display: block;
            color: white;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2em;
        }

        h1 {
            text-align: center;
            margin-bottom: 1.5em;
        }
    </style>
</head>
<?php
// Vérifie si l'utilisateur est connecté, sinon le redirige vers la page d'accueil
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
// Récupère la page actuelle depuis l'URL, ou home par défaut
$current = $_GET['page'] ?? 'home';

// Tableau associatif qui relie chaque type de ressource à une image
$imageMap = [
     'terrain' => '/EquiPlanner/ressource/images/terrain.jpg',
    'ballon'  => '/EquiPlanner/ressource/images/ballon.jpg',
    'filet'   => '/EquiPlanner/ressource/images/filet.jpg',
    'goal'    => '/EquiPlanner/ressource/images/goal.jpg',
    'piquet'  => '/EquiPlanner/ressource/images/piquet.jpg',
    'canne'   => '/EquiPlanner/ressource/images/canne.jpg',
];
?>
<body>

<!-- En-tête avec le menu de navigation -->
<header>
    <nav>
        <a href="index.php?page=home" class="<?= $current === 'home' ? 'active' : '' ?>">Accueil</a>
        <a href="index.php?page=resourceChoice" class="<?= in_array($current, ['resourceChoice', 'reserve']) ? 'active' : '' ?>">Réserver</a>
        <a href="index.php?page=history" class="<?= $current === 'history' ? 'active' : '' ?>">Mes réservations</a>
        <a href="index.php?page=logout">Déconnexion</a>
    </nav>
</header>

<main>
    <h1>Choisissez un type de ressource</h1>

    <!-- Conteneur pour les différentes cartes de types de ressources -->
    <div class="types">
        <?php if (!empty($types)): ?>
            <?php foreach ($types as $type): 
                $key = strtolower($type['type']);
                $image = $imageMap[$key] ?? '/EquiPlanner/ressource/images/default.jpg';
            ?>
                <!-- Carte de type de ressource avec image de fond -->
                <div class="type-card" style="background-image: url('<?= $image ?>');">
                    <!-- Lien vers la page de réservation pour ce type -->
                    <a href="index.php?page=reserve&type=<?= urlencode($type['type']) ?>">
                        <?= htmlspecialchars($type['type']) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Message si aucun type de ressource n'est disponible -->
            <p>Aucune ressource disponible.</p>
        <?php endif; ?>
    </div>
</main>
<!-- Footer-->
<footer>
    <p>&copy; 2025 - EquiPlanner - Gregory Mbayo</p>
</footer>

</body>
</html>
