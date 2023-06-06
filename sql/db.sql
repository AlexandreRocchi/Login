CREATE DATABASE IF NOT EXISTS `users`;

USE `users`;

-- Table pour les utilisateurs
CREATE TABLE IF NOT EXISTS `user` (
  `guid` INT(11) PRIMARY KEY,
  `email` VARCHAR(128) NOT NULL
);

-- Table pour les comptes d'utilisateur
CREATE TABLE IF NOT EXISTS `account` (
  `guid` INT(11) PRIMARY KEY,
  `password` VARCHAR(128) NOT NULL,
  `salt` VARCHAR(128) NOT NULL,
  `strech` INT(11) NOT NULL DEFAULT '1000'
);

-- Table pour les comptes d'utilisateur
CREATE TABLE IF NOT EXISTS `accountotp` (
  `guid` INT(11),
  `otp` VARCHAR(128) NOT NULL,
  `validity` DATETIME NOT NULL
);

-- Table pour le nombre de tentative de connexion d'un utilisateur
CREATE TABLE IF NOT EXISTS `accountattempt` (
  `guid` INT(11) PRIMARY KEY,
  `time` INT(11) NOT NULL
);


-- Table pour les comptes d'utilisateur
CREATE TABLE IF NOT EXISTS `accountautorization` (
  `guid` INT(11),
  `webserice` VARCHAR(128) NOT NULL
);

-- Table pour les autorisations publiques
CREATE TABLE IF NOT EXISTS `publicautorization` (
  `webserice` VARCHAR(128) NOT NULL
);