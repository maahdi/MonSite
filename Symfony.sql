-- phpMyAdmin SQL Dump
-- version 4.1.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 24 Décembre 2013 à 08:08
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

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artId` int(11) DEFAULT NULL,
  `artTitle` varchar(80) CHARACTER SET utf8 NOT NULL,
  `artContent` text CHARACTER SET utf8 NOT NULL,
  `artPngId` int(11) DEFAULT NULL,
  `artDate` date DEFAULT NULL,
  `artPageId` int(11) DEFAULT NULL,
  `artImgUrl` varchar(70) CHARACTER SET utf8 DEFAULT NULL,
  `artSource` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `artLien` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `tagName` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `artId` (`artId`),
  KEY `art-png-id` (`artPngId`),
  KEY `art-page-id` (`artPageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=118 ;

--
-- Contenu de la table `article`
--

INSERT INTO `article` (`id`, `artId`, `artTitle`, `artContent`, `artPngId`, `artDate`, `artPageId`, `artImgUrl`, `artSource`, `artLien`, `tagName`) VALUES
(6, 9, 'Mon Site Web', '<h2>Présentation<br></h2><p>Mon premier projet est le site internet sur lequel vous vous trouvez et que j''ai développé à l''aide de Php, HTML 5, CSS3, Mysql, Jquery et Ajax.</p><p><br></p><p>p.s.: La première page affiche le contenu d''un flux rss décomposé et enregistré au préalable dans Mysql depuis un script PHP et mis à jour régulièrement avec Crontab.</p><p><br></p><h3>Démonstration :<br></h3><p>Vous pouvez vous connecter à l''espace client avec les identifiants par défault afin d''essayer l''interface d''administration que je suis en train de développer avec Jquery et Ajax.</p><p>Je rencontre des soucis de compatibilité sur certains points avec Internet Explorer et Chrome pour cela, alors je vous conseille d''utiliser Firefox.<br></p><p><br></p><h3>Code source :<br></h3><p>Vous trouverez mon code ici : <a href="code_source/lit">mon code source</a>. Cette présentation a été faite par un plugin Symfony que j''ai créé pour parcourir l''arborescence du répertoire source contenant tous les composants de mon site .<br></p><p>Les sources sont aussi disponible via le plugin Jquery ''repo.js'' qui affiche le contenu du site web entier depuis GitHub.com : <a href="code_source_git">code source git</a>.</p><p><br></p><h2>Ressources Utilisées</h2><p><br></p><h3>Symfony 2 :</h3><p>C''est un framework&nbsp; PHP très populaire permettant de construire des applications (ou sites) web sécurisées rapidement. Il permet de se concentrer sur le code de son application en apportant beaucoup de souplesse au développement.</p><br><h3>Doctrine 2 :</h3><p>Il s''agit d''un ORM (Object Relation Mapping), intégré à Symfony 2, qui permet d''intéragir de façon simple et automatisé à une base données afin de rendre le site dynamique.</p><p><br></p><h3>Foundation 4 :</h3><p>C''est un framework css qui permet de simplifier la mise en page des sites web à l''aide d''un système de grille.</p><p>Grace à lui, et à l''emploi des media-queries, il est facile de construire un site ayant un rendu adapté aux smartphones, ce qui dévient un impératif de nos jours.</p><p><br></p><h3>Hallo.js :</h3><p>C''est un plugin léger en Jquery permettant d''éditer simplement de manière ergonomique des éléments d''une page html. Couplé avec Ajax (Asynchronous Javascript and Xml) il permet d''enregistrer les articles dans une base de données de façon transparente pour l''utilisateur.</p><p><br></p><h3>Repo.js :</h3><p>Lui aussi est un plugin léger en Jquery permettant d''afficher le contenu d''un dépôt directement dans mon site web.</p><p><br></p><h3>Prism.js :</h3><p>Un autre plugin Jquery qui me sert à coloriser les pages de codes de mon projet.</p><p><br></p><h3>Toolbar.js :</h3><p>Encore un plugin Jquery dont je me sert pour afficher les boutons pour modifier les pages.<br></p><p><br></p>', 6, '2013-12-10', 2, NULL, NULL, NULL, NULL),
(8, 11, 'Code Source', '', 3, NULL, 4, NULL, NULL, NULL, NULL),
(9, 12, 'Mon titre', '<p>Mon texte ici ...</p>', 3, NULL, 0, NULL, NULL, NULL, NULL),
(14, 18, 'Mon C.V.', '<p><br></p><p>Vous trouverez mon C.V. ci-dessous !</p>', 4, '2013-12-16', 5, 'embed', NULL, NULL, NULL),
(50, 72, 'Google aussi suspecté d''abus de position dominante au Canada', '<p class="actu_chapeau">Suspect&eacute; d''abus de position dominante&nbsp;<span>- mais pas forc&eacute;ment condamn&eacute; - en <a href="http://www.pcinpact.com/news/76673-google-est-en-abus-position-dominante-en-europe-selon-joaquin-almunia.htm" target="_blank">Europe</a>, en <a href="http://www.engadget.com/2013/07/18/south-koreas-ftc-finds-google-not-guilty-of-antitrust-measures/" target="_blank">Cor&eacute;e du Sud</a> ou encore aux&nbsp;<a href="http://www.forbes.com/sites/ericgoldman/2013/01/03/the-ftc-smartly-ends-its-imprudent-google-search-antitrust-investigation/" target="_blank">&Eacute;tats-Unis</a>, Google est aussi point&eacute; du doigt par le Bureau de la concurrence du Canada. Des documents ont ainsi &eacute;t&eacute; d&eacute;pos&eacute;s aupr&egrave;s de la <a href="http://cas-ncr-nter03.cas-satj.gc.ca/portal/page/portal/fc_cf_fr/Index" target="_blank">Cour f&eacute;d&eacute;rale d''Ottawa</a>, ceci dans le but d''obtenir des informations de la branche canadienne de Google sur ses diverses activit&eacute;s.</span></p>', 2, '2013-12-16', 1, 'http://static.pcinpact.com/images/bd/dedicated/84949.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/84949-google-aussi-suspecte-dabus-position-dominante-au-canada.htm?utm_source=PCi_RSS_Feed&utm_medium=news&utm_campaign=pcinpact', NULL),
(51, 73, 'Comment le numérique pourrait aider le « juge du 21ème siècle »', '<p class="actu_chapeau">Cr&eacute;ation d&rsquo;une plateforme de r&egrave;glement en ligne des litiges, permettre aux justiciables de suivre leurs dossiers sur Internet, ouverture de possibilit&eacute;s d&rsquo;&eacute;changer par email avec les services judicaires,... Voici quelques-unes des propositions faites dans un rapport sur &laquo;&nbsp;<em>Le juge du 21&egrave;me si&egrave;cle</em>&nbsp;&raquo;, command&eacute; par la ministre de la Justice, Christiane Taubira, et qui vient d''&ecirc;tre rendu public.&nbsp;</p>', 1, '2013-12-16', 1, 'http://static.pcinpact.com/images/bd/dedicated/84849.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/84849-comment-numerique-pourrait-aider-juge-21eme-siecle.htm?utm_source=PCi_RSS_Feed&utm_medium=news&utm_campaign=pcinpact', NULL),
(52, 74, '#LPM : manque une dizaine de députés pour saisir le Conseil constitutionnel', '<p class="actu_chapeau">Selon nos informations, glan&eacute;es au sein de l&rsquo;UMP, pr&egrave;s de 50 d&eacute;put&eacute;s de droite et du centre sont d&eacute;sormais pr&ecirc;ts &agrave; signer la saisine du Conseil constitutionnel sur le projet de loi de programmation militaire. &laquo;&nbsp;<em>Nous essayons d&rsquo;obtenir autant que possible ces 60 signatures,&nbsp;</em>nous confie une source.<em>&nbsp;Il en manque 10 mais on sent qu&rsquo;on va y arriver compte tenu de la prise de conscience sur le sujet, sp&eacute;cialement avec la participation de poids lourds dans la bataille.</em>&nbsp;&raquo;</p>', 1, '2013-12-16', 1, 'http://static.pcinpact.com/images/bd/dedicated/84945.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/84945-lpm-cinquantaine-deputes-prets-a-saisir-conseil-constitutionne.htm?utm_source=PCi_RSS_Feed&utm_medium=news&utm_campaign=pcinpact', NULL),
(53, 75, 'AdWords : Google finalement conforté dans son statut d’hébergeur', '<p class="actu_chapeau">La cour d&rsquo;appel de Paris a finalement donn&eacute; raison &agrave; Google <a href="http://static.pcinpact.com/medias/arret-de-la-c-a--de-paris-11-decembre-2013-google---olivier-m-adwords.docx" target="_blank">dans un arr&ecirc;t</a> in&eacute;dit. Elle d&eacute;cide que l&rsquo;entreprise profite bien du statut d&rsquo;h&eacute;bergeur sur les liens publicitaires Adwords. Elle d&eacute;boute ainsi l&rsquo;acteur Olivier Martinez qui tentait de la rendre responsable de la r&eacute;daction des annonces publi&eacute;es par des tiers, ici Gala.fr.</p>', 2, '2013-12-16', 1, 'http://static.pcinpact.com/images/bd/dedicated/84942.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/84942-adwords-google-finalement-conforte-dans-son-statut-d-hebergeur.htm?utm_source=PCi_RSS_Feed&utm_medium=news&utm_campaign=pcinpact', NULL),
(54, 76, 'Le rapport interministériel sur la cybercriminalité reporté à février 2014', '<p class="actu_chapeau"><span>O&ugrave; en sont les travaux du groupe de travail interminist&eacute;riel d&eacute;di&eacute; &agrave; la cybercriminalit&eacute;, dont les conclusions furent <a href="http://www.pcinpact.com/news/82121-un-rapport-interministeriel-sur-cybercriminalite-prevu-pour-fin-novembre.htm" target="_blank">promises un temps pour la fin novembre</a>&nbsp;? Ces derni&egrave;res ne sont toujours pas pr&ecirc;tes... Le minist&egrave;re de la Justice vient en effet de nous informer qu&rsquo;il faudrait attendre la mi-f&eacute;vrier.</span></p>', 1, '2013-12-16', 1, 'http://static.pcinpact.com/images/bd/dedicated/84940.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/84940-le-rapport-interministeriel-sur-cybercriminalite-reporte-a-fevrier-2014.htm?utm_source=PCi_RSS_Feed&utm_medium=news&utm_campaign=pcinpact', NULL),
(55, 77, 'Au Royaume-Uni, les FAI déploient le blocage par défaut du porno', '<p class="actu_chapeau"><span>Depuis vendredi, le fournisseur d&rsquo;acc&egrave;s &agrave; Internet britannique &laquo;&nbsp;BT&nbsp;&raquo; allume d&rsquo;office, pour tous ses nouveaux clients, un filtre bloquant par d&eacute;faut les sites class&eacute;s X. Pour le d&eacute;sactiver, l''abonn&eacute; doit d&eacute;cocher une case pr&eacute;-s&eacute;lectionn&eacute;e. Le d&eacute;ploiement de ce filtre, qui s''&eacute;tendra d''ici la fin de l''ann&eacute;e prochaine &agrave; l''ensemble des clients de l''op&eacute;rateur, n''est qu''<a href="http://www.pcinpact.com/news/84482-contre-pedopornographie-royaume-uni-cible-reseaux-p2p.htm" target="_blank">une des pierres</a> du vaste plan engag&eacute; par le Royaume-Uni au nom de la protection de l''enfance.&nbsp;</span></p>', 1, '2013-12-16', 1, 'http://static.pcinpact.com/images/bd/dedicated/84907.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/84907-au-royaume-uni-fai-deploient-blocage-par-defaut-porno.htm?utm_source=PCi_RSS_Feed&utm_medium=news&utm_campaign=pcinpact', NULL),
(56, 78, 'Copie privée : la colère de Françoise Castex', '<p class="actu_chapeau">&Agrave;&nbsp;quelques jours du vote sur son <a href="http://www.pcinpact.com/news/82481-europe-projet-resolution-castex-sur-copie-privee.htm" target="_blank">rapport sur la copie priv&eacute;e</a>, l&rsquo;eurod&eacute;put&eacute;e socialiste Fran&ccedil;oise Castex se voit prise entre plusieurs feux, contradictoires, suivant les groupes politiques et les sources d''influence de chacun d''entre eux.&nbsp;</p>', 1, '2013-12-14', 1, 'http://static.pcinpact.com/images/bd/dedicated/84925.jpg', 'www.pcinpact.com', 'http://www.pcinpact.com/news/84925-copie-privee-colere-francoise-castex.htm?utm_source=PCi_RSS_Feed&utm_medium=news&utm_campaign=pcinpact', NULL),
(58, 69, 'Notre sélection de marques', '<p>Nous sélectionnons pour vous tout un panel de marques afin de vous proposer la meilleur qualité aux mailleurs prix!</p><p>Confort, durabilité et ergonomie sont autant de critères de choix de notre part !</p><p>Découvrez-les dès à présent !</p>', NULL, NULL, 7, NULL, NULL, NULL, NULL),
(60, 80, 'Des petits prix et des conseils', '<p>Euro Literie vous propose un large choix de sommiers, matelats, lits électriques...</p><p>Nous mettons un point d''honneur à ce que le client reparte satisfait et surtout avec le produit qui lui convienne.</p><p>C''est pourquoi nous sommes à votre écoute car, pour nous, un bon conseil est primordial !</p><p>Mais Euro Literie c''est aussi l''assurance d''avoir des produits de qualité à des prix minis !</p><p>\nN''hésitez plus et venez <a href="contact">nous rencontrer</a> afin de profiter de notre expertise dans la literie !</p>', NULL, NULL, 6, NULL, NULL, NULL, NULL),
(73, 55, 'Mon titre', '<p>Mon texte ici ...</p>', NULL, NULL, 9, NULL, NULL, NULL, NULL),
(103, 10, 'Mon titre', '<p>Ceci est un article</p>', 3, '2013-12-22', 2, NULL, NULL, NULL, NULL),
(106, 81, 'Plan d''accès', '', NULL, NULL, 8, NULL, NULL, NULL, 'map'),
(107, 82, '', '<p>Euro Literie</p><p>1859 Avenue du Maréchal Juin</p><p>40 000 MONT DE MARSAN</p>', NULL, NULL, 8, NULL, NULL, NULL, 'adresse_courrier'),
(111, 84, 'Nos Horaires', '<p>Notre magasin est heureux de vous accueillir à ses heures d''ouverture :</p>', NULL, NULL, 8, NULL, NULL, NULL, 'horaire'),
(112, 85, 'Nous contacter', '<p>Pour nous contacter par e-mail veuillez remplir le formulaire ci dessous :</p>', NULL, NULL, 8, NULL, NULL, NULL, 'formulaire'),
(113, 83, '', '<p>05.58.05.94.46</p>', NULL, NULL, 8, NULL, NULL, NULL, 'adresse_phone');

