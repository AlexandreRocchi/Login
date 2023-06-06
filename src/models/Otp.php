<?php

    namespace Login\Controllers;

    require_once('../src/models/Database.php');

    use Login\Lib\DataBase\DatabaseConnection;

    class Otp
    {
        public int $guid;

        public string $otp;

        public DatabaseConnection $database;

        public function __construct($guid,$otp, $database)
        {
            $this->guid = $guid;
            $this->otp = $otp;
            $this->database = $database;
        }
        
        public function getDatabase(): DatabaseConnection
        {
            return $this->database;
        }

        public function getGuid(): int
        {
            return $this->guid;
        }

        public function getOtp(): string
        {
            return $this->otp;
        }

        public function setGuid(int $guid): void
        {
            $this->guid = $guid;
        }

        public function setOtp(string $otp): void
        {
            $this->otp = $otp;
        }

        public function generateOtp(): string
        {
            $otp = random_bytes(8);

            return $otp;
        }

        public function getOtpFromGuid(int $guid): string
        {
            $query = $this->database->prepare('SELECT otp FROM accountotp WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();

            $otp = $query->fetch();

            return $otp['otp'];
        }

        public function displayOtp(): void
        {
            $query = $this->database->prepare('SELECT otp FROM accountotp WHERE guid = :guid');
            $query->bindParam(':guid', $this->guid);
            $query->execute();

            $otp = $query->fetch();

            // Remplace maladroitement PHP mailer
            echo '<script type="text/javascript">
            var token = "'. $otp .'";
            if (window.confirm(token)) {
                window.location.href = "Confirm.php";
            }
            </script>';
        }
    }

?>