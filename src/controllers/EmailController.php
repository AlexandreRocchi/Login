<?php

    namespace Login\Controllers;

    require_once('../src/models/Database.php');

    use Login\Lib\DataBase\DatabaseConnection;

    class EmailController
    {
        public function confirmEmail(): void
        {
            $database = new DatabaseConnection();
            $database = $database->getConnection();

            $otp = $_POST['otp'];
            $email = $_SESSION['email'];
            
            $query = $database->prepare('SELECT guid FROM user WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
            $guid = $query->fetch();

            $query = $database->prepare('SELECT otp FROM accountotp WHERE guid = :guid ORDER BY validity DESC LIMIT 1');
            $query->bindParam(':guid', $guid['guid']);
            $query->execute();
            $otpdb = $query->fetch();

            if ($otp == $otpdb['otp']) {
                $_SESSION['guid'] = $guid['guid'];
                header('Location: Change.php');
            } else {
                echo 'Code de confirmation incorrect';
            }
        }
    }
?>