# EquiPlanner

**EquiPlanner** est une application web simple et intuitive conçue pour permettre aux membres d’un club sportif de réserver des ressources (terrains ou équipements) à une date et un horaire précis, sans avoir recours à des solutions informatiques complexes ou coûteuses.

---

## 📌 Description

Un club sportif souhaite mettre à disposition ses ressources (terrains ou équipements) aux membres. Ce projet vise à développer une application web simple, fonctionnelle et intuitive, permettant aux membres d’un club :

- de consulter les ressources disponibles,
- de réserver une ressource à une date et un horaire précis.

Les ressources sont prédéfinies dans la base de données. Il n’existe **aucun espace administrateur** : seuls les membres peuvent consulter et réserver.

---

## 🛠️ Technologies utilisées

- PHP  
- MySQL  
- HTML / CSS  
- JavaScript  
- UwAmp  

---

## 🚀 Installation

1. **Cloner le dépôt** :
   
   git clone https://github.com/Mbayogr/EquiPlanner.git
   cd EquiPlanner

    Importer la base de données :

        Lancer UwAmp.

        Accéder à phpMyAdmin.

        Créer une nouvelle base de données (par exemple db_equiplanner).

        Importer le fichier .sql fourni dans le dépôt.

▶️ Utilisation

    Démarrer UwAmp.

    Placer le projet dans le dossier www de UwAmp.

    Ouvrir votre navigateur et accéder à : http://localhost/EquiPlanner

📁 Structure du projet

/EquiPlanner
|
|----/controllers
|     |- MainController.php
|
|----/models
|     |- database.php
|     |- reservation.php
|     |- resource.php
|
|----/views
|     |- login.php
|     |- reserve.php
|     |- history.php
|     |- ressourceChoice.php
|     |- home.php
|
|---- index.php

🖼️ Aperçu




Les contributions sont les bienvenues ! Si vous souhaitez proposer des améliorations, n’hésitez pas à forker le projet, créer une branche et soumettre une Pull Request.
