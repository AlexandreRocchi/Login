<?php

    namespace Login\src\Models;

    require_once('./src/models/Database.php');

    use Login\src\Models\DatabaseConnection;

    class Attempt
    {
        public string $guid;

        public string $time;

        public DatabaseConnection $database;

        public function __construct($database)
        {
            $this->database = $database;
        }
        
        public function getDatabase(): DatabaseConnection
        {
            return $this->database;
        }

        public function getGuid(): string
        {
            return $this->guid;
        }

        public function getTime(): string
        {
            return $this->time;
        }

        public function setGuid(string $guid): void
        {
            $this->guid = $guid;
        }

        public function setTime(string $time): void
        {
            $this->time = $time;
        }

        public function addAttempt(string $guid): void
        {
            $query = $this->database->getConnection()->prepare('INSERT INTO accountattempt (guid, time) VALUES (:guid, NOW())');
            $query->bindParam(':guid', $guid);
            $query->execute();
        }

        public function resetAttempt(string $guid): void
        {
            $query = $this->database->getConnection()->prepare('DELETE FROM accountattempt WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
        }

        public function isBruteForce(string $guid): bool
        {
            $query = $this->database->getConnection()->prepare('SELECT COUNT(*) as attempts FROM accountattempt WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
        
            $result = $query->fetch();
            $attempts = $result['attempts'];
        
            if ($attempts >= 5) {
                return true;
            } else {
                return false;
            }
        }
    }
?>