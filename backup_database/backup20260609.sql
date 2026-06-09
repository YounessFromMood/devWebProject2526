-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 09 juin 2026 à 08:36
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `en_formation_2526`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id_administrateur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(70) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `num_tel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id_administrateur`, `nom`, `prenom`, `email`, `mdp`, `num_tel`) VALUES
(1, 'Admin', 'Principal', 'admin@enformation.be', '$2b$10$EIV9Va5PubCNLCMZl6JWI.wcQy/jk23uG7qHhqZvRTMg4Mo0FPyNC', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `editer`
--

CREATE TABLE `editer` (
  `id_administrateur` int(11) NOT NULL,
  `id_formation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

CREATE TABLE `eleve` (
  `id_eleve` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(70) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `num_tel` varchar(20) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `eleve`
--

INSERT INTO `eleve` (`id_eleve`, `nom`, `prenom`, `email`, `mdp`, `num_tel`, `deleted_at`) VALUES
(1, 'El', 'Yo', 'emaildeyou@gmail.com', '$2y$10$oo8CAWylyFyNAitGXJxumecjgGNO.FVyi1AHYjPrwqgNg4JzWrYl6', NULL, '2026-06-08 14:07:33'),
(9, 'Frost', 'Black', 'blackfrost@heeho.atlus', '$2y$10$ItISooj1WvRp8xKqluQHFejYFY6xWqTE7fbMs4EEwxx8GdPIXZ.Pq', NULL, NULL),
(11, 'Shiomi', 'Kotone', 'k.shiomi@atlus.com', '$2y$10$SgKbAwry5WgnP1QleVI6yeq5u1Sd5lfKF05NcbwEOHFzqtwpnVeP.', NULL, '2026-06-08 14:07:18'),
(12, 'Ace', 'Frost', 'f.ace@atlus.com', '$2y$10$4O4cvlicNXgRZ52xdu2u1.06EDyr7J5VbkMoN.85QOSHbs22lUFQ6', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `formateur`
--

CREATE TABLE `formateur` (
  `id_formateur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(70) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `num_tel` varchar(20) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `formateur`
--

INSERT INTO `formateur` (`id_formateur`, `nom`, `prenom`, `email`, `mdp`, `num_tel`, `deleted_at`) VALUES
(1, 'Frost', 'Jack', 'jack.frost@enformation.be', '$2y$10$tPVmT.KlqwFGF7QsWhvjk.vqp7rSTgE0Y51wUos5yCOGJ8CUmpwZG', NULL, NULL),
(2, 'Frost', 'King', 'k.frost@atlus.com', '$2y$10$Wf5cSyvDyvmyTNOlr24/yeqSSQCkm8wOSXDtDoWdqX3Gh5dr1ZmDW', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

CREATE TABLE `formation` (
  `id_formation` int(11) NOT NULL,
  `titre` varchar(300) NOT NULL,
  `description` varchar(2500) NOT NULL,
  `duree` varchar(150) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `langue` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `formation`
--

INSERT INTO `formation` (`id_formation`, `titre`, `description`, `duree`, `prix`, `langue`, `deleted_at`) VALUES
(1, 'Introduction à Python', 'Apprenez les bases du langage Python : variables, conditions, boucles, fonctions et manipulation de fichiers. Cette formation est idéale pour les débutants souhaitant se lancer dans la programmation. À la fin du cursus, vous serez capable d\'écrire des scripts simples et de comprendre les fondamentaux de la programmation orientée objet.', '3 mois', 299.00, 'Français', '2026-06-08 11:57:43'),
(2, 'Les fondamentaux de la cybersécurité', 'Découvrez les concepts essentiels de la cybersécurité : menaces courantes, gestion des mots de passe, sécurisation des réseaux, sensibilisation au phishing et introduction aux bonnes pratiques en entreprise. Cette formation s\'adresse aux profils non techniques souhaitant comprendre les enjeux de la sécurité informatique au quotidien.', '2 mois', 349.00, 'Français', NULL),
(3, 'Les rudiments de la POO avec Java', '', NULL, 150.00, 'Français', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `gerer`
--

CREATE TABLE `gerer` (
  `id_formateur` int(11) NOT NULL,
  `id_administrateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `modalite`
--

CREATE TABLE `modalite` (
  `id_modalite` int(11) NOT NULL,
  `libelle` varchar(30) NOT NULL,
  `nb_etudiant_max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `modalite`
--

INSERT INTO `modalite` (`id_modalite`, `libelle`, `nb_etudiant_max`) VALUES
(1, 'Présentiel', 10),
(2, 'Distanciel', 20);

-- --------------------------------------------------------

--
-- Structure de la table `modifier`
--

CREATE TABLE `modifier` (
  `id_administrateur` int(11) NOT NULL,
  `id_session` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `note_reussite`
--

CREATE TABLE `note_reussite` (
  `id_note_reussite` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `note_reussite`
--

INSERT INTO `note_reussite` (`id_note_reussite`, `libelle`) VALUES
(1, 'Réussite'),
(2, 'A participé');

-- --------------------------------------------------------

--
-- Structure de la table `notifier`
--

CREATE TABLE `notifier` (
  `id_eleve` int(11) NOT NULL,
  `id_session` int(11) NOT NULL,
  `id_note_reussite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

CREATE TABLE `session` (
  `id_session` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `lieu_session` varchar(100) DEFAULT NULL,
  `id_formateur` int(11) NOT NULL,
  `id_formation` int(11) NOT NULL,
  `id_modalite` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `s_inscrire`
--

CREATE TABLE `s_inscrire` (
  `id_eleve` int(11) NOT NULL,
  `id_session` int(11) NOT NULL,
  `paiement_recu` tinyint(1) DEFAULT 0,
  `date_inscription` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `typer`
--

CREATE TABLE `typer` (
  `id_formation` int(11) NOT NULL,
  `id_type_formation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `typer`
--

INSERT INTO `typer` (`id_formation`, `id_type_formation`) VALUES
(1, 1),
(2, 2),
(3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `type_formation`
--

CREATE TABLE `type_formation` (
  `id_type_formation` int(11) NOT NULL,
  `libelle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type_formation`
--

INSERT INTO `type_formation` (`id_type_formation`, `libelle`) VALUES
(1, 'Programmation'),
(2, 'Cybersécurité'),
(3, 'Design'),
(4, 'Bureautique');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id_administrateur`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `num_tel` (`num_tel`);

--
-- Index pour la table `editer`
--
ALTER TABLE `editer`
  ADD PRIMARY KEY (`id_administrateur`,`id_formation`),
  ADD KEY `id_formation` (`id_formation`);

--
-- Index pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD PRIMARY KEY (`id_eleve`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `num_tel` (`num_tel`);

--
-- Index pour la table `formateur`
--
ALTER TABLE `formateur`
  ADD PRIMARY KEY (`id_formateur`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `num_tel` (`num_tel`);

--
-- Index pour la table `formation`
--
ALTER TABLE `formation`
  ADD PRIMARY KEY (`id_formation`);

--
-- Index pour la table `gerer`
--
ALTER TABLE `gerer`
  ADD PRIMARY KEY (`id_formateur`,`id_administrateur`),
  ADD KEY `id_administrateur` (`id_administrateur`);

--
-- Index pour la table `modalite`
--
ALTER TABLE `modalite`
  ADD PRIMARY KEY (`id_modalite`);

--
-- Index pour la table `modifier`
--
ALTER TABLE `modifier`
  ADD PRIMARY KEY (`id_administrateur`,`id_session`),
  ADD KEY `id_session` (`id_session`);

--
-- Index pour la table `note_reussite`
--
ALTER TABLE `note_reussite`
  ADD PRIMARY KEY (`id_note_reussite`);

--
-- Index pour la table `notifier`
--
ALTER TABLE `notifier`
  ADD PRIMARY KEY (`id_eleve`,`id_session`),
  ADD KEY `id_session` (`id_session`),
  ADD KEY `id_note_reussite` (`id_note_reussite`);

--
-- Index pour la table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id_session`),
  ADD KEY `id_formateur` (`id_formateur`),
  ADD KEY `id_formation` (`id_formation`),
  ADD KEY `id_modalite` (`id_modalite`);

--
-- Index pour la table `s_inscrire`
--
ALTER TABLE `s_inscrire`
  ADD PRIMARY KEY (`id_eleve`,`id_session`),
  ADD KEY `id_session` (`id_session`);

--
-- Index pour la table `typer`
--
ALTER TABLE `typer`
  ADD PRIMARY KEY (`id_formation`,`id_type_formation`),
  ADD KEY `id_type_formation` (`id_type_formation`);

--
-- Index pour la table `type_formation`
--
ALTER TABLE `type_formation`
  ADD PRIMARY KEY (`id_type_formation`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id_administrateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `eleve`
--
ALTER TABLE `eleve`
  MODIFY `id_eleve` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `formateur`
--
ALTER TABLE `formateur`
  MODIFY `id_formateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `formation`
--
ALTER TABLE `formation`
  MODIFY `id_formation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `modalite`
--
ALTER TABLE `modalite`
  MODIFY `id_modalite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `note_reussite`
--
ALTER TABLE `note_reussite`
  MODIFY `id_note_reussite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `session`
--
ALTER TABLE `session`
  MODIFY `id_session` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_formation`
--
ALTER TABLE `type_formation`
  MODIFY `id_type_formation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `editer`
--
ALTER TABLE `editer`
  ADD CONSTRAINT `editer_ibfk_1` FOREIGN KEY (`id_administrateur`) REFERENCES `administrateur` (`id_administrateur`),
  ADD CONSTRAINT `editer_ibfk_2` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `gerer`
--
ALTER TABLE `gerer`
  ADD CONSTRAINT `gerer_ibfk_1` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`),
  ADD CONSTRAINT `gerer_ibfk_2` FOREIGN KEY (`id_administrateur`) REFERENCES `administrateur` (`id_administrateur`);

--
-- Contraintes pour la table `modifier`
--
ALTER TABLE `modifier`
  ADD CONSTRAINT `modifier_ibfk_1` FOREIGN KEY (`id_administrateur`) REFERENCES `administrateur` (`id_administrateur`),
  ADD CONSTRAINT `modifier_ibfk_2` FOREIGN KEY (`id_session`) REFERENCES `session` (`id_session`);

--
-- Contraintes pour la table `notifier`
--
ALTER TABLE `notifier`
  ADD CONSTRAINT `notifier_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`),
  ADD CONSTRAINT `notifier_ibfk_2` FOREIGN KEY (`id_session`) REFERENCES `session` (`id_session`),
  ADD CONSTRAINT `notifier_ibfk_3` FOREIGN KEY (`id_note_reussite`) REFERENCES `note_reussite` (`id_note_reussite`);

--
-- Contraintes pour la table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`id_formateur`) REFERENCES `formateur` (`id_formateur`),
  ADD CONSTRAINT `session_ibfk_2` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`),
  ADD CONSTRAINT `session_ibfk_3` FOREIGN KEY (`id_modalite`) REFERENCES `modalite` (`id_modalite`);

--
-- Contraintes pour la table `s_inscrire`
--
ALTER TABLE `s_inscrire`
  ADD CONSTRAINT `s_inscrire_ibfk_1` FOREIGN KEY (`id_eleve`) REFERENCES `eleve` (`id_eleve`),
  ADD CONSTRAINT `s_inscrire_ibfk_2` FOREIGN KEY (`id_session`) REFERENCES `session` (`id_session`);

--
-- Contraintes pour la table `typer`
--
ALTER TABLE `typer`
  ADD CONSTRAINT `typer_ibfk_1` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`),
  ADD CONSTRAINT `typer_ibfk_2` FOREIGN KEY (`id_type_formation`) REFERENCES `type_formation` (`id_type_formation`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
