<?php

    namespace Login\Controllers;

    require_once('../src/models/Database.php');

    use Login\Lib\DataBase\DatabaseConnection;

    class ResetBruteForce
    {
        public static function resetBruteForce(): void
        {
            $database = new DatabaseConnection();
            $database = $database->getConnection();

            $email = $_POST['email'];

            $query = $database->prepare('SELECT guid FROM user WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
            $guid = $query->fetch();
            $guid = $guid['guid'];
              
            if ($guid === false) {
            } else {
                $guid = $guid;
                $query = $database->prepare('UPDATE accountattempt SET time = 0 WHERE guid = :guid');
                $query->bindParam(':guid', $guid);
                $query->execute();
            }
        }
    }
?>