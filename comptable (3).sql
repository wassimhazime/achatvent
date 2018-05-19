-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  sam. 19 mai 2018 à 09:46
-- Version du serveur :  10.2.14-MariaDB
-- Version de PHP :  7.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `comptable`
--

-- --------------------------------------------------------

--
-- Structure de la table `achat`
--

CREATE TABLE `achat` (
  `id` int(10) NOT NULL,
  `montant_paye_TTC` double NOT NULL,
  `mode$paiement` int(11) NOT NULL,
  `N_mode` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `remarque` text DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL,
  `raison$sociale` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `achat`
--

INSERT INTO `achat` (`id`, `montant_paye_TTC`, `mode$paiement`, `N_mode`, `date`, `image`, `remarque`, `date_ajoute`, `date_modifier`, `raison$sociale`) VALUES
(22, 3000, 124, 'uduud', '2018-05-10', NULL, '', '2018-05-08 12:10:26', '2018-05-08 12:10:26', 24),
(23, 5666, 125, 'TTYTY', '2018-06-29', NULL, '', '2018-05-08 12:10:26', '2018-05-08 12:10:26', 24),
(24, 12, 123, 'jj', '2018-05-09', NULL, NULL, '2018-05-08 23:10:11', '2018-05-08 23:10:11', 24),
(25, 2323, 123, 'kn;nj;k', '2018-05-09', NULL, NULL, '2018-05-08 23:10:11', '2018-05-08 23:10:11', 24),
(26, 213, 123, '213', '2018-05-09', NULL, NULL, '2018-05-08 23:11:07', '2018-05-08 23:11:07', 24),
(27, 213, 123, '213b', '2018-05-09', NULL, NULL, '2018-05-08 23:11:07', '2018-05-08 23:11:07', 24),
(28, 3, 123, 'j', '2018-05-09', NULL, '', '2018-05-08 23:17:06', '2018-05-08 23:17:06', 24),
(29, 7777777, 123, 'hhkhk', '2018-05-09', NULL, 'ok', '2018-05-09 16:36:49', '2018-05-09 16:36:49', 24),
(30, 444, 123, '666', '2018-05-01', NULL, '', '2018-05-09 18:16:27', '2018-05-09 18:16:27', 24),
(31, 446, 127, '899', '2018-05-02', NULL, '', '2018-05-09 18:16:27', '2018-05-09 18:16:27', 24),
(32, 445, 125, '890', '2018-05-03', NULL, '', '2018-05-09 18:16:27', '2018-05-09 18:16:27', 24),
(33, 447, 125, '134', '2018-05-04', NULL, '', '2018-05-09 18:16:27', '2018-05-09 18:16:27', 24),
(34, 67, 123, 'hhh', '2018-05-01', NULL, '', '2018-05-09 18:18:55', '2018-05-09 18:18:55', 24),
(35, 68, 123, '', '2018-05-02', NULL, '', '2018-05-09 18:18:55', '2018-05-09 18:18:55', 24),
(36, 566, 123, '', '2018-05-03', NULL, '', '2018-05-09 18:18:55', '2018-05-09 18:18:55', 24),
(37, 66666666, 123, 'hhhh', '2018-05-09', NULL, 'jjj', '2018-05-09 18:42:01', '2018-05-09 18:42:01', 24),
(38, 8999, 123, 'UJH', '2018-05-09', NULL, 'jjj', '2018-05-09 18:42:01', '2018-05-09 18:42:01', 24),
(39, 66666666, 123, 'GH', '2018-05-09', NULL, 'jjj', '2018-05-09 18:42:01', '2018-05-09 18:42:01', 24),
(40, 66, 123, 'hhhh', '2018-05-09', NULL, 'jjj', '2018-05-09 18:42:01', '2018-05-09 18:42:01', 24),
(41, 777777, 123, 'klkl', '2018-05-11', NULL, '', '2018-05-11 16:36:03', '2018-05-11 16:36:03', 24),
(42, 15, 123, 'jjjiii', '2018-05-10', NULL, '', '2018-05-11 16:37:44', '2018-05-11 16:37:44', 24),
(43, 99, 123, 'jj', '2018-05-11', NULL, '', '2018-05-11 16:53:14', '2018-05-11 16:53:14', 24),
(44, 287777777, 123, 'uukjk', '2018-05-17', NULL, '', '2018-05-15 15:16:25', '2018-05-15 15:16:25', 24);

-- --------------------------------------------------------

--
-- Structure de la table `achats`
--

CREATE TABLE `achats` (
  `id` int(10) NOT NULL,
  `raison$sociale` int(11) NOT NULL,
  `date_negociation` date NOT NULL,
  `montant_factures_TTC` double NOT NULL,
  `montant_avoirs_TTC` double NOT NULL DEFAULT 0,
  `Reglement_TTC` double NOT NULL DEFAULT 0,
  `remarque` text DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `achats`
--

INSERT INTO `achats` (`id`, `raison$sociale`, `date_negociation`, `montant_factures_TTC`, `montant_avoirs_TTC`, `Reglement_TTC`, `remarque`, `date_ajoute`, `date_modifier`) VALUES
(221, 24, '2018-05-09', 6666, 0, 6666, '', '2018-05-09 18:06:34', '2018-05-09 18:06:34'),
(222, 24, '2018-05-09', 6666, 0, 6666, '', '2018-05-09 18:06:39', '2018-05-09 18:06:39'),
(223, 24, '2018-05-09', 6666, 0, 6666, '', '2018-05-09 18:15:20', '2018-05-09 18:15:20'),
(224, 24, '2018-05-09', 6666, 0, 6666, '', '2018-05-09 18:17:42', '2018-05-09 18:17:42'),
(225, 24, '2018-05-09', 6666, 0, 6666, '', '2018-05-09 18:20:07', '2018-05-09 18:20:07'),
(226, 24, '2018-05-09', 6666, 0, 6666, '', '2018-05-09 18:21:59', '2018-05-09 18:21:59'),
(227, 24, '2018-05-09', 6666, 0, 6666, '', '2018-05-09 18:22:08', '2018-05-09 18:22:08'),
(228, 24, '2018-05-09', 6666, 0, 6666, '', '2018-05-09 18:23:36', '2018-05-09 18:23:36'),
(229, 24, '2018-05-09', 6666, 0, 6666, '', '2018-05-09 18:25:12', '2018-05-09 18:25:12'),
(230, 24, '2018-05-09', 6666, 0, 6666, '', '2018-05-09 18:25:41', '2018-05-09 18:25:41'),
(231, 24, '2018-05-09', 6666, 0, 6666, '', '2018-05-09 18:40:35', '2018-05-09 18:40:35'),
(232, 24, '2018-05-09', 6666, 0, 6666, '', '2018-05-09 18:41:12', '2018-05-09 18:41:12'),
(233, 24, '2018-05-11', 1111, 0, 1111, '', '2018-05-09 18:52:31', '2018-05-09 18:52:31'),
(234, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 15:45:03', '2018-05-11 15:45:03'),
(235, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 15:54:24', '2018-05-11 15:54:24'),
(236, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 15:58:31', '2018-05-11 15:58:31'),
(237, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 15:59:53', '2018-05-11 15:59:53'),
(238, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:00:44', '2018-05-11 16:00:44'),
(239, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:16:36', '2018-05-11 16:16:36'),
(240, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:17:25', '2018-05-11 16:17:25'),
(241, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:17:36', '2018-05-11 16:17:36'),
(242, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:33:38', '2018-05-11 16:33:38'),
(243, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:34:37', '2018-05-11 16:34:37'),
(244, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:35:12', '2018-05-11 16:35:12'),
(245, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:35:44', '2018-05-11 16:35:44'),
(246, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:36:27', '2018-05-11 16:36:27'),
(247, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:36:30', '2018-05-11 16:36:30'),
(248, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:37:19', '2018-05-11 16:37:19'),
(249, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:38:41', '2018-05-11 16:38:41'),
(250, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:38:43', '2018-05-11 16:38:43'),
(251, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:40:17', '2018-05-11 16:40:17'),
(252, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:42:10', '2018-05-11 16:42:10'),
(253, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:44:23', '2018-05-11 16:44:23'),
(254, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:44:59', '2018-05-11 16:44:59'),
(255, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:45:38', '2018-05-11 16:45:38'),
(256, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:47:08', '2018-05-11 16:47:08'),
(257, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:47:40', '2018-05-11 16:47:40'),
(258, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:48:17', '2018-05-11 16:48:17'),
(259, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:49:30', '2018-05-11 16:49:30'),
(260, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:50:00', '2018-05-11 16:50:00'),
(261, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:50:27', '2018-05-11 16:50:27'),
(262, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:51:14', '2018-05-11 16:51:14'),
(263, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:51:37', '2018-05-11 16:51:37'),
(264, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 16:59:20', '2018-05-11 16:59:20'),
(265, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 17:09:22', '2018-05-11 17:09:22'),
(266, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 17:10:01', '2018-05-11 17:10:01'),
(267, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 17:13:02', '2018-05-11 17:13:02'),
(268, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 17:16:55', '2018-05-11 17:16:55'),
(269, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 17:19:47', '2018-05-11 17:19:47'),
(270, 24, '2018-05-10', 77777, 78, 77699, '', '2018-05-11 17:20:51', '2018-05-11 17:20:51'),
(271, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 17:26:19', '2018-05-11 17:26:19'),
(272, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 17:27:28', '2018-05-11 17:27:28'),
(273, 24, '2018-05-10', 77777, 78, 77699, '', '2018-05-11 17:28:38', '2018-05-11 17:28:38'),
(274, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 17:29:10', '2018-05-11 17:29:10'),
(275, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 17:29:46', '2018-05-11 17:29:46'),
(276, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 17:31:52', '2018-05-11 17:31:52'),
(277, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 17:32:25', '2018-05-11 17:32:25'),
(278, 24, '2018-05-11', 1111111, 674799, 436312, '', '2018-05-11 17:33:39', '2018-05-11 17:33:39'),
(279, 24, '2018-05-11', 23, 0, 23, '', '2018-05-11 17:51:17', '2018-05-11 17:51:17'),
(280, 24, '2018-05-15', 15645025, 1424, 15643601, '', '2018-05-15 15:15:57', '2018-05-15 15:15:57');

-- --------------------------------------------------------

--
-- Structure de la table `avoirs$achats`
--

CREATE TABLE `avoirs$achats` (
  `id` int(10) NOT NULL,
  `raison$sociale` int(11) NOT NULL,
  `N` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `montant_avoirs_HT` double NOT NULL,
  `montant_avoirs_TVA` double NOT NULL,
  `montant_avoirs_TTC` double NOT NULL,
  `les_articles` text DEFAULT NULL,
  `remarque` text DEFAULT NULL,
  `image` varchar(250) DEFAULT 'image.jpg',
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `avoirs$achats`
--

INSERT INTO `avoirs$achats` (`id`, `raison$sociale`, `N`, `date`, `montant_avoirs_HT`, `montant_avoirs_TVA`, `montant_avoirs_TTC`, `les_articles`, `remarque`, `image`, `date_ajoute`, `date_modifier`) VALUES
(11, 24, '7880', '2018-05-06', 6778, 1355.6, 8133.6, '', '', 'image.jpg', '2018-05-06 19:31:18', '2018-05-09 14:27:16'),
(12, 24, 'kkl', '2018-05-09', 555555, 111111, 666666, '', '', 'image.jpg', '2018-05-09 14:28:06', '2018-05-09 14:28:06'),
(17, 24, 'iii', '2018-05-09', 888, 177.6, 1065.6, '', '', 'image.jpg', '2018-05-09 15:39:35', '2018-05-09 15:39:35'),
(20, 24, 'ok java script', '2018-05-09', 299, 59.8, 358.8, '', '', 'image.jpg', '2018-05-09 16:27:40', '2018-05-09 16:27:40');

-- --------------------------------------------------------

--
-- Structure de la table `bons$achats`
--

CREATE TABLE `bons$achats` (
  `id` int(10) NOT NULL,
  `raison$sociale` int(11) NOT NULL,
  `N` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `montant_HT` double NOT NULL,
  `montant_TVA` double NOT NULL,
  `montant_TTC` double NOT NULL,
  `adresse` text DEFAULT NULL,
  `remarque` text DEFAULT NULL,
  `image` varchar(250) DEFAULT '''image.jpg''',
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bons$achats`
--

INSERT INTO `bons$achats` (`id`, `raison$sociale`, `N`, `date`, `montant_HT`, `montant_TVA`, `montant_TTC`, `adresse`, `remarque`, `image`, `date_ajoute`, `date_modifier`) VALUES
(76, 24, 'ulo098', '2018-05-26', 24140.63, 4828.13, 28968.76, 'tafchna', '', '\'image.jpg\'', '2018-05-06 19:25:26', '2018-05-06 19:25:26'),
(77, 24, 'UIY7', '2018-05-06', 78890.98, 15778.2, 94669.18, '', '', '\'image.jpg\'', '2018-05-06 19:25:56', '2018-05-06 19:25:56'),
(78, 24, 'bm', '2018-05-06', 30766.39, 1522, 32288.39, '', '', '\'image.jpg\'', '2018-05-06 21:13:47', '2018-05-06 21:13:47'),
(79, 24, 'ok test shado', '2018-05-09', 12800888, 2560177.6, 15361065.6, 'ok sahad ss', 'ok', '\'image.jpg\'', '2018-05-09 14:59:31', '2018-05-09 14:59:31'),
(80, 24, 'jkkk', '2018-05-18', 686879879, 137375975.8, 824255854.8, 'hjhj', 'hhkjh', '\'image.jpg\'', '2018-05-18 01:17:19', '2018-05-18 01:17:19');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(10) NOT NULL,
  `clients` varchar(200) NOT NULL,
  `cin` varchar(200) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `image` varchar(250) DEFAULT '''image.jpg''',
  `commentaires_remarque` text DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(10) NOT NULL,
  `raison$sociale` int(11) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `montant_estime_HT` double NOT NULL,
  `adresse` text DEFAULT NULL,
  `remarque` text DEFAULT NULL,
  `image` varchar(250) DEFAULT 'image.jpg',
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `raison$sociale`, `titre`, `date`, `montant_estime_HT`, `adresse`, `remarque`, `image`, `date_ajoute`, `date_modifier`) VALUES
(78, 24, 'bmolk', '2018-05-01', 1234567890, 'nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.', 'nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.nstead of applying button sizing classes to every button in a group, just add .btn-group-* to each .btn-group, including when nesting multiple groups.', 'image.jpg', '2018-05-06 19:18:10', '2018-05-19 02:36:40'),
(79, 24, 'zagora', '2018-05-01', 8796.09, 'zagora', '', 'image.jpg', '2018-05-06 19:18:53', '2018-05-06 19:18:53'),
(80, 24, 'warzaza', '2018-05-02', 7654.89, 'warzazat', '', 'image.jpg', '2018-05-06 19:19:33', '2018-05-06 19:19:33'),
(81, 24, 'aforar', '2018-04-13', 8796.99, 'aforar', '', 'image.jpg', '2018-05-06 19:20:16', '2018-05-06 19:20:16'),
(82, 24, 'mahal', '2018-05-06', 8976.87, 'souk sabt', '', 'image.jpg', '2018-05-06 19:20:44', '2018-05-06 19:20:44'),
(83, 24, 'mahal', '2018-05-07', 6789.98, 'souk sabt', '', 'image.jpg', '2018-05-06 19:21:15', '2018-05-06 19:21:15'),
(84, 24, 'projet tafchna', '2018-05-11', 7689.65, 'tafchna', '', 'image.jpg', '2018-05-06 19:21:57', '2018-05-06 19:21:57'),
(85, 25, 'bm', '2018-05-19', 789.9, 'bm', '', 'image.jpg', '2018-05-06 21:08:24', '2018-05-06 21:08:24'),
(86, 24, 'aforar', '2018-05-17', 12333.09, 'bm', '', 'image.jpg', '2018-05-06 21:09:56', '2018-05-06 21:09:56'),
(87, 24, 'hk', '2018-05-24', 23433.3, '', '', 'image.jpg', '2018-05-06 21:12:08', '2018-05-06 21:12:08'),
(88, 24, 'PPP', '2018-05-07', 5, '', '', 'image.jpg', '2018-05-07 16:06:00', '2018-05-07 16:06:00'),
(89, 24, 'jjjj', '2018-05-09', 99999, '', '', 'image.jpg', '2018-05-09 09:19:52', '2018-05-09 09:19:52'),
(90, 24, 'ZZZZ', '2018-05-09', 123456789, '', '', 'image.jpg', '2018-05-09 10:32:04', '2018-05-09 10:32:04'),
(91, 24, 'test box shado', '2018-05-09', 4444455, 'hay almassira hha ', 'test ta3 box shado', 'image.jpg', '2018-05-09 14:54:32', '2018-05-09 14:54:32'),
(92, 24, 'okll', '2018-05-18', 26, '\"\"\'\'', '\"\'\"\'', 'image.jpg', '2018-05-18 01:12:24', '2018-05-18 01:12:24'),
(93, 24, 'ikjkj', '2018-05-18', 15, 'Ã¨Ã§_Ã§', 'Ã¨Ã§t-Ã§Ã§', 'image.jpg', '2018-05-18 01:15:20', '2018-05-18 01:15:20'),
(94, 24, 'okl', '2018-05-18', 67788, 'ok', 'ok', 'image.jpg', '2018-05-18 23:29:44', '2018-05-18 23:29:44'),
(95, 24, 'kol', '2018-05-18', 6789, '', '', 'image.jpg', '2018-05-18 23:37:21', '2018-05-18 23:37:21'),
(96, 24, 'kjkj', '2018-05-18', 7890, '', '', 'image.jpg', '2018-05-18 23:38:08', '2018-05-18 23:38:08'),
(97, 24, 'jkl', '2018-05-18', 345678, '', '', 'image.jpg', '2018-05-18 23:38:55', '2018-05-18 23:38:55'),
(98, 24, 'hjhk', '2018-05-18', 2345678, '', '', 'image.jpg', '2018-05-18 23:39:39', '2018-05-18 23:39:39');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) NOT NULL,
  `raison$sociale` int(11) NOT NULL,
  `Prenom` varchar(201) NOT NULL,
  `Nom` varchar(201) NOT NULL,
  `TELE` varchar(20) NOT NULL,
  `GSM` varchar(20) DEFAULT NULL,
  `Fonction` varchar(201) DEFAULT NULL,
  `Email` varchar(150) DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

CREATE TABLE `devis` (
  `id` int(10) NOT NULL,
  `clients` int(11) NOT NULL,
  `titre` varchar(200) DEFAULT NULL,
  `date` date NOT NULL,
  `montant_HT` double NOT NULL,
  `montant_TVA` double NOT NULL,
  `montant_TTC` double NOT NULL,
  `remarque` text DEFAULT NULL,
  `image` varchar(250) NOT NULL DEFAULT 'image.jpg',
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `factures$achats`
--

CREATE TABLE `factures$achats` (
  `id` int(10) NOT NULL,
  `raison$sociale` int(11) NOT NULL,
  `N` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `montant_HT` double NOT NULL,
  `montant_TVA` double NOT NULL,
  `montant_TTC` double NOT NULL,
  `remarque` text DEFAULT NULL,
  `image` varchar(250) DEFAULT 'image.jpg',
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `factures$achats`
--

INSERT INTO `factures$achats` (`id`, `raison$sociale`, `N`, `date`, `montant_HT`, `montant_TVA`, `montant_TTC`, `remarque`, `image`, `date_ajoute`, `date_modifier`) VALUES
(23, 24, 'F 7899', '2018-05-06', 22767.75, 3553.55, 26321.3, '', 'image.jpg', '2018-05-06 19:27:27', '2018-05-06 19:27:27'),
(24, 24, '890', '2018-05-06', 6789.89, 1357.98, 8147.87, '', 'image.jpg', '2018-05-06 19:27:52', '2018-05-06 19:27:52'),
(25, 24, 'ji99999', '2018-05-06', 103031.61, 20606.33, 123637.94, '', 'image.jpg', '2018-05-06 19:28:13', '2018-05-06 19:28:13'),
(27, 24, '789JJ', '2018-05-06', 77970, 15594, 93564, '', 'image.jpg', '2018-05-06 19:29:04', '2018-05-06 19:29:04'),
(28, 24, '', '2018-05-06', 30766.39, 1522, 32288.39, '', 'image.jpg', '2018-05-06 21:14:39', '2018-05-06 21:14:39'),
(29, 24, 'box shado', '2018-05-09', 12800888, 2560177.6, 15361065.6, 'ok', 'image.jpg', '2018-05-09 15:00:32', '2018-05-09 15:00:32');

-- --------------------------------------------------------

--
-- Structure de la table `factures$ventes`
--

CREATE TABLE `factures$ventes` (
  `id` int(10) NOT NULL,
  `clients` int(11) NOT NULL,
  `N` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `titre` varchar(200) NOT NULL,
  `montant_HT` double NOT NULL,
  `montant_TVA` double NOT NULL,
  `montant_TTC` double NOT NULL,
  `image` varchar(250) NOT NULL DEFAULT 'image.jpg',
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `mode$paiement`
--

CREATE TABLE `mode$paiement` (
  `id` int(10) NOT NULL,
  `mode$paiement` varchar(200) NOT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mode$paiement`
--

INSERT INTO `mode$paiement` (`id`, `mode$paiement`, `date_ajoute`, `date_modifier`) VALUES
(123, 'EspÃ¨cer', '2018-04-15 22:38:04', '2018-05-18 00:09:51'),
(124, 'Virement', '2018-04-15 22:38:22', '2018-04-15 22:38:22'),
(125, 'Carte de crÃ©dit', '2018-04-15 22:38:43', '2018-04-15 22:38:43'),
(127, 'PrÃ©lÃ¨vement', '2018-04-15 22:39:16', '2018-05-18 00:49:16'),
(165, 'ok', '2018-05-18 01:08:59', '2018-05-18 01:08:59'),
(170, 'sx', '2018-05-18 02:31:49', '2018-05-18 02:31:49'),
(171, 'jkkk', '2018-05-18 02:32:51', '2018-05-18 02:32:51'),
(172, 'kjk', '2018-05-18 02:34:11', '2018-05-18 02:34:11');

-- --------------------------------------------------------

--
-- Structure de la table `raison$sociale`
--

CREATE TABLE `raison$sociale` (
  `id` int(10) NOT NULL,
  `raison$sociale` varchar(200) NOT NULL,
  `ICE` varchar(200) NOT NULL,
  `I_F` varchar(201) NOT NULL,
  `T_P` varchar(201) NOT NULL,
  `R_C` varchar(201) NOT NULL,
  `CNSS` varchar(200) NOT NULL,
  `TELE1` varchar(20) NOT NULL,
  `TELE2` varchar(20) DEFAULT NULL,
  `GSM` varchar(20) DEFAULT NULL,
  `FAX` varchar(20) DEFAULT NULL,
  `site_web` varchar(200) DEFAULT NULL,
  `EMAIL` varchar(150) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `image` varchar(250) DEFAULT 'image.jpj',
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `raison$sociale`
--

INSERT INTO `raison$sociale` (`id`, `raison$sociale`, `ICE`, `I_F`, `T_P`, `R_C`, `CNSS`, `TELE1`, `TELE2`, `GSM`, `FAX`, `site_web`, `EMAIL`, `adresse`, `image`, `date_ajoute`, `date_modifier`) VALUES
(24, 'bci', 'ice de bci', 'if de bci', 'ip de bci', 'rc de bci', 'cnss de bci', '1234567890', '', '', '', '', '', '', 'image.jpj', '2018-04-15 22:32:37', '2018-04-30 15:39:16'),
(25, 'cmgp', 'ice de cmgp', 'if de cmgp', 'tp  de cmgp', 'RC  de cmgp', 'cnss  de cmgp', '4567890', '', '', '', '', '', '', 'image.jpj', '2018-04-15 22:33:01', '2018-04-15 22:33:01'),
(30, 'ok', '', '', '', '', '', '', '', '', '', '', '', '', 'image.jpj', '2018-05-19 03:46:03', '2018-05-19 03:47:03');

-- --------------------------------------------------------

--
-- Structure de la table `r_achats_achat`
--

CREATE TABLE `r_achats_achat` (
  `id_achats` int(11) NOT NULL,
  `id_achat` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `r_achats_achat`
--

INSERT INTO `r_achats_achat` (`id_achats`, `id_achat`, `remarque`) VALUES
(223, 30, NULL),
(223, 31, NULL),
(223, 32, NULL),
(223, 33, NULL),
(224, 34, NULL),
(224, 35, NULL),
(224, 36, NULL),
(232, 37, NULL),
(232, 38, NULL),
(232, 39, NULL),
(232, 40, NULL),
(245, 41, NULL),
(248, 42, NULL),
(263, 43, NULL),
(280, 44, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `r_achats_avoirs$achats`
--

CREATE TABLE `r_achats_avoirs$achats` (
  `id_achats` int(11) NOT NULL,
  `id_avoirs$achats` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `r_achats_avoirs$achats`
--

INSERT INTO `r_achats_avoirs$achats` (`id_achats`, `id_avoirs$achats`, `remarque`) VALUES
(234, 11, NULL),
(234, 12, NULL),
(235, 11, NULL),
(235, 12, NULL),
(236, 11, NULL),
(236, 12, NULL),
(237, 11, NULL),
(237, 12, NULL),
(238, 11, NULL),
(238, 12, NULL),
(239, 11, NULL),
(239, 12, NULL),
(240, 11, NULL),
(240, 12, NULL),
(241, 11, NULL),
(241, 12, NULL),
(242, 11, NULL),
(242, 12, NULL),
(243, 11, NULL),
(243, 12, NULL),
(244, 11, NULL),
(244, 12, NULL),
(245, 11, NULL),
(245, 12, NULL),
(246, 11, NULL),
(246, 12, NULL),
(247, 11, NULL),
(247, 12, NULL),
(248, 11, NULL),
(248, 12, NULL),
(249, 11, NULL),
(249, 12, NULL),
(250, 11, NULL),
(250, 12, NULL),
(251, 11, NULL),
(251, 12, NULL),
(252, 11, NULL),
(252, 12, NULL),
(253, 11, NULL),
(253, 12, NULL),
(254, 11, NULL),
(254, 12, NULL),
(255, 11, NULL),
(255, 12, NULL),
(256, 11, NULL),
(256, 12, NULL),
(257, 11, NULL),
(257, 12, NULL),
(258, 11, NULL),
(258, 12, NULL),
(259, 11, NULL),
(259, 12, NULL),
(260, 11, NULL),
(260, 12, NULL),
(261, 11, NULL),
(261, 12, NULL),
(262, 11, NULL),
(262, 12, NULL),
(263, 11, NULL),
(263, 12, NULL),
(264, 11, NULL),
(264, 12, NULL),
(265, 11, NULL),
(265, 12, NULL),
(266, 11, NULL),
(266, 12, NULL),
(267, 11, NULL),
(267, 12, NULL),
(268, 11, NULL),
(268, 12, NULL),
(269, 11, NULL),
(269, 12, NULL),
(271, 11, NULL),
(271, 12, NULL),
(272, 11, NULL),
(272, 12, NULL),
(274, 11, NULL),
(274, 12, NULL),
(275, 11, NULL),
(275, 12, NULL),
(276, 11, NULL),
(276, 12, NULL),
(277, 11, NULL),
(277, 12, NULL),
(278, 11, NULL),
(278, 12, NULL),
(280, 17, NULL),
(280, 20, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `r_achats_factures$achats`
--

CREATE TABLE `r_achats_factures$achats` (
  `id_achats` int(11) NOT NULL,
  `id_factures$achats` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `r_achats_factures$achats`
--

INSERT INTO `r_achats_factures$achats` (`id_achats`, `id_factures$achats`, `remarque`) VALUES
(280, 23, NULL),
(280, 24, NULL),
(280, 25, NULL),
(280, 27, NULL),
(280, 28, NULL),
(280, 29, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `r_avoirs$achats_bons$achats`
--

CREATE TABLE `r_avoirs$achats_bons$achats` (
  `id_avoirs$achats` int(11) NOT NULL,
  `id_bons$achats` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `r_avoirs$achats_bons$achats`
--

INSERT INTO `r_avoirs$achats_bons$achats` (`id_avoirs$achats`, `id_bons$achats`, `remarque`) VALUES
(11, 76, NULL),
(12, 77, NULL),
(12, 78, NULL),
(20, 79, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `r_avoirs$achats_factures$achats`
--

CREATE TABLE `r_avoirs$achats_factures$achats` (
  `id_avoirs$achats` int(11) NOT NULL,
  `id_factures$achats` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `r_avoirs$achats_factures$achats`
--

INSERT INTO `r_avoirs$achats_factures$achats` (`id_avoirs$achats`, `id_factures$achats`, `remarque`) VALUES
(20, 23, NULL),
(20, 24, NULL),
(20, 25, NULL),
(20, 27, NULL),
(20, 28, NULL),
(20, 29, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `r_bons$achats_commandes`
--

CREATE TABLE `r_bons$achats_commandes` (
  `id_bons$achats` int(11) NOT NULL,
  `id_commandes` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `r_bons$achats_commandes`
--

INSERT INTO `r_bons$achats_commandes` (`id_bons$achats`, `id_commandes`, `remarque`) VALUES
(76, 79, NULL),
(76, 80, NULL),
(76, 84, NULL),
(78, 86, NULL),
(78, 87, NULL),
(79, 88, NULL),
(79, 89, NULL),
(79, 90, NULL),
(79, 91, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `r_commandes_clients`
--

CREATE TABLE `r_commandes_clients` (
  `id_commandes` int(11) NOT NULL,
  `id_clients` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `r_factures$achats_bons$achats`
--

CREATE TABLE `r_factures$achats_bons$achats` (
  `id_factures$achats` int(11) NOT NULL,
  `id_bons$achats` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `r_factures$achats_bons$achats`
--

INSERT INTO `r_factures$achats_bons$achats` (`id_factures$achats`, `id_bons$achats`, `remarque`) VALUES
(25, 76, NULL),
(25, 77, NULL),
(28, 78, NULL),
(29, 79, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `r_factures$ventes_devis`
--

CREATE TABLE `r_factures$ventes_devis` (
  `id_factures$ventes` int(11) NOT NULL,
  `id_devis` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `r_ventes_factures$ventes`
--

CREATE TABLE `r_ventes_factures$ventes` (
  `id_ventes` int(11) NOT NULL,
  `id_factures$ventes` int(11) NOT NULL,
  `remarque` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE `ventes` (
  `id` int(10) NOT NULL,
  `clients` int(11) NOT NULL,
  `mode$paiement` int(11) NOT NULL,
  `date` date NOT NULL,
  `montant_factures_TTC` double NOT NULL,
  `montant_paye_TTC` double NOT NULL,
  `Creances_TTC` double DEFAULT 0,
  `remarque` text DEFAULT NULL,
  `image` varchar(250) DEFAULT 'image.jpg',
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `achat`
--
ALTER TABLE `achat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depanse_ibfk_2` (`mode$paiement`),
  ADD KEY `depense_ibfk_1` (`raison$sociale`);

--
-- Index pour la table `achats`
--
ALTER TABLE `achats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fournisseur` (`raison$sociale`);

--
-- Index pour la table `avoirs$achats`
--
ALTER TABLE `avoirs$achats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `N` (`N`),
  ADD KEY `FOURNISSEUR` (`raison$sociale`);

--
-- Index pour la table `bons$achats`
--
ALTER TABLE `bons$achats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `N` (`N`),
  ADD KEY `fournisseur` (`raison$sociale`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_ibfk_1` (`raison$sociale`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_ibfk_1` (`raison$sociale`);

--
-- Index pour la table `devis`
--
ALTER TABLE `devis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devisss` (`clients`);

--
-- Index pour la table `factures$achats`
--
ALTER TABLE `factures$achats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `N` (`N`),
  ADD KEY `Fournisseur` (`raison$sociale`);

--
-- Index pour la table `factures$ventes`
--
ALTER TABLE `factures$ventes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FV_ibfk_1` (`clients`);

--
-- Index pour la table `mode$paiement`
--
ALTER TABLE `mode$paiement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `raison$sociale`
--
ALTER TABLE `raison$sociale`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `RAISON_SOCIALE` (`raison$sociale`),
  ADD UNIQUE KEY `ICE` (`ICE`),
  ADD UNIQUE KEY `I-F` (`I_F`),
  ADD UNIQUE KEY `CNSS` (`CNSS`),
  ADD UNIQUE KEY `T-P` (`T_P`),
  ADD UNIQUE KEY `R-C` (`R_C`);

--
-- Index pour la table `r_achats_achat`
--
ALTER TABLE `r_achats_achat`
  ADD PRIMARY KEY (`id_achats`,`id_achat`),
  ADD KEY `id_depense` (`id_achat`);

--
-- Index pour la table `r_achats_avoirs$achats`
--
ALTER TABLE `r_achats_avoirs$achats`
  ADD PRIMARY KEY (`id_achats`,`id_avoirs$achats`),
  ADD KEY `id_avoir` (`id_avoirs$achats`);

--
-- Index pour la table `r_achats_factures$achats`
--
ALTER TABLE `r_achats_factures$achats`
  ADD PRIMARY KEY (`id_achats`,`id_factures$achats`),
  ADD KEY `id_facture` (`id_factures$achats`);

--
-- Index pour la table `r_avoirs$achats_bons$achats`
--
ALTER TABLE `r_avoirs$achats_bons$achats`
  ADD PRIMARY KEY (`id_avoirs$achats`,`id_bons$achats`),
  ADD KEY `id_bl` (`id_bons$achats`);

--
-- Index pour la table `r_avoirs$achats_factures$achats`
--
ALTER TABLE `r_avoirs$achats_factures$achats`
  ADD PRIMARY KEY (`id_avoirs$achats`,`id_factures$achats`),
  ADD KEY `id_facture` (`id_factures$achats`);

--
-- Index pour la table `r_bons$achats_commandes`
--
ALTER TABLE `r_bons$achats_commandes`
  ADD PRIMARY KEY (`id_bons$achats`,`id_commandes`),
  ADD KEY `id_commande` (`id_commandes`);

--
-- Index pour la table `r_commandes_clients`
--
ALTER TABLE `r_commandes_clients`
  ADD PRIMARY KEY (`id_commandes`,`id_clients`),
  ADD KEY `id_commande` (`id_commandes`),
  ADD KEY `R_cc_ibfk_2` (`id_clients`);

--
-- Index pour la table `r_factures$achats_bons$achats`
--
ALTER TABLE `r_factures$achats_bons$achats`
  ADD PRIMARY KEY (`id_factures$achats`,`id_bons$achats`),
  ADD KEY `id_bl` (`id_bons$achats`);

--
-- Index pour la table `r_factures$ventes_devis`
--
ALTER TABLE `r_factures$ventes_devis`
  ADD PRIMARY KEY (`id_factures$ventes`,`id_devis`) USING BTREE,
  ADD KEY `id_devis` (`id_devis`);

--
-- Index pour la table `r_ventes_factures$ventes`
--
ALTER TABLE `r_ventes_factures$ventes`
  ADD PRIMARY KEY (`id_ventes`,`id_factures$ventes`),
  ADD KEY `id_facturevente` (`id_factures$ventes`);

--
-- Index pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client1` (`clients`),
  ADD KEY `mp_2` (`mode$paiement`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `achat`
--
ALTER TABLE `achat`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `achats`
--
ALTER TABLE `achats`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT pour la table `avoirs$achats`
--
ALTER TABLE `avoirs$achats`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `bons$achats`
--
ALTER TABLE `bons$achats`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `devis`
--
ALTER TABLE `devis`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `factures$achats`
--
ALTER TABLE `factures$achats`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `factures$ventes`
--
ALTER TABLE `factures$ventes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `mode$paiement`
--
ALTER TABLE `mode$paiement`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT pour la table `raison$sociale`
--
ALTER TABLE `raison$sociale`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `achat`
--
ALTER TABLE `achat`
  ADD CONSTRAINT `achat_ibfk_1` FOREIGN KEY (`raison$sociale`) REFERENCES `raison$sociale` (`id`),
  ADD CONSTRAINT `depanse_ibfk_2` FOREIGN KEY (`mode$paiement`) REFERENCES `mode$paiement` (`id`);

--
-- Contraintes pour la table `achats`
--
ALTER TABLE `achats`
  ADD CONSTRAINT `achats_ibfk_1` FOREIGN KEY (`raison$sociale`) REFERENCES `raison$sociale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `avoirs$achats`
--
ALTER TABLE `avoirs$achats`
  ADD CONSTRAINT `avoirs$achats_ibfk_1` FOREIGN KEY (`raison$sociale`) REFERENCES `raison$sociale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `bons$achats`
--
ALTER TABLE `bons$achats`
  ADD CONSTRAINT `bons$achats_ibfk_1` FOREIGN KEY (`raison$sociale`) REFERENCES `raison$sociale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`raison$sociale`) REFERENCES `raison$sociale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`raison$sociale`) REFERENCES `raison$sociale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `devis`
--
ALTER TABLE `devis`
  ADD CONSTRAINT `devis_ibfk_1` FOREIGN KEY (`clients`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `devisss` FOREIGN KEY (`clients`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `factures$achats`
--
ALTER TABLE `factures$achats`
  ADD CONSTRAINT `factures$achats_ibfk_1` FOREIGN KEY (`raison$sociale`) REFERENCES `raison$sociale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `factures$ventes`
--
ALTER TABLE `factures$ventes`
  ADD CONSTRAINT `FV_ibfk_1` FOREIGN KEY (`clients`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_achats_achat`
--
ALTER TABLE `r_achats_achat`
  ADD CONSTRAINT `d_paiement_depense_ibfk_1` FOREIGN KEY (`id_achat`) REFERENCES `achat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_paiement_depense_ibfk_2` FOREIGN KEY (`id_achats`) REFERENCES `achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_achats_avoirs$achats`
--
ALTER TABLE `r_achats_avoirs$achats`
  ADD CONSTRAINT `d_paiement_avoir_ibfk_1` FOREIGN KEY (`id_avoirs$achats`) REFERENCES `avoirs$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_paiement_avoir_ibfk_2` FOREIGN KEY (`id_achats`) REFERENCES `achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_achats_factures$achats`
--
ALTER TABLE `r_achats_factures$achats`
  ADD CONSTRAINT `d_paiement_facture_ibfk_1` FOREIGN KEY (`id_factures$achats`) REFERENCES `factures$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_paiement_facture_ibfk_2` FOREIGN KEY (`id_achats`) REFERENCES `achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_avoirs$achats_bons$achats`
--
ALTER TABLE `r_avoirs$achats_bons$achats`
  ADD CONSTRAINT `d_avoir_bl_ibfk_1` FOREIGN KEY (`id_avoirs$achats`) REFERENCES `avoirs$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_avoir_bl_ibfk_2` FOREIGN KEY (`id_bons$achats`) REFERENCES `bons$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_avoirs$achats_factures$achats`
--
ALTER TABLE `r_avoirs$achats_factures$achats`
  ADD CONSTRAINT `d_avoir_facture_ibfk_1` FOREIGN KEY (`id_avoirs$achats`) REFERENCES `avoirs$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_avoir_facture_ibfk_2` FOREIGN KEY (`id_factures$achats`) REFERENCES `factures$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_bons$achats_commandes`
--
ALTER TABLE `r_bons$achats_commandes`
  ADD CONSTRAINT `R_bl_commande_ibfk_1` FOREIGN KEY (`id_commandes`) REFERENCES `commandes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `R_bl_commande_ibfk_2` FOREIGN KEY (`id_bons$achats`) REFERENCES `bons$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_commandes_clients`
--
ALTER TABLE `r_commandes_clients`
  ADD CONSTRAINT `R_cc_ibfk_1` FOREIGN KEY (`id_commandes`) REFERENCES `commandes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `R_cc_ibfk_2` FOREIGN KEY (`id_clients`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_factures$achats_bons$achats`
--
ALTER TABLE `r_factures$achats_bons$achats`
  ADD CONSTRAINT `d_facture_bl_ibfk_1` FOREIGN KEY (`id_factures$achats`) REFERENCES `factures$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_facture_bl_ibfk_2` FOREIGN KEY (`id_bons$achats`) REFERENCES `bons$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_factures$ventes_devis`
--
ALTER TABLE `r_factures$ventes_devis`
  ADD CONSTRAINT `d_factur_ibfk_1` FOREIGN KEY (`id_factures$ventes`) REFERENCES `factures$ventes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_factus_ibfk_2` FOREIGN KEY (`id_devis`) REFERENCES `devis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `r_ventes_factures$ventes`
--
ALTER TABLE `r_ventes_factures$ventes`
  ADD CONSTRAINT `d_vente_facture_ibfk_1` FOREIGN KEY (`id_ventes`) REFERENCES `ventes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_vente_facture_ibfk_2` FOREIGN KEY (`id_factures$ventes`) REFERENCES `factures$ventes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD CONSTRAINT `client1` FOREIGN KEY (`clients`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mp_2` FOREIGN KEY (`mode$paiement`) REFERENCES `mode$paiement` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
