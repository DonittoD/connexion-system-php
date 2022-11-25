<?php
session_start();
require "connexion.php";

if (!isset($_SESSION['user_login']) ||  $_SESSION['role'] != 'admin' || time() - $_SESSION['login_time'] > 120 )	//check unauthorize user not access in "welcome.php" page
						{

							session_destroy();

							header("location: index.php");
						}
            

if (isset($_GET["reset"])){
 if ($_GET["reset"])
 {
  $select_stmt=$db->prepare("DROP DATABASE IF EXISTS projet1_db;
CREATE DATABASE IF NOT EXISTS projet1_db;
USE projet1_db;

--
-- Structure de la table  user 
--

CREATE TABLE users(
   id  int(11) NOT NULL primary key auto_increment,
   email  varchar(320) NOT NULL,
   username  varchar(320) NOT NULL,
   password  varchar(320) NOT NULL,
   role varchar(255) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Structure de la table  infos_users
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `username` varchar(320) NOT NULL,
  `password` varchar(320) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `role`) VALUES
(1, 'arnaud@gmail.com', 'arnaud', '$2y$10$/esZ6gcV7NED7Sv5uJnaXu3m71UIk2VbRq2WxtN.YSK1QJNJPwNjG', 'admin'),
(2, 'adresse@gmail.com', 'arnaud1', '$2y$10$vYGRZ5lN2L61JSvvhXwQhOb1FZ/qw.ZhverkRTpo.EEiVQ82MCl6G', 'admin'),
(3, 'feiteira.daniel@hotmail.com', 'daniel', '$2y$10$yCRcOAv9f7CFkOuUjn58T.wpigAFCN8U45NLCRTjyWWspFwm0yT2e', 'admin');


INSERT INTO infos_users (refto_user_id, nom, prenom, date_naissance, sexe) VALUES
('1', 'Pelo', 'Arnaud', '20031209', 'H'),
('2', 'Pipo', 'Arnaud', '20010323', 'H');

"); //sql select query
$select_stmt->execute();	//execute query with bind parameter

header ("Location: database.php");
 }
}

?>


<a href="database.php?reset=1">Réinitialiser la base de données</a>
