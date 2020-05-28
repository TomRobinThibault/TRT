-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 28 mai 2020 à 08:42
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ecole_trt`
--
CREATE DATABASE IF NOT EXISTS `ecole_trt` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ecole_trt`;

-- --------------------------------------------------------

--
-- Structure de la table `acceder`
--

DROP TABLE IF EXISTS `acceder`;
CREATE TABLE IF NOT EXISTS `acceder` (
  `idUser` int(11) UNSIGNED NOT NULL,
  `idPermission` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`idUser`,`idPermission`),
  KEY `acceder_ibfk_1` (`idPermission`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `acceder`
--

INSERT INTO `acceder` (`idUser`, `idPermission`) VALUES
(10, 1),
(10, 2),
(10, 4),
(10, 5),
(10, 6),
(10, 8),
(10, 9);

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `idPermission` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomPermission` text DEFAULT NULL,
  `codePermission` varchar(50) NOT NULL,
  PRIMARY KEY (`idPermission`),
  UNIQUE KEY `codePermission` (`codePermission`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `permission`
--

INSERT INTO `permission` (`idPermission`, `nomPermission`, `codePermission`) VALUES
(1, 'Acceder au panel administrateur (affichage de l\'icon)', 'admin.panel.access'),
(2, 'Permet de modifier les permissions d\'un utilisateur', 'admin.panel.modif.users.permissions'),
(4, 'Permet de voir les utilisateurs avec leurs informations', 'admin.panel.manage.users'),
(5, 'Permet de modifier les informations d\'un utilisateur', 'admin.panel.modif.users'),
(6, 'Permet d\'ajouter un utilisateur', 'admin.panel.add.users'),
(8, 'Permet de modifié le mot de passe d\'un utilisateur', 'admin.panel.modif.users.password'),
(9, 'Permission pour ajouter un Post', 'admin.panel.add.post');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `idPost` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titrePost` varchar(255) NOT NULL,
  `descPost` text NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateLastModification` datetime NOT NULL,
  `idUser` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`idPost`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idUser` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pseudoUser` varchar(30) NOT NULL,
  `identifiantUser` varchar(50) NOT NULL,
  `emailUser` varchar(60) NOT NULL,
  `hashUser` text NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateLastUtilisation` datetime NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUser`, `pseudoUser`, `identifiantUser`, `emailUser`, `hashUser`, `dateCreation`, `dateLastUtilisation`) VALUES
(10, 'tom', 'CanardConfit', 'tom@andrivet.com', 'cd2acea595e93463bc8ea3b6d1583fc9', '2028-05-20 07:48:05', '2020-05-28 08:28:25');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `acceder`
--
ALTER TABLE `acceder`
  ADD CONSTRAINT `acceder_ibfk_1` FOREIGN KEY (`idPermission`) REFERENCES `permission` (`idPermission`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `acceder_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `utilisateur` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `utilisateur` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
