


<!DOCTYPE html>
<html>
<head><title>Réservations</title>
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


           .resource-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .resource-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            padding: 20px;
            width: 250px;
            transition: transform 0.2s;
        }

        .resource-card:hover {
            transform: scale(1.03);
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
    </style>
    </head>
</html>
<?php


/*
if (!isset($types)){
    $types =[];
}*/

//session_start();
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
        <a href="index.php?page=home"class="<?= $current === 'home' ? 'active' : '' ?>">Accueil</a>
        <a href="index.php?page=resourceChoice"class="<?= $current === 'resourceChoice' ? 'active' : '' ?>">Réserver</a>
        <a href="index.php?page=history"class="<?= $current === 'history' ? 'active' : '' ?>">Mes réservations</a>
        <a href="index.php?page=logout">Déconnexion</a>
    </nav>
</header>
<main>
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
<div id="confirmationModal" class="modal">
  <div class="modal-content">
    <p>Réservation effectuée avec succès !</p>
    <button id="closeModalBtn">Fermer</button>
  </div>
</div>
<?php endif; ?>
 <h1>Réservations</h1>

<h1>Ressources disponibles pour : <?= htmlspecialchars($type) ?></h1>


<form method="GET" action="index.php" style="margin-bottom: 20px;">
    <input type="hidden" name="page" value="reserve">
    <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">

    <label for="selected_date">Choisissez une date :</label>
    <input type="date" name="selected_date" id="selected_date" required>

    <label for="selected_time">Heure :</label>
    <input type="time" name="selected_time" id="selected_time" required>

    <button type="submit">Filtrer</button>
</form>

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
    <input type="date" name="selected_date" id="selected_date" required value="<?= htmlspecialchars($_GET['selected_date'] ?? '') ?>">
<input type="time" name="selected_time" id="selected_time" required value="<?= htmlspecialchars($_GET['selected_time'] ?? '') ?>">
    <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">
    <button type="submit">Réserver</button>
</form>                        
                  
                <?php else: ?>
                    <p style="color: red;">Déjà réservé</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune ressource disponible pour ce type.</p>
    <?php endif; ?>
</div>
    </main>

<footer>
    <p>&copy; 2025 - EquiPlanner - Gregory Mbayo</p>
</footer>





<script>
document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('confirmationModal');
  if (modal) {
    const closeBtn = document.getElementById('closeModalBtn');
    closeBtn.addEventListener('click', () => {
      modal.style.display = 'none';
      if (history.replaceState) {
        const url = new URL(window.location);
        url.searchParams.delete('success');
        window.history.replaceState({}, document.title, url.toString());
      }
    });
  }
});
</script>


</body>
</html>



