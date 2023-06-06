<?php

    namespace Login\Controllers;

    require_once('../src/models/Database.php');

    use Login\Lib\DataBase\DatabaseConnection;

    class AcountController
    {
        public function deleteAccount(): void
        {
            $database = new DatabaseConnection();
            $database = $database->getConnection();

            $email = $_SESSION['email'];

            $query = $database->prepare('SELECT guid FROM user WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
            $guid = $query->fetch();
            $guid = $guid['guid'];

            $query = $database->prepare('DELETE FROM user WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();

            $query = $database->prepare('DELETE FROM accountattempt WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();

            $query = $database->prepare('DELETE FROM account WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();

            $query = $database->prepare('DELETE FROM accountotp WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();

            header('Location: Register.php');

        }
    }
?>