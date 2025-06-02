# EquiPlanner

**EquiPlanner** est une application web simple et intuitive conçue pour permettre aux membres d’un club sportif de réserver des ressources (terrains ou équipements) à une date et un horaire précis, sans avoir recours à des solutions informatiques complexes ou coûteuses.

---

##  Description

Un club sportif souhaite mettre à disposition ses ressources (terrains ou équipements) aux membres. Ce projet vise à développer une application web simple, fonctionnelle et intuitive, permettant aux membres d’un club :

- de consulter les ressources disponibles,
- de réserver une ressource à une date et un horaire précis.

Les ressources sont prédéfinies dans la base de données. Il n’existe **aucun espace administrateur** : seuls les membres peuvent consulter et réserver.

---
## Document

- Rapport : https://github.com/Mbayogr/EquiPlanner/blob/master/Document/Rapport/rapport.pdf
- Journal de travail : https://github.com/Mbayogr/EquiPlanner/blob/master/Document/PlannificationJDT/JDT.pdf
- Dossier du code : https://github.com/Mbayogr/EquiPlanner/tree/master/R%C3%A9alisation/EquiPlanner
- Base de données : https://github.com/Mbayogr/EquiPlanner/blob/master/R%C3%A9alisation/EquiPlanner/db/db_equiplanner.sql

##  Technologies utilisées

- PHP  
- MySQL  
- HTML / CSS  
- JavaScript  
- UwAmp  

---

##  Installation

1. **Cloner le dépôt** :
   
   git clone https://github.com/Mbayogr/EquiPlanner.git
   cd EquiPlanner

    Importer la base de données :
   
   lancer UwAmp.
   
   Accéder à phpmyAdmin.
   
   Créer une nouvelle base de données nommée db_equiplanner.
   
   importer le fichier .sql fournit dans le dépôt.


Utilisation
Démmarer Uwamp.

Placer le dossier EquiPlanner dans le dossier www de UwAmp.

Ouvrir votre navigateur et accéder à http://localhost/EquiPlanner.

Structure du projet

/EquiPlanner
|<br>
|----/controllers<br>
|	|-MainController.php<br>
|<br>
|----/models<br>
|	|-database.php<br>
|	|-reservation.php<br>
|	|-resource.php<br>
|<br>
|----/views<br>
|	|-login.php<br>
|	|-reserve.php<br>
|	|-history.php<br>
|	|-ressourceChoice.php<br>
|	|-home.php<br>
|<br>
|----index.php<br>


Aperçu



Les contributions sont les bienvenues ! Si vous souhaitez proposer des améliorations, n’hésitez pas à forker le projet, créer une branche et soumettre une Pull Request.
