<?php

    namespace Login\Controllers;

    require_once('../src/lib/database.php');

    use Login\Lib\DataBase\DatabaseConnection;

    class AddUser
    {
        public function addUser(): void
        {
            $database = new DatabaseConnection();
            $database = $database->getConnection();

            $pwd = $_POST['pwd'];
            $email = $_POST['email'];

            $salt = crypt($pwd, "SecretSalt");

            $pwd = hash('sha512', $pwd);

            $userQuery = $database->prepare('INSERT INTO user (guid, email) VALUES (:guid, :email)');
            $accountQuery = $database->prepare('INSERT INTO account (guid, password, salt) VALUES (:guid, :password, :salt)');

            $userQuery->bindParam(':guid', $guid); // Assuming you have a $guid variable
            $userQuery->bindParam(':email', $email);
            $userQuery->execute();

            $accountQuery->bindParam(':guid', $guid); // Assuming you have a $guid variable
            $accountQuery->bindParam(':password', $pwd);
            $accountQuery->bindParam(':salt', $salt);
            $accountQuery->execute();

            // header('Location: /Login.php');
        }
    }

?>