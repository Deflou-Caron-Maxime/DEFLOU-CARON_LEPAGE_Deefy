-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : mar. 17 nov. 2026 à 16:05
-- Version du serveur : 12.3.3-MariaDB-ubu2404
-- Version de PHP : 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `deefy`
--

-- --------------------------------------------------------

--
-- Structure de la table `Albumtrack`
--

CREATE TABLE `Albumtrack` (
  `numero` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `chemin` varchar(50) NOT NULL,
  `artiste` varchar(20) NOT NULL,
  `album` varchar(50) NOT NULL,
  `genre` varchar(20) NOT NULL,
  `duree` int(11) NOT NULL,
  `annee` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Playlist`
--

CREATE TABLE `Playlist` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `duree` int(11) NOT NULL,
  `nbpistes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `Playlist`
--

INSERT INTO `Playlist` (`id`, `nom`, `duree`, `nbpistes`) VALUES
(1, 'New', 0, 0),
(2, 'New', 0, 0),
(3, 'New', 0, 0),
(4, 'New', 0, 0),
(5, 'NouvellePlaylist', 0, 0),
(6, 'P1', 0, 0),
(7, 'La salle', 0, 0),
(8, 'La salle', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `PlaylistAlbum`
--

CREATE TABLE `PlaylistAlbum` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `PlaylistPodcast`
--

CREATE TABLE `PlaylistPodcast` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `PlaylistPodcast`
--

INSERT INTO `PlaylistPodcast` (`id`, `numero`) VALUES
(8, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Podcasttrack`
--

CREATE TABLE `Podcasttrack` (
  `numero` int(11) NOT NULL,
  `auteur` varchar(20) NOT NULL,
  `datePodcasttrack` date NOT NULL,
  `genre` varchar(20) NOT NULL,
  `duree` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `chemin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `Podcasttrack`
--

INSERT INTO `Podcasttrack` (`numero`, `auteur`, `datePodcasttrack`, `genre`, `duree`, `titre`, `chemin`) VALUES
(1, 'Katty Perry', '2026-11-17', '', 0, 'I kissed a girl', 'I/kissed/a/girl');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Albumtrack`
--
ALTER TABLE `Albumtrack`
  ADD PRIMARY KEY (`numero`);

--
-- Index pour la table `Playlist`
--
ALTER TABLE `Playlist`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `PlaylistAlbum`
--
ALTER TABLE `PlaylistAlbum`
  ADD PRIMARY KEY (`id`,`numero`);

--
-- Index pour la table `PlaylistPodcast`
--
ALTER TABLE `PlaylistPodcast`
  ADD PRIMARY KEY (`id`,`numero`);

--
-- Index pour la table `Podcasttrack`
--
ALTER TABLE `Podcasttrack`
  ADD PRIMARY KEY (`numero`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Albumtrack`
--
ALTER TABLE `Albumtrack`
  MODIFY `numero` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Playlist`
--
ALTER TABLE `Playlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `Podcasttrack`
--
ALTER TABLE `Podcasttrack`
  MODIFY `numero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
