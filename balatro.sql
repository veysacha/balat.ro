-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 27 mai 2024 à 13:23
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `balatro`
--

-- --------------------------------------------------------

--
-- Structure de la table `cartes`
--

DROP TABLE IF EXISTS `cartes`;
CREATE TABLE IF NOT EXISTS `cartes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `couleur` varchar(255) NOT NULL,
  `valeurs` text NOT NULL,
  `point` int NOT NULL,
  `chemin_img` text CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `cartes`
--

INSERT INTO `cartes` (`id`, `couleur`, `valeurs`, `point`, `chemin_img`) VALUES
(1, 'carreaux', '1', 11, 'img_cartes/1_carreaux.png'),
(2, 'coeur', '1', 11, 'img_cartes/1_coeur.png'),
(3, 'pique', '1', 11, 'img_cartes/1_pique.png'),
(4, 'trèfle', '1', 11, 'img_cartes/1_trefle.png'),
(5, 'carreaux', '2', 2, 'img_cartes/2_carreaux.png'),
(6, 'coeur', '2', 2, 'img_cartes/2_coeur.png'),
(7, 'pique', '2', 2, 'img_cartes/2_pique.png'),
(8, 'trèfle', '2', 2, 'img_cartes/2_trefle.png'),
(9, 'carreaux', '3', 3, 'img_cartes/3_carreaux.png'),
(10, 'coeur', '3', 3, 'img_cartes/3_coeur.png'),
(11, 'pique', '3', 3, 'img_cartes/3_pique.png'),
(12, 'trèfle', '3', 3, 'img_cartes/3_trefle.png'),
(13, 'carreaux', '4', 4, 'img_cartes/4_carreaux.png'),
(14, 'coeur', '4', 4, 'img_cartes/4_coeur.png'),
(15, 'pique', '4', 4, 'img_cartes/4_pique.png'),
(16, 'trèfle', '4', 4, 'img_cartes/4_trefle.png'),
(17, 'carreaux', '5', 5, 'img_cartes/5_carreaux.png'),
(18, 'coeur', '5', 5, 'img_cartes/5_coeur.png'),
(19, 'pique', '5', 5, 'img_cartes/5_pique.png'),
(20, 'trèfle', '5', 5, 'img_cartes/5_trefle.png'),
(21, 'carreaux', '6', 6, 'img_cartes/6_carreaux.png'),
(22, 'coeur', '6', 6, 'img_cartes/6_coeur.png'),
(23, 'pique', '6', 6, 'img_cartes/6_pique.png'),
(24, 'trèfle', '6', 6, 'img_cartes/6_trefle.png'),
(25, 'carreaux', '7', 7, 'img_cartes/7_carreaux.png'),
(26, 'Coeur', '7', 7, 'img_cartes/7_coeur.png'),
(27, 'pique', '7', 7, 'img_cartes/7_pique.png'),
(28, 'trefle', '7', 7, 'img_cartes/7_trefle.png'),
(29, 'carreaux', '8', 8, 'img_cartes/8_carreaux.png'),
(30, 'coeur', '8', 8, 'img_cartes/8_coeur.png'),
(31, 'pique', '8', 8, 'img_cartes/8_pique.png'),
(32, 'trefle', '8', 8, 'img_cartes/8_trefle.png'),
(33, 'carreaux', '9', 9, 'img_cartes/9_carreaux.png'),
(34, 'coeur', '9', 9, 'img_cartes/9_coeur.png'),
(35, 'pique', '9', 9, 'img_cartes/9_pique.png'),
(36, 'trefle', '9', 9, 'img_cartes/9_trefle.png'),
(37, 'carreaux', '10', 10, 'img_cartes/10_carreaux.png'),
(38, 'coeur', '10', 10, 'img_cartes/10_coeur.png'),
(39, 'pique', '10', 10, 'img_cartes/10_pique.png'),
(40, 'trefle', '10', 10, 'img_cartes/10_trefle.png'),
(42, 'carreaux', 'dame', 10, 'img_cartes/dame_carreaux.png'),
(43, 'coeur', 'dame', 10, 'img_cartes/dame_coeur.png'),
(44, 'pique', 'dame', 10, 'img_cartes/dame_pique.png'),
(45, 'trefle', 'dame', 10, 'img_cartes/dame_trefle.png'),
(46, 'carreaux', 'roi', 10, 'img_cartes/roi_carreaux.png'),
(47, 'coeur', 'roi', 10, 'img_cartes/roi_coeur.png'),
(48, 'pique', 'roi', 10, 'img_cartes/roi_pique.png'),
(49, 'trefle', 'roi', 10, 'img_cartes/roi_trefle.png'),
(50, 'carreaux', 'valet', 10, 'img_cartes/valet_carreaux.png'),
(51, 'coeur', 'valet', 10, 'img_cartes/valet_coeur.png'),
(52, 'pique', 'valet', 10, 'img_cartes/valet_pique.png'),
(53, 'trefle', 'valet', 10, 'img_cartes/valet_trefle.png');

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `chemin` varchar(255) NOT NULL,
  `type` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `mains_poker`
--

DROP TABLE IF EXISTS `mains_poker`;
CREATE TABLE IF NOT EXISTS `mains_poker` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `niveau` int NOT NULL,
  `jetons` int NOT NULL,
  `multiplicateur` int NOT NULL,
  `ajoutJetonsParNiveau` int NOT NULL,
  `ajoutMultiParNiveau` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `auteur` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `heure` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `auteur`, `message`, `heure`) VALUES
(52, 'admin', 'test panel admin\r\n', '2024-04-19 10:25:38'),
(42, 'admin', 'a la cool\r\n', '2024-04-10 08:47:23'),
(41, 'admin', 'comment ba ?\r\n', '2024-04-05 13:46:42'),
(40, 'admin', 'bonjour', '2024-04-05 13:46:35'),
(54, 'user_test', 'Salut', '2024-05-22 12:32:01');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `biographie` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` text NOT NULL,
  `main_pref` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `chemin_photo` varchar(255) NOT NULL DEFAULT '../img_profil/img_par_defaut.png',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `pseudo`, `biographie`, `email`, `mot_de_passe`, `main_pref`, `admin`, `chemin_photo`) VALUES
