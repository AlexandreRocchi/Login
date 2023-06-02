CREATE DATABASE IF NOT EXISTS `users`;

USE `users`;

-- Table pour les utilisateurs
CREATE TABLE IF NOT EXISTS `user` (
  `guid` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(128) NOT NULL
);

-- Table pour les comptes d'utilisateur
CREATE TABLE IF NOT EXISTS `account` (
  `guid` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `password` VARCHAR(128) NOT NULL,
  `salt` VARCHAR(128) NOT NULL
);
