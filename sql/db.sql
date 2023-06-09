GRANT USAGE ON *.* TO `login`@`localhost`;

GRANT ALL PRIVILEGES ON `users`.* TO `login`@`localhost`;

CREATE DATABASE IF NOT EXISTS `users`;

USE `users`;

-- Table pour les utilisateurs
CREATE TABLE IF NOT EXISTS `user` (
  `guid` VARCHAR(128),
  `email` VARCHAR(128) NOT NULL
);

-- Table pour les comptes d'utilisateur
CREATE TABLE IF NOT EXISTS `account` (
  `guid` VARCHAR(128),
  `password` VARCHAR(128) NOT NULL,
  `salt` TEXT NOT NULL,   
  `strech` INT(11) NOT NULL DEFAULT '1000'
);

-- Table pour les comptes d'utilisateur
CREATE TABLE IF NOT EXISTS `accountotp` (
  `guid` VARCHAR(128),
  `otp` VARCHAR(128) NOT NULL,
  `validity` DATETIME NOT NULL
);

-- Table pour le nombre de tentative de connexion d'un utilisateur
CREATE TABLE IF NOT EXISTS `accountattempt` (
  `guid` VARCHAR(128),
  `time` DATETIME NOT NULL
);


-- Table pour les comptes d'utilisateur
CREATE TABLE IF NOT EXISTS `accountautorization` (
  `guid` VARCHAR(128),
  `webserice` VARCHAR(128) NOT NULL
);

-- Table pour les autorisations publiques
CREATE TABLE IF NOT EXISTS `publicautorization` (
  `webserice` VARCHAR(128) NOT NULL
);