-- --------------------------------------------------------

--
-- Structure de la table `articleTest`
--

CREATE TABLE IF NOT EXISTS `articleTest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artId` int(100) NOT NULL,
  `artTitle` varchar(80) COLLATE utf8_bin NOT NULL,
  `artContent` text COLLATE utf8_bin NOT NULL,
  `artPngId` int(11) DEFAULT NULL,
  `artDate` date DEFAULT NULL,
  `artPageId` int(11) DEFAULT NULL,
  `artImgUrl` varchar(70) COLLATE utf8_bin DEFAULT NULL,
  `artSource` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `artLien` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `token` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `art-png-id` (`artPngId`),
  KEY `art-page-id` (`artPageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=84 ;

--
-- Contenu de la table `articleTest`
--

INSERT INTO `articleTest` (`id`, `artId`, `artTitle`, `artContent`, `artPngId`, `artDate`, `artPageId`, `artImgUrl`, `artSource`, `artLien`, `token`) VALUES
(45, 1, 'Mon Titre', '<p>Ceci est un article</p>', 4, '2013-12-18', 86, NULL, NULL, NULL, 11),
(46, 2, 'Mon titre', '<p>Mon texte ici ...</p>', 3, NULL, 85, NULL, NULL, NULL, 11),
(49, 1, 'Mon titre', '<p>Mon texte ici ...</p>', 3, '2013-12-18', NULL, NULL, NULL, NULL, NULL),
(55, 2, 'Mon titre', '<p>Mon texte ici ...</p>', 3, NULL, 91, NULL, NULL, NULL, 12),
(62, 2, 'Mon titre', '<p>Mon texte ici ...</p>', 3, NULL, 97, NULL, NULL, NULL, 13),
(64, 3, 'Mon titre', '<p>Mon texte ici ...</p>', 3, '2013-12-18', 98, NULL, NULL, NULL, 13),
(65, 1, 'Mon Titre', '<p>Ceci est un article</p>', 4, '2013-12-19', 100, NULL, NULL, NULL, 14),
(66, 2, 'Mon titre', '<p>Mon texte ici ...</p>', 3, NULL, 99, NULL, NULL, NULL, 14),
(69, 3, 'Mon Titre', '<p>Ceci est un article</p>', 4, '2013-12-20', 104, NULL, NULL, NULL, 15),
(70, 2, 'Mon titre', '<p>Mon texte ici ...</p>', 3, NULL, 103, NULL, NULL, NULL, 15),
(71, 1, 'Mon titre', '<p>Mon texte ici ...</p>', 3, '2013-12-20', 104, NULL, NULL, NULL, 15),
(76, 2, 'Mon titre', '<p>Mon texte ici ...</p>', 3, NULL, 107, NULL, NULL, NULL, 16),
(80, 1, 'Mon Titre', '<p>Ceci est un article</p>', 4, '2013-12-22', 110, NULL, NULL, NULL, 17),
(81, 2, 'Mon titre', '<p>Mon texte ici ...</p>', 3, NULL, 109, NULL, NULL, NULL, 17),
(82, 1, 'Mon Titre', '<p>Ceci est un article</p>', 4, '2013-12-22', 112, NULL, NULL, NULL, 18),
(83, 2, 'Mon titre', '<p>Mon texte ici ...</p>', 3, NULL, 111, NULL, NULL, NULL, 18);

-- --------------------------------------------------------

--
-- Structure de la table `compteur`
--

CREATE TABLE IF NOT EXISTS `compteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nbVisites` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

CREATE TABLE IF NOT EXISTS `groupes` (
  `idGroup` int(11) NOT NULL AUTO_INCREMENT,
  `nomGroupe` varchar(30) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`idGroup`),
  KEY `idGroup` (`idGroup`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Contenu de la table `groupes`
--

INSERT INTO `groupes` (`idGroup`, `nomGroupe`) VALUES
(1, 'administrateur'),
(2, 'visiteur'),
(3, 'client');

-- --------------------------------------------------------

--
-- Structure de la table `marques`
--

CREATE TABLE IF NOT EXISTS `marques` (
  `idMarque` int(11) NOT NULL AUTO_INCREMENT,
  `nomMarque` varchar(70) NOT NULL,
  `pngUrl` varchar(70) NOT NULL,
  `content` text NOT NULL,
  `marqueLien` varchar(200) NOT NULL,
  PRIMARY KEY (`idMarque`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `marques`
--

INSERT INTO `marques` (`idMarque`, `nomMarque`, `pngUrl`, `content`, `marqueLien`) VALUES
(1, 'Amiel', 'amiel.png', '<p>La société AMIEL est une entreprise familiale installée sur TOULOUSE depuis 1946, par ses compétences techniques et sa qualité de travail, la société a su gagner la confiance d''un grand nombre de distributeurs spécialisés dans le domaine de la literie.</p><p>Initialement spécialiste de la fabrication de sommiers à lattes, Amiel complète dès la fin des année 1990 son offre par un gamme étendue de matelas et d''accessoires à l''usage des professionnels de la literie et des collectivités sur l''ensemble du Sud ouest de la France.</p><p>Tous les sommiers Amiel sont fabriqués en France et sont de grande qualité, quand aux matelas et accessoires, ils viennent d''un peu partout en Europe ( Espagne, Allemagne...)</p>\n', 'www.amiel.fr'),
(2, 'Epeda', 'epeda.jpg', '<p>Depuis des générations et pour toutes les générations Epéda innove sans cesse pour améliorer votre sommeil et faire de chaque matin un pur moment de bonheur.</p><p>Epéda, fabricant française de literie, est une des plus grandes marques de literie française, offrant différentes solutions de repos, avec une exigence élevée de qualité.</p><p>Grâce à ses innovations technologiques, devenues des références indiscutables en matière de confort et d’ergonomie du sommeil, Epéda possède un statut particulier dans l’univers de la literie.</p>', 'www.epeda.fr'),
(3, 'Onrev', 'onrev.jpg', '<p>Onrev, expert en sommeil depuis 1928 : plus de 80 ans d’expérience.</p><p>Onrev, c’est l’alliance d’un savoir-faire hérité d’une longue tradition artisanale française, et de la recherche permanente des technologies les plus abouties et des meilleurs matériaux pour rester à la pointe du confort et de la qualité.</p><p>C’est également la volonté que des bons produits soient aussi des beaux produits, par la qualité des coutils stretch, la finition impeccable et l’utilisation des techniques parfaitement maîtrisées comme le capitonnage intérieur.</p>', 'www.onrev.fr'),
(4, 'TDR', 'TDR.png', '<p>Depuis la création de l''entreprise par Fernand De Giorgi leur objectif est l''entière satisfaction de leurs clients.</p><p>Leur unité de production est moderne et dotée des dernières technologies dans le tournage du bois, des finitions et de l''emballage.</p><p>Des milliers d''articles sont produits chaque jour dans le respect\nde l''environnement.</p><p>L''essence principalement employée est le hêtre français.</p><p>Ils contribuent à la vie de nos forêts.</p>', 'www.tdr-tournerie.com'),
(5, 'Duvivier', 'duvivier.jpg', '<p>Fort de plus de 80 ans d''expérience, Duvivier a développé, sur un site industriel de plusieurs hectares une fabrication moderne de matelas, sommiers et cadres à lattes, en alliant savoir-faire et innovation.</p><p>Pourquoi choisir un matelas Duvivier ?</p><p>Un matelas naturellement aéré : aération facilitée par les grands aérateurs Duvivier AirSystem®. Des matériaux naturels, facilement recyclables (coton, feutre, acier…)</p><p>Une plus grande longévité (garantie jusqu''à 7 ans !)</p>', 'www.literie-duvivier.fr'),
(6, 'Résistub', 'resistub.jpg', '<p>L''histoire a commencé avec celle d''un homme, GEORGES RAIMBAUD son créateur.</p><p>Forgeron, il a démarré son activité dans une petite forge de Vendée. Pionnier, curieux, il s''est très vite détourné du métier classique de forgeron pour exercer ses capacités vers d''autres domaines, ...</p><p>Depuis plus de 50 ans, RESISTUB conçoit à partir de son métier d''origine,le travail du métal, les meubles et les objets de votre vie.</p><p>Artisan forgeron, hier, Industriel à vocation européenne aujourd''hui, RESISTUB, et ses différentes collections sans cesse renouvelées, propose des produits qui appartiennent à toutes les tendances de la décoration...</p>', 'www.resistub.com'),
(12, 'Wifor', 'wifor.jpg', '<p>Du texte</p>', 'www.wifor.fr');

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `idMenu` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(20) COLLATE utf8_bin NOT NULL,
  `name` varchar(20) COLLATE utf8_bin NOT NULL,
  `position` bit(1) NOT NULL,
  `site` int(50) DEFAULT NULL,
  PRIMARY KEY (`idMenu`),
  KEY `site` (`site`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

--
-- Contenu de la table `menu`
--

INSERT INTO `menu` (`idMenu`, `path`, `name`, `position`, `site`) VALUES
(1, 'yomaah_homepage', 'Accueil', b'0', NULL),
(2, 'cv', 'C.V.', b'0', NULL),
(3, 'projet', 'Mes Projets', b'0', NULL),
(4, 'login', 'Espace Client', b'1', NULL),
(5, 'literie_accueil', 'Accueil', b'0', 1),
(6, 'literie_marques', 'Nos Marques', b'0', 1),
(7, 'literie_magasin', 'Notre Magasin', b'0', 1),
(8, 'literie_contact', 'Nous Trouver', b'0', 1);

-- --------------------------------------------------------

--
-- Structure de la table `menuTest`
--

CREATE TABLE IF NOT EXISTS `menuTest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(20) COLLATE utf8_bin NOT NULL,
  `name` varchar(20) COLLATE utf8_bin NOT NULL,
  `position` bit(1) NOT NULL,
  `token` int(110) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=37 ;

--
-- Contenu de la table `menuTest`
--

INSERT INTO `menuTest` (`id`, `path`, `name`, `position`, `token`) VALUES
(23, 'accueil', 'Accueil', b'0', 11),
(26, 'accueil', 'Accueil', b'0', 12),
(29, 'accueil', 'Accueil', b'0', 13),
(30, 'accueil', 'Accueil', b'0', 14),
(32, 'accueil', 'Accueil', b'0', 15),
(34, 'accueil', 'Accueil', b'0', 16),
(35, 'accueil', 'Accueil', b'0', 17),
(36, 'accueil', 'Accueil', b'0', 18);

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `pageId` int(11) NOT NULL,
  `pageUrl` varchar(50) NOT NULL,
  `idSite` int(11) DEFAULT NULL,
  PRIMARY KEY (`pageId`),
  KEY `page_ibfk_1` (`idSite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `page`
--

INSERT INTO `page` (`pageId`, `pageUrl`, `idSite`) VALUES
(0, 'default', NULL),
(1, 'accueil', NULL),
(2, 'projets', NULL),
(4, 'code_source', NULL),
(5, 'cv', NULL),
(6, 'accueil', 1),
(7, 'marques', 1),
(8, 'contact', 1),
(9, 'default', 1);

-- --------------------------------------------------------

--
-- Structure de la table `pageTest`
--

CREATE TABLE IF NOT EXISTS `pageTest` (
  `pageId` int(11) NOT NULL AUTO_INCREMENT,
  `pageUrl` varchar(50) COLLATE utf8_bin NOT NULL,
  `token` int(100) DEFAULT NULL,
  PRIMARY KEY (`pageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=113 ;

--
-- Contenu de la table `pageTest`
--

INSERT INTO `pageTest` (`pageId`, `pageUrl`, `token`) VALUES
(85, 'default', 11),
(86, 'accueil', 11),
(91, 'default', 12),
(92, 'accueil', 12),
(97, 'default', 13),
(98, 'accueil', 13),
(99, 'default', 14),
(100, 'accueil', 14),
(103, 'default', 15),
(104, 'accueil', 15),
(107, 'default', 16),
(108, 'accueil', 16),
(109, 'default', 17),
(110, 'accueil', 17),
(111, 'default', 18),
(112, 'accueil', 18);

-- --------------------------------------------------------

--
-- Structure de la table `png`
--

CREATE TABLE IF NOT EXISTS `png` (
  `pngId` int(11) NOT NULL,
  `pngUrl` varchar(200) COLLATE utf8_bin NOT NULL,
  `pngCategory` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`pngId`),
  KEY `png-url` (`pngUrl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `png`
--

INSERT INTO `png` (`pngId`, `pngUrl`, `pngCategory`) VALUES
(0, 'link.png', NULL),
(1, 'loi.png', 'Loi'),
(2, 'justice.png', 'Justice'),
(3, 'fichierTitre.png', ''),
(4, 'cv.png', NULL),
(6, 'link.png', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `site`
--

CREATE TABLE IF NOT EXISTS `site` (
  `idSite` int(11) NOT NULL AUTO_INCREMENT,
  `nomSite` varchar(50) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  PRIMARY KEY (`idSite`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `site`
--

INSERT INTO `site` (`idSite`, `nomSite`, `idUser`) VALUES
(1, 'literie', 3);

-- --------------------------------------------------------

--
-- Structure de la table `sousMenu`
--

CREATE TABLE IF NOT EXISTS `sousMenu` (
  `idSousMenu` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(30) COLLATE utf8_bin NOT NULL,
  `name` varchar(30) COLLATE utf8_bin NOT NULL,
  `idMenu` int(11) NOT NULL,
  PRIMARY KEY (`idSousMenu`),
  KEY `idMenu` (`idMenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Contenu de la table `sousMenu`
--

INSERT INTO `sousMenu` (`idSousMenu`, `path`, `name`, `idMenu`) VALUES
(1, 'googleMap', 'Plan', 8),
(2, 'horaires', 'Nos Horaires', 8),
(3, 'email', 'Nous Contacter', 8),
(4, 'code_source', 'Code Source', 3),
(5, 'code_source_git', 'Code Source Git', 3);

-- --------------------------------------------------------

--
-- Structure de la table `user_page`
--

CREATE TABLE IF NOT EXISTS `user_page` (
  `idPage` int(11) NOT NULL,
  `nbClic` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `idVisite` int(11) NOT NULL,
  PRIMARY KEY (`idPage`,`idVisite`),
  KEY `idVisite` (`idVisite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `idGroup` int(11) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `login` (`login`),
  KEY `idGroup` (`idGroup`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUser`, `login`, `password`, `idGroup`) VALUES
(1, 'yoshi', '/9TFMXP/znbk1FbvArLhLnmTtesU77x9/IZz/8mf/C8=', 1),
(2, 'test', 'xSr7r5rEPjstSyTI0LzlvqdHAtMeq4sYvpKjywW4r+k=', 2),
(3, 'alex', '/9TFMXP/znbk1FbvArLhLnmTtesU77x9/IZz/8mf/C8=', 3);

-- --------------------------------------------------------

--
-- Structure de la table `visites`
--

CREATE TABLE IF NOT EXISTS `visites` (
  `idVisite` int(11) NOT NULL AUTO_INCREMENT,
  `adresseIp` varchar(25) CHARACTER SET utf8 NOT NULL,
  `dateConnexion` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idVisite`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=25 ;

--
-- Contenu de la table `visites`
--

INSERT INTO `visites` (`idVisite`, `adresseIp`, `dateConnexion`, `idUser`) VALUES
(8, '::1', '2013-12-03 20:27:55', 1),
(9, '::1', '2013-12-18 20:33:11', 1),
(10, '192.168.1.32', '2013-12-04 22:50:51', 1),
(11, '::1', '2013-12-18 22:55:32', 1),
(12, '192.168.1.32', '2013-12-18 23:11:14', 1),
(13, '::1', '2013-12-19 16:22:34', 1),
(14, '::1', '2013-12-20 06:37:29', 1),
(15, '192.168.1.50', '2013-12-21 11:07:27', 1),
(16, '192.168.1.53', '2013-12-21 12:15:45', 1),
(17, '::1', '2013-12-21 22:52:00', 1),
(18, '192.168.1.53', '2013-12-22 01:48:50', 1),
(19, '192.168.1.53', '2013-12-23 00:27:55', 1),
(20, '::1', '2013-12-23 00:31:10', 3),
(21, '192.168.1.53', '2013-12-23 16:00:48', 0),
(22, '::1', '2013-12-23 17:09:41', 0),
(23, '192.168.1.26', '2013-12-24 03:58:28', 0),
(24, '192.168.1.53', '2013-12-24 06:35:47', 0);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`artPageId`) REFERENCES `page` (`pageId`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `article_png` FOREIGN KEY (`artPngId`) REFERENCES `png` (`pngId`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `articleTest`
--
ALTER TABLE `articleTest`
  ADD CONSTRAINT `articleTest_png` FOREIGN KEY (`artPngId`) REFERENCES `png` (`pngId`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pageTest_article` FOREIGN KEY (`artPageId`) REFERENCES `pageTest` (`pageId`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`site`) REFERENCES `site` (`idSite`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `page_ibfk_1` FOREIGN KEY (`idSite`) REFERENCES `site` (`idSite`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `site`
--
ALTER TABLE `site`
  ADD CONSTRAINT `site_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `utilisateur` (`idUser`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `sousMenu`
--
ALTER TABLE `sousMenu`
  ADD CONSTRAINT `sousMenu_ibfk_1` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`idMenu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_page`
--
ALTER TABLE `user_page`
  ADD CONSTRAINT `user_page_ibfk_1` FOREIGN KEY (`idVisite`) REFERENCES `visites` (`idVisite`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `user_page_ibfk_2` FOREIGN KEY (`idPage`) REFERENCES `page` (`pageId`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`idGroup`) REFERENCES `groupes` (`idGroup`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
