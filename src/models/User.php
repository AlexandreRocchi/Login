<?php

    namespace Login\src\Models;

    require_once('./src/models/Database.php');

    use Login\src\Models\DatabaseConnection;

    class User
    {
        public string $guid;

        public string $email;

        public  DatabaseConnection $database;

        public function __construct($email, $database)
        {
            $this->email = $email;
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
        
        public function getEmail(): string
        {
            return $this->email;
        }

        public function setGuid(string $guid): void
        {
            $this->guid = $guid;
        }

        public function setEmail(string $email): void
        {
            $this->email = $email;
        }

        public function generateGuid(): string
        {
            $guid = com_create_guid();

            return $guid;
        }

        public function getGuidFromEmail(string $email): string
        {
            $query = $this->database->getConnection()->prepare('SELECT guid FROM user WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
            $guid = $query->fetch();
            $guid = $guid['guid'];

            return $guid;
        }

        public function getEmailFromGuid(string $guid): string
        {
            $query = $this->database->getConnection()->prepare('SELECT email FROM user WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
            $email = $query->fetch();
            $email = $email['email'];

            return $email;
        }
        
        public function isGuid(string $guid): bool
        {
            $query = $this->database->getConnection()->prepare('SELECT guid FROM user WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();

            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function isEmail(string $email): bool
        {
            $query = $this->database->getConnection()->prepare('SELECT email FROM user WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();;

            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function addUser(string $guid, string $email): void
        {
            $query = $this->database->getConnection()->prepare('INSERT INTO user (guid, email) VALUES (:guid, :email)');
            $query->bindParam(':guid', $guid);
            $query->bindParam(':email', $email);
            $query->execute();
        }

        public function deleteUser(string $email): void
        {
            $query = $this->database->getConnection()->prepare('DELETE FROM user WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
        }

        public function verifEmail(string $email): bool
        {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        }
    }