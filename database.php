<?php
session_start();
require "connexion.php";

if (isset($_GET["reset"])){
 if ($_GET["reset"])
 {
  $select_stmt=$db->prepare("DROP DATABASE IF EXISTS projet1_db;
CREATE DATABASE IF NOT EXISTS projet1_db;
USE projet1_db;
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 25 nov. 2022 à 14:46
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

-- Base de données : `projet1_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `username` varchar(320) NOT NULL,
  `password` varchar(320) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `users` (`id`, `email`, `username`, `password`, `role`) VALUES
(1, 'arnaud@gmail.com', 'arnaud', '$2y$10$/esZ6gcV7NED7Sv5uJnaXu3m71UIk2VbRq2WxtN.YSK1QJNJPwNjG', 'admin'),
(2, 'adresse@gmail.com', 'arnaud1', '$2y$10\$vYGRZ5lN2L61JSvvhXwQhOb1FZ/qw.ZhverkRTpo.EEiVQ82MCl6G', 'admin'),
(3, 'feiteira.daniel@hotmail.com', 'daniel', '$2y$10\$yCRcOAv9f7CFkOuUjn58T.wpigAFCN8U45NLCRTjyWWspFwm0yT2e', 'admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

"); //sql select query
$select_stmt->execute();	//execute query with bind parameter

header ("Location: database.php");
 }
}

?>


<a href="database.php?reset=1">Réinitialiser la base de données</a>