(2, 'admin', '', 'admin@admin.com', '$2y$10$Kd.9UXsUQqjo.DFWpVYc4eEF1KSeZp94OtUP8NggP41uWADlr1Bra', '', 1, '../img_profil/img_par_defaut.png'),
(3, 'user_test', '', 'user@user.com', '$2y$10$y0XMUp5ZutKCCEFIEkW.9eZXdUlFxu.gMxEEygoXuKaTadJWfkNoe', '', 0, '../img_profil/img_par_defaut.png'),
(7, 'nieeeeeehhh', '', 'nieh@copains-davant.com', '$2y$10$Z6fyXaAZ2RCuN9O0ewVSYOR8UxOLKhcMuJ7d13av2JFwGDK5x/SYS', '', 0, '../img_profil/img_par_defaut.png'),
(8, 'balatro.dev', '', 'balat@dev.com', '$2y$10$6HAHG9IaiFSaei62opziNesQm6.lUCaxRm.xDx3TI5IJKgoAQ8DEu', '', 0, '../img_profil/img_par_defaut.png'),
(9, 'agent-de-la-CIA', '', 'agent007@cia.gov', '$2y$10$HdbFh37wPOFaXOqABmgzjec7bfHW64Mvz/50ckeHgivU0SeXQbbKe', '', 0, '../img_profil/img_par_defaut.png'),
(10, 'natanael', '', 'natanael@natnat.com', '$2y$10$NOiZ9nESOnxhAH1bXGKlo.E8.eyGzH51ZiWX0Bontx2c8KxmE/Lru', '', 0, '../img_profil/img_par_defaut.png'),
(11, 'azerty', '', 'azerty@azerty.com', '$2y$10$pTVNqFb/8wYTVWaD0ynT6eSKZ3GVS0PTtEDriiRic0/6j.QQ5lQPa', '', 0, '../img_profil/img_par_defaut.png'),
(12, 'hellowork', '', 'hellowork@workhello.com', '$2y$10$t5rtMgV5aVIKNtAQpWHPFu5jOdl70vutJe5M34SpVpU6zXi.i.oPm', '', 0, '../img_profil/img_par_defaut.png'),
(14, 'kiila', '', 'killa@vkontakte.ru', '$2y$10$pa2TKrxP799i9.9KzHtYUesyfc0CQSqPpKSmj1gRQ77TxzFJPP572', '', 0, '../img_profil/img_par_defaut.png'),
(15, 'regs', '', 'regs@vkontakte.ru', '$2y$10$HFWCiRcynSGHbZFlJPZP2.xj.svAybhxYFXYizSOAizxngV2Grz02', '', 0, '../img_profil/img_par_defaut.png'),
(16, 'yihk', '', 'yihk@vkontakte.ru', '$2y$10$jplVPDxPUieSC7Y8lW01c.SNNQSST/urjZIwzKi/Ui3sSCMtfndfO', '', 0, '../img_profil/img_par_defaut.png'),
(17, 'qsddf', '', 'qsddf@vkontakte.ru', '$2y$10$U1VGq/bmuMpHcy1Ka.NoX.XkCSIOCZH4wbBqNGnMMYZpDqtS81AuS', '', 0, '../img_profil/img_par_defaut.png'),
(18, 'bipbop', '', 'bipbop@etlecowboy.com', '$2y$10$rMs81WA3Hx6qRzG14V6PSeui7uv47bdrnzHmisLefFcgvVIoi98za', '', 0, '../img_profil/img_par_defaut.png'),
(19, 'axel', '', 'axel@unijambiste.com', '$2y$10$.57HPP9WB42AiVQ4Uc9xgOcJRyAD5taTwzBy4SOUWVNoITV0Yq7py', '', 0, '../img_profil/img_par_defaut.png'),
(20, 'hormann', '', 'hormann@ramasseurdemegot.com', '$2y$10$PpZTG14WVl1bGPtZHEqH/ehf2ch60WWcPvrDTxftpWc.klW7Sqofu', '', 0, '../img_profil/img_par_defaut.png'),
(21, 'chine', '', 'chine@chine.ch', '$2y$10$GTixANwASyOCnoxOubku9u8uCc/FiZlBOwvJg6vTkfR1MaSsOyxB.', '', 0, '../img_profil/img_par_defaut.png'),
(22, 'pseudo', '', 'email@email.com', '$2y$10$8tagrZqt78H6tilzSMJqkeywCk8o6ZpaxndXTs7tLF0F1QwLhCyoq', '', 0, '../img_profil/img_par_defaut.png'),
(23, 'france', '', 'france@france.com', '$2y$10$L37fA9dED4vzZARyNn2Bo.VoUcp45Wn8iZGalV9aRvyVBtIgm8N9q', '', 0, '../img_profil/img_par_defaut.png'),
(24, 'chili', '', 'chili@chili.com', '$2y$10$BXRGHevKz6aE2MU0JslbPeGBJwXB4mwk915Y/cHRy4pyVb1e.RdTe', '', 0, '../img_profil/img_par_defaut.png'),
(25, 'egypte', '', 'egypte@egypte.com', '$2y$10$2zgyxWCBl9RUy.4ovz/7.uh3z2HAbdSbAMZroufW.b8YnCJJXIc9q', '', 0, '../img_profil/img_par_defaut.png'),
(26, 'travle', '', 'travle@travle.com', '$2y$10$o1iMokoGSjcy47PwFWYWtu//zRQVGvTIMtx6bVeQOZ/GCx/IFPAEy', '', 0, '../img_profil/img_par_defaut.png'),
(27, 'jetpunk', '', 'jetpunk@jetjet.com', '$2y$10$B.wj5ERipMQ12uaOa3VrgOv4VbkPEgnVcEmEASqN.0BhaMLRDuchq', '', 0, '../img_profil/img_par_defaut.png'),
(28, 'legoat', '', 'legoat@lachevre.com', '$2y$10$Jrx52QhzzkgasSATtU7AnOMjGjY1hcxYCeCMHY8Pxe0VpvThROpKO', '', 0, '../img_profil/img_par_defaut.png'),
(29, 'danemark', '', 'danemark@dan.com', '$2y$10$NtpeA6/e39LZWw.Tto0SR.k8CpTSRapdr/aKvedribaDLyXR5PN6O', '', 0, '../img_profil/img_par_defaut.png'),
(30, 'inscription', '', 'inscription@ins.com', '$2y$10$GgPdztGA8RHEa/yJQZDXOeBcOqcKwKXSzZvorEQcgAcCzWab1LYUm', '', 0, '../img_profil/img_par_defaut.png'),
(31, 'sdf', '', 'sdf@sdf.com', '$2y$10$cKIAWb9nUWnBACcR/GPfyOpBnAvq2Vf4lDl91OdMGFBIkiRR5SFtC', '', 0, '../img_profil/img_par_defaut.png'),
(32, 'sdt', '', 'sdt@sdt.com', '$2y$10$wjzs7TyBV9EzNtbGl1J1GeTPHQxYptY0mfu1nCIyLL4ZlvHgtjPqi', '', 0, '../img_profil/img_par_defaut.png'),
(33, 'chypre', '', 'chypre@chypre.tv', '$2y$10$wdK./CumIQHBkwpUwoIDC.KGxHI8TPVHqXv/yOEDL2glL6FPlzaui', '', 0, '../img_profil/img_par_defaut.png'),
(34, 'jul', '', 'jul@jul.com', '$2y$10$.xNtdS91ECUlocL0n6Rp/.By7hVxgLmQ0H0M/aEsNSFZ2MqiJQlZG', '', 0, '../img_profil/img_par_defaut.png'),
(35, 'msi', '', 'msi@msi.com', '$2y$10$fDiRBAA.zvErBYrFMmk0a.Jfgz7ByrRcC8WdUdzWsZHLUEYJw10Mq', '', 0, '../img_profil/img_par_defaut.png'),
(36, 'flatearth', '', 'flatearth@flat.com', '$2y$10$gQlxMlNUZ5mXoy7SrnD76eWf4qI2W5E1IiP2ZGRX8tUYJt0YCUi9S', '', 0, '../img_profil/img_par_defaut.png'),
(37, 'pauvre', '', 'pauvre@argent.com', '$2y$10$wVegXS6wOAqsKw8.4bgWxOhYAC6ngVEhVWzars7y2ETpyA0d278v2', '', 0, '../img_profil/img_par_defaut.png'),
(38, 'velo', '', 'velo@ciraptor', '$2y$10$CKz4Gre9.5o.oDAcaT8P/Op.xkf8ZkCM8Z3w8oLcvGOcByAilUesK', '', 0, '../img_profil/img_par_defaut.png'),
(39, 'subsonique', '', 'subsonique@avion.com', '$2y$10$s1zc0dp2kK6iOZO6G5PtUedUPHQYJrm9E5WlJVKx9wFLeZLkLwTx.', '', 0, '../img_profil/img_par_defaut.png'),
(40, 'turquie', '', 'turquie@tuture.com', '$2y$10$tMbXJ7AOuZkAS77BWbl3e.FYu4qmxK5CXCc71qqgB783yQZvbcLoe', '', 0, '../img_profil/img_par_defaut.png'),
(41, 'qsdfghj', '', 'qsdfgh@QSSG.com', '$2y$10$1IK6MRslYxWFQZlYA/2DAuPxxdM6dkdKajL5eLrp9EzFgZ6AuE2Zm', '', 0, '../img_profil/img_par_defaut.png');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
