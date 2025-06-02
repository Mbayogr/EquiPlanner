<!--
    ETML
    auteur : Gregory Mbayo
    Date : 02.05.25
    Description :page vue du site web Equiplanner permetant d'afficher l'historique des réservations des utilisateurs.
-->
<!DOCTYPE html>
<html>
<head>
    <title>Mes réservations</title>

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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2em;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #444;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .status {
            padding: 0.5em 1em;
            border-radius: 15px;
            font-weight: bold;
            color: white;
        }

        .status.active {
            background-color: #3498db;
        }

        .status.terminée {
            background-color: #2ecc71;
        }

        .status.annulée {
            background-color: #e74c3c;
        }
        h1 {
            text-align: center;
            margin-bottom: 1.5em;
        }
    </style>
</head>
<body>
<?php
// Vérifie si l'utilisateur est connecté (présence de user_id en session)
// Si non connecté, redirige vers la page d'accueil (index.php)
if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
    exit();
}
// Récupère la page courante à partir du paramètre GET page, ou home par défaut
$current = $_GET['page'] ?? 'home';
?>

<header>
    <nav>
        <a href="index.php?page=home" class="<?= $current === 'home' ? 'active' : '' ?>">Accueil</a>
        <a href="index.php?page=resourceChoice" class="<?= $current === 'resourceChoice' ? 'active' : '' ?>">Réserver</a>
        <a href="index.php?page=history" class="<?= $current === 'history' ? 'active' : '' ?>">Mes réservations</a>
        <a href="index.php?page=logout">Déconnexion</a>
    </nav>
</header>

<main>
    <h1>Mes réservations</h1>
    <!-- Paragraphe affichant la date et l'heure courantes, mis à jour par JavaScript -->
<p id="current-time" style="text-align:center; font-size:1.1em; margin-bottom: 1.5em;"></p>

    <!-- Affiche un message de succès si une réservation a été annulée avec succès -->
    <?php if (isset($_GET['success_cancel']) && $_GET['success_cancel'] == 1): ?>
        <div id="success-message" style="
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        ">
            ✅ Votre réservation a bien été annulée.
        </div>
    <?php endif; ?>

        <!-- Si aucune réservation n'est trouvée, affiche un message informatif -->
    <?php if (empty($reservations)): ?>
        <p>Vous n'avez encore effectué aucune réservation.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Ressource</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $res): ?>
                <tr>
                    <td><?= htmlspecialchars($res['resource_name']) ?></td>
                    <td><?= htmlspecialchars($res['date_']) ?></td>
                    <td><?= htmlspecialchars($res['hour_']) ?></td>

                    <!-- Affiche le statut avec une classe CSS dynamique selon le statut -->
                    <td><span class="status <?= htmlspecialchars($res['status']) ?>"><?= htmlspecialchars($res['status']) ?></span></td>
                    <td>
                        <!-- Si la réservation est active, affiche un bouton pour l'annuler -->
                        <?php if ($res['status'] === 'active'): ?>
                            <form method="POST" action="index.php?page=cancelReservation" style="margin:0;">
                                <input type="hidden" name="reservation_id" value="<?= $res['reservation_id'] ?>">
                                <button type="submit" onclick="return confirm('Annuler cette réservation ?')">Annuler</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; 2025 - EquiPlanner - Gregory Mbayo</p>
</footer>
<!-- Script pour masquer automatiquement le message de succès après 4 secondes -->
<script>
    setTimeout(() => {
        const msg = document.getElementById('success-message');
        if (msg) msg.style.display = 'none';
    }, 4000); // 4 secondes
</script>

</body>
<!-- Script JavaScript qui met à jour l'affichage de la date et heure toutes les minutes -->
<script>
function updateTime() {
    const now = new Date();
    const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
    const dateStr = now.toLocaleDateString('fr-FR', options);
    const timeStr = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });

    document.getElementById('current-time').textContent = `Nous sommes le ${dateStr} à ${timeStr}`;
}

updateTime();
setInterval(updateTime, 60000);
</script>
</html>
