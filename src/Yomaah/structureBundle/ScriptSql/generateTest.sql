-- phpMyAdmin SQL Dump
-- version 4.1.0
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 16 Décembre 2013 à 20:28
-- Version du serveur :  5.5.34-MariaDB-log
-- Version de PHP :  5.5.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `Symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE IF NOT EXISTS `articleTest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artId` int(11) DEFAULT NULL,
  `artTitle` varchar(80) COLLATE utf8_bin NOT NULL,
  `artContent` text COLLATE utf8_bin NOT NULL,
  `artPngId` int(11) DEFAULT NULL,
  `artDate` date DEFAULT NULL,
  `artPageId` int(11) DEFAULT NULL,
  `artImgUrl` varchar(70) COLLATE utf8_bin DEFAULT NULL,
  `artSource` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `artLien` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `artId` (`artId`),
  KEY `art-png-id` (`artPngId`),
  KEY `art-page-id` (`artPageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=43 ;

--
-- Contraintes pour les tables exportées
--


CREATE TABLE IF NOT EXISTS `pageTest` (
  `pageId` int(11) NOT NULL,
  `pageUrl` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`pageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Structure de la table `menu`
--

CREATE TABLE IF NOT EXISTS `menuTest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(20) COLLATE utf8_bin NOT NULL,
  `name` varchar(20) COLLATE utf8_bin NOT NULL,
  `position` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;


-- Contraintes pour la table `article`
--
ALTER TABLE `articleTest`
  ADD CONSTRAINT `articleTest_page` FOREIGN KEY (`artPageId`) REFERENCES `pageTest` (`pageId`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `articleTest_png` FOREIGN KEY (`artPngId`) REFERENCES `png` (`pngId`) ON DELETE SET NULL ON UPDATE CASCADE;

INSERT INTO `pageTest` (`pageId`,`pageUrl`) VALUES (1,'accueil'),(2,'default');
INSERT INTO `articleTest` (`id`, `artId`, `artTitle`, `artContent`, `artPngId`, `artDate`, `artPageId`, `artImgUrl`, `artSource`, `artLien`) VALUES
(1,1,'Mon Titre','<p>Ceci est un article</p>',4,Now(),1,NULL,NULL,NULL),
(2, 2, 'Mon titre', '<p>Mon texte ici ...</p>', 3, NULL, 0, NULL, NULL, NULL);
INSERT INTO `menuTest` (`id`, `path`, `name`, `position`) VALUES
(1, 'accueil', 'Accueil', b'0');
