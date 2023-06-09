<?php

    namespace Login\src\Models;

    require_once('./src/models/Database.php');

    use Login\src\Models\DatabaseConnection;

    class Otp {
        // On déclare les propriétés de la classe Otp
        public string $guid;
        public string $otp;
        public DatabaseConnection $database;

        // On déclare le constructeur de la classe Otp
        public function __construct($database) {
            $this->database = $database;
        }
        
        // On déclare les getters et les setters de la classe Otp
        public function getDatabase(): DatabaseConnection {
            return $this->database;
        }

        // On déclare les getters et les setters de la classe Otp
        public function getGuid(): string {
            return $this->guid;
        }

        public function getOtp(): string {
            return $this->otp;
        }

        public function setGuid(string $guid): void {
            $this->guid = $guid;
        }

        public function setOtp(string $otp): void {
            $this->otp = $otp;
        }

        // On génère un otp aléatoire
        public function generateOtp(): string {
            $otp = rand(100000, 999999);

            return $otp;
        }

        // On récupère l'otp depuis le guid
        public function getOtpFromGuid(string $guid): string {
            $query = $this->database->getConnection()->prepare('SELECT otp FROM accountotp WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();

            $otp = $query->fetch();

            return $otp['otp'];
        }

        // On ajoute l'otp dans la base de données ($guid, $otp)
        public function insertOtp(string $guid, string $otp): void {
            $otp = hash('sha512', $otp);
            $query = $this->database->getConnection()->prepare('INSERT INTO accountotp (guid, otp, validity) VALUES (:guid, :otp, NOW() + INTERVAL 5 MINUTE)');
            $query->bindParam(':guid', $guid);
            $query->bindParam(':otp', $otp);
            $query->execute();
        }

        // On supprime tous les otp associés à un guid
        public function deleteOtp(string $guid): void {
            $query = $this->database->getConnection()->prepare('DELETE FROM accountotp WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
        }

        // On affiche l'otp pour l'utilisateur
        public function displayOtp(string $otp): void {
            // Remplace PHP mailer
            echo '<script type="text/javascript">
            var token = "'. $otp .'";
            window.alert("Votre code de confitmation : " + token);
            window.location.href = "reset-password";
        </script>';
        }

        // On vérifie si l'otp est valide
        public function verifOtp(string $guid, string $otp): bool {
            $query = $this->database->getConnection()->prepare('SELECT otp FROM accountotp WHERE guid = :guid ORDER BY validity DESC LIMIT 1');
            $query->bindParam(':guid', $guid);
            $query->execute();

            $otp_verif = $query->fetch();

            if ($otp_verif['otp'] === hash('sha512', $otp)) {
                return true;
            } else {
                return false;
            }
        }
    }

?>