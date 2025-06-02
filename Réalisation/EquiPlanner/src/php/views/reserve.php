<!--
    ETML
    auteur : Gregory Mbayo
    Date : 02.05.25
    Description :page vue du site web Equiplanner permetant d'afficher la page de réservation du site.
-->
<!DOCTYPE html>
<html>
<head>
    <title>Réservations</title>
    <!--css-->
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
            padding: 2em;
            min-height: 70vh;
        }

        header {
            background-color: #333;
            padding: 3em;
            color: white;
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

        h1 {
            text-align: center;
            margin-bottom: 1.5em;
        }

        form.filter-form {
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 15px 20px;
            max-width: 450px;
            margin: 0 auto 30px auto;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
            justify-content: center;
        }

        form.filter-form label {
            font-weight: bold;
            margin-right: 8px;
            min-width: 80px;
        }

        form.filter-form input[type="date"],
        form.filter-form input[type="time"] {
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
        }

        form.filter-form button {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.25s;
        }

        form.filter-form button:hover {
            background-color: #0056b3;
        }

        .resource-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .resource-card {
            background-color: #f5f5f5;
            padding: 1em;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 250px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .resource-card:hover {
            transform: scale(1.05);
        }

        .resource-name {
            font-size: 1.2em;
            font-weight: bold;
            color: #222;
        }

        .resource-status {
            margin-top: 10px;
            padding: 5px 10px;
            display: inline-block;
            border-radius: 5px;
            font-weight: bold;
        }

        .available {
            background-color: #d4edda;
            color: #155724;
        }

        .unavailable {
            background-color: #f8d7da;
            color: #721c24;
        }

        .modal {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            padding: 2em 3em;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.25);
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
        }

        #closeModalBtn {
            margin-top: 1em;
            padding: 0.5em 1.2em;
            font-size: 1em;
            cursor: pointer;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            transition: background-color 0.2s;
        }

        #closeModalBtn:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1em;
        }
    </style>
</head>

<?php
// session_start();
// Vérifie si l'utilisateur est connecté, sinon redirige vers la page d'accueil
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
// Récupère la page actuelle depuis l'URL, ou utilise le nom du fichier par défaut
$current = $_GET['page'] ?? basename(__FILE__, '.php');
?>

<body>
<!-- En-tête contenant le menu de navigation -->
<header>
    <nav>
        <a href="index.php?page=home" class="<?= $current === 'home' ? 'active' : '' ?>">Accueil</a>
        <a href="index.php?page=resourceChoice" class="<?= in_array($current, ['resourceChoice', 'reserve']) ? 'active' : '' ?>">Réserver</a>
        <a href="index.php?page=history" class="<?= $current === 'history' ? 'active' : '' ?>">Mes réservations</a>
        <a href="index.php?page=logout">Déconnexion</a>
    </nav>
</header>

<main>
<!-- Affiche une alerte si une erreur est présente -->
<?php if (!empty($error)): ?>
<script>
    alert("<?= htmlspecialchars($error) ?>");
</script>
<?php endif; ?>
<!-- Affiche un message de confirmation après réservation réussie -->
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
<div id="confirmationModal" class="modal">
  <div class="modal-content">
    <p>Réservation effectuée avec succès !</p>
    <button id="closeModalBtn">Fermer</button>
  </div>
</div>
<?php endif; ?>

<h1>Ressources disponibles pour : <?= htmlspecialchars($type) ?></h1>
<!-- Formulaire pour filtrer les ressources par date et heure -->
<form method="GET" action="index.php" class="filter-form">
    <input type="hidden" name="page" value="reserve">
    <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">

    <label for="selected_date">Date :</label>
    <input type="date" name="selected_date" id="selected_date_input" required min="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($_GET['selected_date'] ?? '') ?>">

    <label for="selected_time">Heure :</label>
    <input type="time" name="selected_time" id="selected_time_input" required value="<?= htmlspecialchars($_GET['selected_time'] ?? '') ?>">

    <button type="submit">Filtrer</button>
</form>

<!-- Conteneur pour afficher les cartes de ressources -->
<div class="resource-container">
    <?php if (!empty($resources)): ?>
        <?php foreach ($resources as $res): ?>
            <div class="resource-card">
                <div class="resource-name"><?= htmlspecialchars($res['name']) ?></div>
                <div class="resource-status <?= $res['available'] ? 'available' : 'unavailable' ?>">
                    <?= $res['available'] ? 'Disponible' : 'Indisponible' ?>
                </div>

                <?php if ($res['available']): ?>
                <form method="POST" action="index.php?page=confirmReservation">
                    <input type="hidden" name="resource_id" value="<?= htmlspecialchars($res['resource_id']) ?>">
                    <input type="date" name="selected_date" required value="<?= htmlspecialchars($_GET['selected_date'] ?? '') ?>">
                    <input type="time" name="selected_time" required value="<?= htmlspecialchars($_GET['selected_time'] ?? '') ?>">
                    <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">
                    <button type="submit">Réserver</button>
                </form>
                <?php else: ?>
                    <!-- Message si la ressource est déjà réservée -->
                    <p style="color: red;">Déjà réservé</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- Message si aucune ressource n'est disponible -->
        <p>Aucune ressource disponible pour ce type.</p>
    <?php endif; ?>
</div>

</main>
        <!-- Footer-->
<footer>
    <p>&copy; 2025 - EquiPlanner - Gregory Mbayo</p>
</footer>

<!-- Script JavaScript pour gérer le modal et la validation de l'heure -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('confirmationModal');
    const closeBtn = document.getElementById('closeModalBtn');

    if (modal && closeBtn) {
        closeBtn.addEventListener('click', function () {
            modal.style.display = 'none';

            const url = new URL(window.location.href);
            url.searchParams.delete('success');
            window.history.replaceState({}, document.title, url.toString());
        });
    }

    const dateInput = document.getElementById('selected_date_input');
    const timeInput = document.getElementById('selected_time_input');

    if (dateInput) {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const todayStr = `${yyyy}-${mm}-${dd}`;

        dateInput.min = todayStr;
        
        // Fonction pour ajuster l'heure minimale si la date sélectionnée est aujourd'hui
        function updateTimeMin() {
            const selectedDate = dateInput.value;
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const currentTime = `${hours}:${minutes}`;

            if (selectedDate === todayStr) {
                timeInput.min = currentTime;
            } else {
                timeInput.removeAttribute('min');
            }
        }

        updateTimeMin();
        dateInput.addEventListener('change', updateTimeMin);
    }
});
</script>

</body>
</html>
