-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 05 Décembre 2013 à 12:42
-- Version du serveur: 5.5.34-MariaDB-log
-- Version de PHP: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `Symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `artId` int(11) NOT NULL,
  `artTitle` varchar(80) COLLATE utf8_bin NOT NULL,
  `artContent` text COLLATE utf8_bin NOT NULL,
  `artPngId` int(11) DEFAULT NULL,
  `artDate` date NOT NULL,
  `artPageId` int(11) DEFAULT NULL,
  `artImgUrl` varchar(70) COLLATE utf8_bin DEFAULT NULL,
  `artSource` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `artLien` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`artId`),
  KEY `art-png-id` (`artPngId`),
  KEY `art-page-id` (`artPageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `article`
--

INSERT INTO `article` (`artId`, `artTitle`, `artContent`, `artPngId`, `artDate`, `artPageId`, `artImgUrl`, `artSource`, `artLien`) VALUES
(0, 'Facebook sommé de rétablir une page de fans de « Plus Belle La Vie »', '<p class="actu_chapeau"><span>En f&eacute;vrier 2012, Facebook France a accept&eacute; la demande de fermeture d&rsquo;une page non-officielle relative &agrave; &laquo;&nbsp;Plus Belle La Vie&nbsp;&raquo;, la soci&eacute;t&eacute; de production de la c&eacute;l&egrave;bre s&eacute;rie se plaignant d&rsquo;atteintes &agrave; ses droits de propri&eacute;t&eacute; intellectuelle. Le mois dernier, le tribunal de grande instance de Paris a cependant estim&eacute; que cette demande &eacute;tait injustifi&eacute;e. Le r&eacute;seau social devra donc r&eacute;tablir la fameuse page Facebook, tandis que la soci&eacute;t&eacute; de production a &eacute;t&eacute; condamn&eacute;e &agrave; verser 10 000 euros de dommages et int&eacute;r&ecirc;ts &agrave; la victime. </span></p>', 2, '2013-12-04', 1, 'http://static.pcinpact.com/images/bd/dedicated/84722.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/84722-facebook-france-somme-retablir-page-fans-plus-belle-la-vie.htm?ut'),
(1, 'Le CNNum bien silencieux sur le projet de loi de Najat Vallaud-Belkacem', '<p class="actu_chapeau">Malgr&eacute; plusieurs demandes (<a href="https://twitter.com/reesmarc/status/405251932198932480" target="_blank">l&agrave;</a>, <a href="https://twitter.com/reesmarc/status/405434217766461440" target="_blank">l&agrave;</a>, <a href="https://twitter.com/reesmarc/status/405686595321217024" target="_blank">l&agrave;</a>, <a href="https://twitter.com/reesmarc/status/406055510425600002" target="_blank">l&agrave;,&nbsp;</a><a href="https://twitter.com/reesmarc/status/405692849183678465" target="_blank">l&agrave;</a>) adress&eacute;es &agrave; Jean-Baptiste Soufron, secr&eacute;taire g&eacute;n&eacute;ral du Conseil national du num&eacute;rique, nous n&rsquo;avons toujours pas obtenu d&rsquo;information sur la saisine du projet de loi sur l&rsquo;&eacute;galit&eacute; entre les femmes et les hommes. Faute de choix, nous leur adressons donc une demande formelle de communication avant de saisir,&nbsp;si le silence perdure, la Commission d&rsquo;acc&egrave;s aux documents administratifs.</p>', 1, '2013-12-04', 1, 'http://static.pcinpact.com/images/bd/dedicated/84728.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/84728-le-cnnum-bien-silencieux-sur-projet-loi-najat-vallaud-belkacem.ht'),
(2, 'Téléchargement direct : Hotfile accepte de verser 80 millions $ à la MPAA', '<p class="actu_chapeau"><span>Nouvelle victoire pour la MPAA, cette fois face &agrave; l&rsquo;h&eacute;bergeur de fichiers Hotfile. Ce dernier vient en effet d&rsquo;accepter de verser 80 millions de dollars (soit pr&egrave;s de 59 millions d''euros) d&rsquo;indemnit&eacute;s au puissant lobby du cin&eacute;ma hollywoodien, qui avait engag&eacute; des poursuites &agrave; son encontre il y a plus de deux ans et demi. L&rsquo;interm&eacute;diaire technique aurait pu avoir &agrave; payer jusqu&rsquo;&agrave; 517 millions de dollars de dommages et int&eacute;r&ecirc;ts si les deux parties &eacute;taient all&eacute;es jusqu''&agrave; la fin du proc&egrave;s.&nbsp;</span></p>', 2, '2013-12-04', 1, 'http://static.pcinpact.com/images/bd/dedicated/84723.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/84723-telechargement-direct-hotfile-accepte-verser-80-millions-a-mpaa.h'),
(3, 'Comment va s''organiser la surveillance d''Internet en France', '<p class="actu_chapeau">Les d&eacute;put&eacute;s vont voter aujourd&rsquo;hui vers 17 heures, le projet de loi de programmation militaire (<a href="http://www.assemblee-nationale.fr/14/ta-pdf/1551-p.pdf" target="_blank">pdf</a>). Le texte a soulev&eacute; de nombreuses critiques, que ce soit chez <a href="http://www.renaissancenumerique.org/fr/tribunes/571-reaction-au-vote-de-larticle-13-de-la-nouvelle-loi-de-programmation-militaire-a-quand-le-retablissement-de-la-confiance-sur-internet-" target="_blank">Renaissance Num&eacute;rique</a>, l&rsquo;ASIC ou <a href="http://www.pcinpact.com/news/84619-surveillance-dinternet-cnil-deplore-d-avoir-ete-mise-sur-touche.htm" target="_blank">la CNIL</a> laquelle a mal v&eacute;cu le fait d&rsquo;&ecirc;tre mise sur la touche. PC INpact a cependant voulu se replonger dans ces dispositions pour tenter de mesurer l&rsquo;ampleur de la surveillance en ligne qu&rsquo;elles organisent en France</p>', 1, '2013-12-03', 1, 'http://static.pcinpact.com/images/bd/dedicated/84680.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/84680-comment-va-sorganiser-surveillance-dinternet-en-france.htm?utm_so'),
(4, 'Une députée veut que les logiciels commandés par l’État soient libres', '<p class="actu_chapeau"><span>Et si les logiciels ou toute autre &oelig;uvre ou donn&eacute;e immat&eacute;rielle (travaux de recherche, etc.) produite gr&acirc;ce aux deniers publics &eacute;taient publi&eacute;s sous licence libre par l&rsquo;&Eacute;tat&nbsp;? Telle est la proposition d&rsquo;une d&eacute;put&eacute;e &agrave; l&rsquo;attention du gouvernement. </span></p>', 1, '2013-12-03', 1, 'http://static.pcinpact.com/images/bd/dedicated/84695.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/84695-une-deputee-veut-que-logiciels-commandes-par-l-etat-soient-libres'),
(5, 'Hotfile pourrait avoir à verser plus de 500 millions de dollars à la MPAA', '<p class="actu_chapeau"><span>En proc&egrave;s contre la MPAA, l&rsquo;h&eacute;bergeur de fichiers Hotfile va devoir verser des dommages et int&eacute;r&ecirc;ts au puissant lobby du cin&eacute;ma hollywoodien. La facture pourrait d&eacute;passer les 500 millions de dollars. </span></p>', 2, '2013-12-03', 1, 'http://static.pcinpact.com/images/bd/dedicated/84701.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/84701-hotfile-pourrait-avoir-a-verser-plus-500-millions-dollars-a-mpaa.'),
(6, '[Interview] Cyberviolence scolaire : « les outils ne sont pas à diaboliser »', '<p class="actu_chapeau"><span>Catherine Blaya, professeure en sciences de l''&eacute;ducation et pr&eacute;sidente de l''Observatoire international de la violence &agrave; l''&eacute;cole, a &eacute;tudi&eacute; de pr&egrave;s les ph&eacute;nom&egrave;nes de cyberviolence et de cyberharc&egrave;lement &agrave; l&rsquo;&eacute;cole. Auteur du livre &laquo;&nbsp;<em>Les ados dans le cyberespace</em>&nbsp;&raquo;, l&rsquo;int&eacute;ress&eacute;e a accept&eacute; de r&eacute;pondre aux questions de PC INpact. </span></p>', 1, '2013-12-03', 1, 'http://static.pcinpact.com/images/bd/dedicated/84683.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/84683-interview-cyberviolence-scolaire-outils-ne-sont-pas-a-diaboliser.');

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(20) COLLATE utf8_bin NOT NULL,
  `name` varchar(20) COLLATE utf8_bin NOT NULL,
  `position` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Contenu de la table `menu`
--

INSERT INTO `menu` (`id`, `path`, `name`, `position`) VALUES
(1, 'yomaah_homepage', 'Accueil', b'0'),
(2, 'cv', 'C.V.', b'0'),
(3, 'projet', 'Mes Projets', b'0'),
(4, 'espace_client', 'Espace Client', b'1');

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `pageId` int(11) NOT NULL,
  `pageUrl` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`pageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `page`
--

INSERT INTO `page` (`pageId`, `pageUrl`) VALUES
(1, 'accueil');

-- --------------------------------------------------------

--
-- Structure de la table `png`
--

CREATE TABLE IF NOT EXISTS `png` (
  `pngId` int(11) NOT NULL,
  `pngUrl` varchar(200) COLLATE utf8_bin NOT NULL,
  `pngCategory` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`pngId`),
  KEY `png-url` (`pngUrl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `png`
--

INSERT INTO `png` (`pngId`, `pngUrl`, `pngCategory`) VALUES
(1, 'loi.png', 'Loi'),
(2, 'justice.png', 'Justice');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_page` FOREIGN KEY (`artPageId`) REFERENCES `page` (`pageId`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `article_png` FOREIGN KEY (`artPngId`) REFERENCES `png` (`pngId`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
