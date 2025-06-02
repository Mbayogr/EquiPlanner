-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 26 mai 2025 à 06:06
-- Version du serveur :  5.7.11
-- Version de PHP : 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_equiplanner`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_reservation`
--

CREATE TABLE `t_reservation` (
  `reservation_id` int(11) NOT NULL,
  `date_` date NOT NULL,
  `hour_` time NOT NULL,
  `resource_fk` int(11) NOT NULL,
  `user_fk` int(11) NOT NULL,
  `status` enum('active','terminée','annulée','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_reservation`
--

INSERT INTO `t_reservation` (`reservation_id`, `date_`, `hour_`, `resource_fk`, `user_fk`, `status`) VALUES
(13, '2025-05-20', '12:00:00', 2, 1, 'terminée'),
(14, '2025-05-20', '10:00:00', 3, 1, 'terminée'),
(15, '2025-05-20', '11:00:00', 6, 1, 'terminée'),
(18, '2025-05-21', '19:00:00', 4, 1, 'annulée'),
(19, '2025-05-23', '14:00:00', 3, 1, 'annulée'),
(20, '2025-05-22', '20:00:00', 9, 1, 'terminée'),
(21, '2025-05-21', '20:00:00', 9, 2, 'terminée'),
(22, '2025-05-20', '23:00:00', 7, 2, 'terminée'),
(23, '2025-05-20', '20:00:00', 1, 1, 'terminée'),
(24, '2025-05-21', '08:00:00', 5, 1, 'annulée'),
(25, '2025-05-30', '04:00:00', 7, 1, 'annulée'),
(26, '2025-06-03', '10:00:00', 8, 4, 'active'),
(27, '2025-06-03', '11:00:00', 8, 4, 'active'),
(28, '2025-06-03', '12:00:00', 8, 4, 'active'),
(29, '2025-05-21', '09:00:00', 2, 4, 'terminée'),
(30, '2025-05-21', '08:00:00', 5, 1, 'terminée'),
(31, '2025-05-23', '10:00:00', 2, 1, 'annulée'),
(32, '2025-05-22', '12:00:00', 3, 2, 'terminée'),
(33, '2025-05-01', '10:00:00', 1, 2, 'terminée'),
(34, '2025-05-22', '10:00:00', 15, 1, 'terminée'),
(35, '2025-05-24', '14:00:00', 22, 5, 'active'),
(36, '2025-05-23', '15:00:00', 6, 1, 'annulée'),
(37, '2025-05-23', '12:22:00', 3, 1, 'annulée'),
(38, '2025-05-23', '10:00:00', 11, 1, 'annulée'),
(39, '2025-05-26', '12:00:00', 21, 1, 'active'),
(40, '2025-05-26', '12:00:00', 2, 1, 'active'),
(41, '2025-05-26', '12:00:00', 6, 1, 'active'),
(42, '2025-05-26', '12:00:00', 1, 1, 'active'),
(43, '2025-05-26', '12:00:00', 9, 1, 'active'),
(44, '2025-05-26', '12:00:00', 15, 1, 'active'),
(45, '2025-05-23', '08:00:00', 4, 1, 'terminée'),
(46, '2025-05-23', '08:00:00', 8, 1, 'terminée'),
(47, '2025-05-23', '09:00:00', 1, 1, 'terminée');

-- --------------------------------------------------------

--
-- Structure de la table `t_resource`
--

CREATE TABLE `t_resource` (
  `resource_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `available` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_resource`
--

INSERT INTO `t_resource` (`resource_id`, `type`, `name`, `available`) VALUES
(1, 'terrain', 'Terrain de foot', 1),
(2, 'ballon', 'Ballon de foot', 1),
(3, 'ballon', 'Ballon de volley', 1),
(4, 'terrain', 'Salle intérieure', 1),
(5, 'filet', 'Filet de volley', 1),
(6, 'ballon', 'Ballon de foot', 1),
(7, 'terrain', 'Terrain de unihockey', 1),
(8, 'terrain', 'Piste d\'athlétisme', 1),
(9, 'goal', 'Goal de foot (7m)', 1),
(10, 'goal', 'Goal de unihockey', 1),
(11, 'goal', 'Goal de foot (5m)', 1),
(12, 'goal', 'Goal de foot (5m)', 1),
(13, 'goal', 'Goal de foot (1m)', 1),
(14, 'goal', 'Goal de foot (1m)', 1),
(15, 'goal', 'Goal de foot (7m)', 1),
(16, 'goal', 'Goal de unihockey', 1),
(17, 'terrain', 'Terrain de pétanque', 1),
(18, 'ballon', 'Boule de pétanque', 1),
(19, 'ballon', 'Boule de pétanque', 1),
(20, 'ballon', 'Boule de pétanque', 1),
(21, 'piquet', 'Piquet de foot', 1),
(22, 'canne', 'Canne de hockey', 1);

-- --------------------------------------------------------

--
-- Structure de la table `t_user`
--

CREATE TABLE `t_user` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(320) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `t_user`
--

INSERT INTO `t_user` (`user_id`, `firstname`, `lastname`, `password`, `email`) VALUES
(1, 'John', 'Doe', '$2y$10$JRG2Y9K4CEmRjKascRq7s.PhA0/oIBKkQloe0nGEvp0X2OeseLZQG', 'John.Doe@equi.com'),
(2, 'Paul', 'Dubois', '$2y$10$c/tAnN7tor1.eabdKfmWhOeZRt3LBOJuWeteuOA2T70t57eRJNu3e', 'Paul.Dubois@equi.com'),
(3, 'Ariane', 'Dupont', '$2y$10$.SGay4xQaX86I5LzsWHRjuCvGGAOYS8RzaPC01LSkElnfevJDLzK6', 'Ariane.Dupont@equi.com'),
(4, 'Henri', 'Roux', '$2y$10$7wci89df2OOa3B2zAHdcaOv5vRhlnmHRh0BLIOVmCEKoYaz.q3Rkm', 'Henri.Roux@equi.com'),
(5, 'Richard', 'Morgan', '$2y$10$KoF6S5AN3ZY.utnbDqj6Lu9hDUTMfFvALY.MTAAtDo.WmVgUidU12', 'Richard.Morgan@equi.com');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `t_reservation`
--
ALTER TABLE `t_reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `resource_fk` (`resource_fk`),
  ADD KEY `user_fk` (`user_fk`);

--
-- Index pour la table `t_resource`
--
ALTER TABLE `t_resource`
  ADD PRIMARY KEY (`resource_id`);

--
-- Index pour la table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `t_reservation`
--
ALTER TABLE `t_reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `t_resource`
--
ALTER TABLE `t_resource`
  MODIFY `resource_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `t_reservation`
--
ALTER TABLE `t_reservation`
  ADD CONSTRAINT `t_reservation_ibfk_1` FOREIGN KEY (`resource_fk`) REFERENCES `t_resource` (`resource_id`),
  ADD CONSTRAINT `t_reservation_ibfk_2` FOREIGN KEY (`user_fk`) REFERENCES `t_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
