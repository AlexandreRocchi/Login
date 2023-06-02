<?php

    namespace Login\Controllers;

    require_once('../src/lib/database.php');

    use Login\Lib\DataBase\DatabaseConnection;

    class Session
    {
        public function session(): void
        {
            $database = new DatabaseConnection();
            $database = $database->getConnection();

            $guid = $_SESSION['user'];

            $query = $database->prepare('SELECT * FROM account WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();

            $user = $query->fetch();

            echo $user['email'];
        }
    }
?>