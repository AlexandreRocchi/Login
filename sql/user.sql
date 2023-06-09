CREATE USER 'login'@'localhost' IDENTIFIED BY '*lliqfP3sE]p_*PB';
GRANT ALL PRIVILEGES ON `users`.* TO 'login'@'localhost' WITH GRANT OPTION;
GRANT SELECT, INSERT, UPDATE, DELETE ON `users`.* TO 'login'@'localhost';
FLUSH PRIVILEGES;
