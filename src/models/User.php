<?php

    namespace Login\src\Models;

    require_once('./src/models/Database.php');

    use Login\src\Models\DatabaseConnection;

    class User {
        // On déclare les propriétés de la classe User
        public string $guid;
        public string $email;
        public DatabaseConnection $database;

        // On déclare le constructeur de la classe User
        public function __construct($database) {
            $this->database = $database;
        }

        // On déclare les getters et les setters de la classe User
        public function getDatabase(): DatabaseConnection {
            return $this->database;
        }

        public function getGuid(): string {
            return $this->guid;
        }
        
        public function getEmail(): string {
            return $this->email;
        }

        public function setGuid(string $guid): void {
            $this->guid = $guid;
        }

        public function setEmail(string $email): void {
            $this->email = $email;
        }

        // On génère un guid aléatoire
        public function generateGuid(): string {
            $guid = com_create_guid();

            return $guid;
        }

        // On récupère le guid à partir de l'email
        public function getGuidFromEmail(string $email): string {
            $query = $this->database->getConnection()->prepare('SELECT guid FROM user WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
            $guid = $query->fetch();
            $guid = $guid['guid'];

            return $guid;
        }

        // On récupère l'email à partir du guid
        public function getEmailFromGuid(string $guid): string {
            $query = $this->database->getConnection()->prepare('SELECT email FROM user WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
            $email = $query->fetch();
            $email = $email['email'];

            return $email;
        }
        
        // On vérifie si le guid existe
        public function isGuid(string $guid): bool {
            $query = $this->database->getConnection()->prepare('SELECT guid FROM user WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();

            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        // On vérifie si l'email existe
        public function isEmail(string $email): bool {
            $query = $this->database->getConnection()->prepare('SELECT email FROM user WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();;

            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        // On ajoute un utilisateur dans la base de données (email et guid)
        public function addUser(string $guid, string $email): void {
            $query = $this->database->getConnection()->prepare('INSERT INTO user (guid, email) VALUES (:guid, :email)');
            $query->bindParam(':guid', $guid);
            $query->bindParam(':email', $email);
            $query->execute();
        }

        // On supprime un utilisateur de la base de données (email et guid)
        public function deleteUser(string $email): void {
            $query = $this->database->getConnection()->prepare('DELETE FROM user WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
        }

        // On vérifie si l'email est au bon format
        public function verifEmail(string $email): bool {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        }
    }