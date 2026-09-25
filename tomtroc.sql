-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : ven. 25 sep. 2026 à 07:16
-- Version du serveur : 10.3.9-MariaDB
-- Version de PHP : 8.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tomtroc`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_books_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `user_id`, `title`, `author`, `description`, `image`, `available`, `created_at`) VALUES
(1, 1, 'Esther', 'Alabaster', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Esther.jpg', 0, '2026-09-22 09:48:36'),
(2, 2, 'The Kinfolk Table', 'Nathan Williams', 'J\'ai récemment plongé dans les pages de \'The Kinfolk Table\' et j\'ai été enchanté par cette œuvre captivante. Ce livre va bien au-delà d\'une simple collection de recettes ; il célèbre l\'art de partager des moments authentiques autour de la table.\r\n\r\nLes photographies magnifiques et le ton chaleureux captivent dès le départ, transportant le lecteur dans un voyage à travers des recettes et des histoires qui mettent en avant la beauté de la simplicité et de la convivialité.\r\n\r\nChaque page est une invitation à ralentir, à savourer et à créer des souvenirs durables avec les êtres chers.\r\n\r\n\'The Kinfolk Table\' incarne parfaitement l\'esprit de la cuisine et de la camaraderie, et il est certain que ce livre trouvera une place spéciale dans le cœur de tout amoureux de la cuisine et des rencontres inspirantes.', 'eaec3f45c82ad9e1d29f1d5e514a4084.jpg', 0, '2026-09-22 09:48:36'),
(3, 1, 'Wabi Sabi', 'Beth Kempton', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Wabi Sabi.jpg', 1, '2026-09-22 09:48:36'),
(4, 2, 'Milk & honey', 'Rupi Kaur', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Milk & honey.jpg', 1, '2026-09-22 09:48:36'),
(5, 1, 'Delight!', 'Justin Rossow', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Delight!.jpg', 1, '2026-09-22 09:48:36'),
(6, 2, 'Milwaukee Mission', 'Elder Cooper Low', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Milwaukee Mission.jpg', 1, '2026-09-22 09:48:36'),
(7, 1, 'Minimalist Graphics', 'Julia Schonlau', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Minimalist Graphics.jpg', 1, '2026-09-22 09:48:36'),
(8, 2, 'Hygge', 'Meik Wiking', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Hygge.jpg', 1, '2026-09-22 09:48:36'),
(9, 1, 'Innovation', 'Matt Ridley', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Innovation.jpg', 1, '2026-09-22 09:48:36'),
(10, 2, 'Psalms', 'Alabaster', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Psalms.jpg', 1, '2026-09-22 09:48:36'),
(11, 1, 'Thinking, Fast & Slow', 'Daniel Kahneman', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Thinking, Fast & Slow.jpg', 1, '2026-09-22 09:48:36'),
(12, 2, 'A Book Full Of Hope', 'Rupi Kaur', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'A Book Full Of Hope.jpg', 1, '2026-09-22 09:48:36'),
(13, 1, 'The Subtle Art Of...', 'Mark Manson', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'The Subtle Art Of....jpg', 1, '2026-09-22 09:48:36'),
(14, 2, 'Narnia', 'C.S. Lewis', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Narnia.jpg', 1, '2026-09-22 09:48:36'),
(15, 1, 'Company Of One', 'Paul Jarvis', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Company Of One.jpg', 1, '2026-09-22 09:48:36'),
(16, 2, 'The Two Towers', 'J.R.R Tolkien', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'The Two Towers.jpg', 1, '2026-09-22 09:48:36');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) UNSIGNED NOT NULL,
  `recipient_id` int(10) UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `read_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_messages_sender` (`sender_id`),
  KEY `fk_messages_recipient` (`recipient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `recipient_id`, `content`, `created_at`, `read_at`) VALUES
(1, 3, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '2026-09-20 09:12:00', '2026-09-24 14:21:19'),
(2, 1, 3, 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2026-09-20 09:18:00', '2026-09-23 16:25:19'),
(3, 3, 1, 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', '2026-09-20 09:24:00', '2026-09-24 14:21:19'),
(4, 1, 3, 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore.', '2026-09-20 09:31:00', '2026-09-23 16:25:19'),
(5, 3, 1, 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2026-09-20 09:42:00', '2026-09-24 14:21:19'),
(6, 2, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '2026-09-21 10:05:00', '2026-09-24 08:32:18'),
(7, 1, 2, 'Praesent commodo cursus magna, vel scelerisque nisl consectetur.', '2026-09-21 10:14:00', '2026-09-23 16:58:42'),
(8, 2, 1, 'Donec ullamcorper nulla non metus auctor fringilla.', '2026-09-21 10:27:00', '2026-09-24 08:32:18'),
(9, 1, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '2026-09-23 16:01:59', '2026-09-23 16:25:19');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `avatar`, `created_at`) VALUES
(1, 'alexlecture', 'alexlecture@example.com', '$2y$10$vfinAb5VkbY92xkaqPxQCeFYR6ubq25BNwpVeeKZNZHmEblaKaQxG', '70d9cc0012dee5d05c7938690d9a3240.png', '2026-09-22 09:47:45'),
(2, 'nathalire', 'nathalire@example.com', '$2y$10$pLUpOYGp0C6jQZWQQbAi5O12/3jRjt8IZaxQuQiRXhYDKCM7ynHVS', '12ecb35273f474317faf2fbd1f2b2920.png', '2026-09-22 09:47:45'),
(3, 'Sas634', 'sas634@example.com', '$2y$10$/W6PAH7LWzD7CXjYFiDiHOtN8AvyX/b7K9rcyG2fP7tky3w6zGDQy', 'ee884a34087b973082afe39fbaa5db1a.png', '2026-09-22 10:25:17');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_messages_recipient` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_messages_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
