<?php

    namespace Login\src\Models;

    require_once('../src/models/Database.php');

    use Login\src\Models\DatabaseConnection;

    class Attempt
    {
        public string $guid;

        public string $time;

        public DatabaseConnection $database;

        public function __construct($guid,$time, $database)
        {
            $this->guid = $guid;
            $this->time = $time;
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

        public function getTime(): string
        {
            return $this->time;
        }

        public function setGuid(int $guid): void
        {
            $this->guid = $guid;
        }

        public function setTime(string $time): void
        {
            $this->time = $time;
        }

        public function getTimeFromGuid(int $guid): int
        {
            $query = $this->database->prepare('SELECT time FROM accountattempt WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();

            $time = $query->fetch();

            return $time;
        }

        public function initAttempt(int $guid): void
        {
            $query = $this->database->prepare('INSERT INTO accountattempt (guid, time) VALUES (:guid, 0)');
            $query->bindParam(':guid', $guid);
            $query->execute();
        }

        public function addAttempt(int $guid, $time): void
        {
            $time++;
            $query = $this->database->prepare('UPDATE accountattempt SET time = :time WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->bindParam(':time', $time);
            $query->execute();
        }

        public function isBruteForce(int $guid): bool
        {
            $query = $this->database->prepare('SELECT time FROM accountattempt WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();

            $time = $query->fetch();

            if ($time >= 5) {
                return true;
            } else {
                return false;
            }
        }

        public function resetAttempt(int $guid): void
        {
            $query = $this->database->prepare('UPDATE accountattempt SET time = 0 WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
        }
    }
?>