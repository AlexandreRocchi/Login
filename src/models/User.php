<?php

    namespace Login\Controllers;

    require_once('./src/models/Database.php');

    use Login\Lib\DataBase\DatabaseConnection;

    class User
    {
        public int $guid;

        public string $email;

        public  DatabaseConnection $database;

        public function __construct($guid, $email, $database)
        {
            $this->guid = $guid;
            $this->email = $email;
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
        
        public function getEmail(): string
        {
            return $this->email;
        }

        public function setGuid(int $guid): void
        {
            $this->guid = $guid;
        }

        public function setEmail(string $email): void
        {
            $this->email = $email;
        }

        public function generateGuid(): int
        {
            $guid = com_create_guid();

            return $guid;
        }

        public function getGuidFromEmail(string $email): int
        {
            $query = $this->database->prepare('SELECT guid FROM user WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
            $guid = $query->fetch();
            $guid = $guid['guid'];

            return $guid;
        }

        public function getEmailFromGuid(int $guid): string
        {
            $query = $this->database->prepare('SELECT email FROM user WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
            $email = $query->fetch();
            $email = $email['email'];

            return $email;
        }
        
        public function isGuid(int $guid): bool
        {
            $query = $this->database->prepare('SELECT guid FROM user WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
            $guid = $query->fetch();
            $guid = $guid['guid'];

            if ($guid == $guid) {
                return true;
            } else {
                return false;
            }
        }

        public function isEmail(string $email): bool
        {
            $query = $this->database->prepare('SELECT email FROM user WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
            $email = $query->fetch();
            $email = $email['email'];

            if ($email == $email) {
                return true;
            } else {
                return false;
            }
        }

        public function addUser(int $guid, string $email): void
        {
            $query = $this->database->prepare('INSERT INTO user (email) VALUES (:email)');
            $query->bindParam(':guid', $guid);
            $query->bindParam(':email', $email);
            $query->execute();
        }

        public function deleteUser(string $email): void
        {
            $query = $this->database->prepare('DELETE FROM user WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
        }

        public function isUser(string $email): bool
        {
            $query = $this->database->prepare('SELECT email FROM user WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
            $email = $query->fetch();
            $email = $email['email'];

            if ($email == $email) {
                return true;
            } else {
                return false;
            }
        }
    }