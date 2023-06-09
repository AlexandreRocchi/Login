<?php

    namespace Login\src\Models;

    require_once('./src/models/Database.php');

    use Login\src\Models\DatabaseConnection;

    class Account {
        // On déclare les propriétés de la classe Account
        public string $guid;
        public string $password;
        public string $salt;
        public DatabaseConnection $database;

        // On déclare le constructeur de la classe Account
        public function __construct($database) {
            $this->database = $database;
        }

        // On déclare les getters et les setters de la classe Account
        public function getDatabase(): DatabaseConnection {
            return $this->database;
        }


        public function getGuid(): string {
            return $this->guid;
        }
        
        public function getPassword(): string {
            return $this->password;
        }

        public function getSalt(): string {
            return $this->salt;
        }

        public function setGuid(string $guid): void {
            $this->guid = $guid;
        }

        public function setPassword(string $password): void {
            $this->password = $password;
        }

        public function setSalt(string $salt): void {
            $this->salt = $salt;
        }

        // On génère un guid aléatoire
        public function generateGuid(): int {
            $guid = com_create_guid();

            return $guid;
        }

        // On génère un salt aléatoire
        public function generateSalt(): string {
            $salt = bin2hex(random_bytes(16));

            return $salt;
        }

        // On récupère le guid à partir de l'email
        public function getPasswordFromGuid(string $guid): string {
            $query = $this->database->getConnection()->prepare('SELECT password FROM account WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
            $password = $query->fetch();

            return $password['password'];
        
        }

        // On récupère le salt à partir du guid
        public function getSaltFromGuid(string $guid): string  {
            $query = $this->database->getConnection()->prepare('SELECT salt FROM account WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
            $salt = $query->fetch();

            return $salt['salt'];
        }

        // On ajoute un mot de passe dans la base de données (guid, password  et salt)
        public function addAccount(string  $guid, string $password, string $salt): void  {
            $query = $this->database->getConnection()->prepare('INSERT INTO account (guid, password, salt) VALUES (:guid, :password, :salt)');
            $query->bindParam(':guid', $guid);
            $query->bindParam(':password', $password);
            $query->bindParam(':salt', $salt);
            $query->execute();
        }

        // On supprime un mot de passe de la base de données (guid, password et salt)
        public function deleteAccount(string $guid): void {
            $query = $this->database->getConnection()->prepare('DELETE FROM account WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
        }

        // On met à jour un mot de passe dans la base de données (guid, password et salt)
        public function updatePassword(string $guid, string $password, string $salt): void {
            $query = $this->database->getConnection()->prepare('UPDATE account SET password = :password, salt = :salt WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->bindParam(':password', $password);
            $query->bindParam(':salt', $salt);
            $query->execute();
        }

        // On concatène un mot de passe un le salt et on les hash
        public function saltPassword(string $password, string $salt): string {
            $password = hash('sha512', $password . $salt);
            return $password;
        }

        // On hash un mot de passe
        public function securizePassword(string $password): string {
            $password = hash('sha512', $password);
            return $password;

        }

        // On vérifie si le mot de passe est correct
        public function isPassword(string $password, string $input_password, string $salt): bool {
            if (hash('sha512',hash('sha512',hash('sha512',$input_password) . $salt)) === $password) {
                return true;
            } else {
                return false;
            }
        }

        // On vérifie si le mot de passe est suffisamment fort
        public function verifPasswordStrength(string $password) : bool {
            if (strlen($password) < 12){
                return false;
            } if (!preg_match("#[a-z]#", $password)) {
                    return false;
                } if (!preg_match("#[A-Z]#", $password)) {
                        return false;
                    } if (!preg_match("#[0-9]#", $password)) {
                            return false;
                        } if (!preg_match("#\W+#", $password)) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    }
    ?>