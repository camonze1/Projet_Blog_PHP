-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 20 mai 2021 à 09:32
-- Version du serveur :  8.0.25-0ubuntu0.20.04.1
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `billets`
--

CREATE TABLE `billets` (
  `id` int NOT NULL,
  `titre` varchar(64) DEFAULT NULL,
  `body` text,
  `cat_id` int DEFAULT '1',
  `date` date DEFAULT NULL,
  `auteur` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `billets`
--

INSERT INTO `billets` (`titre`, `body`, `cat_id`, `date`, `auteur`) VALUES ('20th century boys', 'Et si des dessins d\'enfants réalisés dans les années 90 devenaient le présent que nous vivons ?  Il faut faire attention, limagination est incroyablement vaste.', '6', '2009-08-14', 'hiekashi');

INSERT INTO `billets` (`titre`, `body`, `cat_id`, `date`, `auteur`) VALUES ('Eurovision', 'Créée en 1956, elle réunit les membres de l\'Union européenne dans le cadre d\'une compétition musicale', '4', '2018-06-30', 'julius');

INSERT INTO `billets` (`titre`, `body`, `cat_id`, `date`, `auteur`) VALUES ('A crier sous les ruines', 'Difficile de nouer avec ses racines lorsqu\'on a quitté le pays très petite mais, après tout, rien ne nous empêche d\'y retourner pour mettre des lieux sur des souvenirs.', '6', '2022-03-20', 'julius');

INSERT INTO `billets` (`titre`, `body`, `cat_id`, `date`, `auteur`) VALUES ('Alec Benjamin', 'Chanteur américain de 27 ans dont sa chanson la plus connue est "Let me down slowly" avec 880 millions d\'écoutes sur Spotify (2021)', '3', '2013-03-21', 'camonze');

INSERT INTO `billets` (`titre`, `body`, `cat_id`, `date`, `auteur`) VALUES ('Musée des beaux-arts de Nancy', 'D\'une surface de 9 000m², il regorge de peintures allant du XIVe au XXe siècle mais également de sculptures du XVIIIe siècle jusqu\'au XXe siècle', '5', '2017-09-27', 'seum41');

INSERT INTO `billets` (`titre`, `body`, `cat_id`, `date`, `auteur`) VALUES ('Kill la kill', 'Ne perds pas tes affaires car un ciseau ne fonctionne qu\'en paire', '7', '2015-02-25', 'julius');

INSERT INTO `billets` (`titre`, `body`, `cat_id`, `date`, `auteur`) VALUES ('Claude Monet', 'Peintre impressionniste, né en 1840 et mort en 1926', '8', '2009-01-01', 'camonze');

INSERT INTO `billets` (`titre`, `body`, `cat_id`, `date`, `auteur`) VALUES ('Equipe de France masculine de volley-ball', 'Composée de 19 membres et entrainé par Andrea Giani, ils ont obtenus la médaille d\'or lors des Jeux Olympiques de 2020.', '1', '2007-12-09', 'hiekashi');

INSERT INTO `billets` (`titre`, `body`, `cat_id`, `date`, `auteur`) VALUES ('Equipe de France masculine de handball', 'C\'est la sélection de handball la plus titrée de tous les temps : 3 fois championne olympique, 6 fois championne du monde et 3 fois championne d\'Europe', '1', '2016-06-16', 'camonze');

INSERT INTO `billets` (`titre`, `body`, `cat_id`, `date`, `auteur`) VALUES ('Musée d\'histoire naturelle de Paris', 'Créé en 1793, il est l\'un des plus anciens établissements mondiaux de ce type.', '5', '2008-06-05','seum41');

INSERT INTO `billets` (`titre`, `body`, `cat_id`, `date`, `auteur`) VALUES ('Le meilleur pâtissier', 'Emission franco-belge où divers candidats, pâtissiers amateurs, s\'affrontent sur des épreuves culinaires pour montrer leurs talents', '4', '2015-04-22', 'julius');

INSERT INTO `billets` (`titre`, `body`, `cat_id`, `date`, `auteur`) VALUES ('Le voyage de Chihiro', 'Bienvenue dans un monde où tes parents peuvent être transformés en porc', '2', '2019-04-04', 'camonze');

INSERT INTO `billets` (`titre`, `body`, `cat_id`, `date`, `auteur`) VALUES ('Fullmetal Alchemist', 'Les cercles sataniques c\'est pas la meilleure idée pour exaucer des vœux', '7', '2005-01-14', 'seum41');

INSERT INTO `billets` (`titre`, `body`, `cat_id`, `date`, `auteur`) VALUES ('Top chef', 'Programme télévisé français, paru pour la première fois en 2010 et qui continue depuis 13 saisons, mettant en avant des cuisiniers professionnels, se battant pour le grand titre', '4', '2014-01-31', 'julius');

INSERT INTO `billets` (`titre`, `body`, `cat_id`, `date`, `auteur`) VALUES ('Green day', 'Groupe de punk rock américain dont la carrière décolla dans les années 1990', '3', '2013-08-15', 'hiekashi');
COMMIT;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `titre` varchar(64) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `titre`, `description`) VALUES
(1, 'sport', 'tout sur le sport en general'),
(2, 'cinema', 'tout sur le cinema'),
(3, 'music', 'toute la music que jaaiiiimeuh, elle vient de la, elle vient du bluuuuuuzee'),
(4, 'tele', 'tout sur les programmes tele, les emissions, les series, et vos stars preferes'),
(8, 'test', 'catégorie de test'),
(9, 'test', 'catégorie de test'),
(10, 'test', 'catégorie de test');
COMMIT;


-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` INT(2) NOT NULL,
  `pseudo` VARCHAR(30) NOT NULL  ,
  `nom` VARCHAR(30) NOT NULL,
  `prenom` VARCHAR(30) NOT NULL,
  `mail` VARCHAR(50) NOT NULL,
  `mdp` VARCHAR(12) NOT NULL,
  `statut` VARCHAR(6) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`pseudo`, `nom`, `prenom`, `mail`, `mdp`, `statut`) VALUES
('hiekashi', 'Muller', 'Oceane', 'oceane.muller@gmail.com', 'nootnoot',2),
('camonze', 'Launois', 'Camille', 'camille.launois@gmail.com', 'basilic', 2),
('seum41', 'Grizzi', 'Edgar', 'edgar.grizzi@gmail.com', 'pokemon', 1);
('julius', 'Ronot', 'Jules', 'jules.ronot@gmail.com', 'lumiere', 1);


-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` INT NOT NULL,
  `user_id` VARCHAR(30) NOT NULL,
  `billet_id` INT NOT NULL,
  `text` text,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`user_id`, `billet_id`, `text`) VALUES
('hiekashi', '2', 'il a fait plouf'),
('camonze', '3', 'vive le sport');
('julius', '7', 'trop cool');
('seum41', '2', 'youpi');
COMMIT;


-- --------------------------------------------------------

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `billets`
--
ALTER TABLE `billets`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `categ` (`cat_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`pseudo`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`);


-- --------------------------------------------------------

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `billets`
--
ALTER TABLE `billets`
MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;


-- --------------------------------------------------------

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `billets`
--
ALTER TABLE `billets`
ADD CONSTRAINT `categ` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ADD CONSTRAINT `util` FOREIGN KEY (`auteur`) REFERENCES `utilisateur` (`pseudo`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
ADD CONSTRAINT `billet` FOREIGN KEY (`billet_id`) REFERENCES `billets` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`pseudo`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
