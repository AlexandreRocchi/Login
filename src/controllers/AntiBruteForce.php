<?php

    namespace Login\Controllers;

    require_once('../src/models/Database.php');

    use Login\Lib\DataBase\DatabaseConnection;

    class AntiBruteForce
    {
        public static function antiBruteforce(): bool
        {
            $database = new DatabaseConnection();
            $database = $database->getConnection();

            $email = $_POST['email'];

            $query = $database->prepare('SELECT guid FROM user WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
            $guid = $query->fetch();
            $guid = $guid['guid'];

            $query = $database->prepare('SELECT * FROM accountattempt WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
            $time = $query->fetch();

            if ($time === false) {
                $query = $database->prepare('INSERT INTO accountattempt (guid, time) VALUES (:guid, 1)');
                $query->bindParam(':guid', $guid);
                $query->execute();
                return true;
            } else {
                $time = $time['time'];
                if ($time < 11) {
                    $time++;
                    $query = $database->prepare('UPDATE accountattempt SET time = :time WHERE guid = :guid');
                    $query->bindParam(':time', $time);
                    $query->bindParam(':guid', $guid);
                    $query->execute();
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
?>