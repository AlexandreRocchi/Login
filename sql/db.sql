CREATE USER 'alex'@'localhost' IDENTIFIED WITH caching_sha2_password BY '***';GRANT ALL PRIVILEGES ON *.* TO 'alex'@'localhost' WITH GRANT OPTION;ALTER USER 'alex'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;GRANT ALL PRIVILEGES ON `users`.* TO 'alex'@'localhost';


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