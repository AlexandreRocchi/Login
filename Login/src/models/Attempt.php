<?php

    namespace Login\src\Models;

    require_once('./src/models/Database.php');

    use Login\src\Models\DatabaseConnection;

    class Attempt {
        // On déclare les propriétés de la classe Attempt
        public string $guid;
        public string $time;
        public DatabaseConnection $database;

        // On déclare le constructeur de la classe Attempt
        public function __construct($database) {
            $this->database = $database;
        }
        
        // On déclare les getters et les setters de la classe Attempt
        public function getDatabase(): DatabaseConnection {
            return $this->database;
        }

        public function getGuid(): string {
            return $this->guid;
        }

        public function getTime(): string {
            return $this->time;
        }

        public function setGuid(string $guid): void {
            $this->guid = $guid;
        }

        public function setTime(string $time): void {
            $this->time = $time;
        }

        // On ajoute une tentative de connexion
        public function addAttempt(string $guid): void {
            $query = $this->database->getConnection()->prepare('INSERT INTO accountattempt (guid, time) VALUES (:guid, NOW())');
            $query->bindParam(':guid', $guid);
            $query->execute();
        }

        // On vérifie depuis combien de temps la dernière tentative de connexion a été faite et on réactive le compte si nécessaire
        public function debanAccount(string $guid): void {
            // Selection de l'heure de la dernière tentative de connexion
            $query = $this->database->getConnection()->prepare('SELECT time FROM accountattempt WHERE guid = :guid ORDER BY time DESC LIMIT 1');
            $query->bindParam(':guid', $guid);
            $query->execute();
            $result = $query->fetch();
            $time = $result;
            
            if (empty($time)) {
                return;
            }
            if ($time['time'] < date("Y-m-d H:i:s" ,strtotime('+2 hours -2 minutes')))  {
                $this->resetAttempt($guid);
            }
        }   

        // On supprime les tentatives de connexion
        public function resetAttempt(string $guid): void {
            $query = $this->database->getConnection()->prepare('DELETE FROM accountattempt WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
        }

        // On vérifie si l'utilisateur a fait trop de tentatives de connexion
        public function isBruteForce(string $guid): bool {
            $query = $this->database->getConnection()->prepare('SELECT COUNT(*) as attempts FROM accountattempt WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
        
            $result = $query->fetch();
            $attempts = $result['attempts'];
        
            if ($attempts >= 4) {
                return true;
            } else {
                return false;
            }
        }
    }
?>