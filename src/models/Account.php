<?php

    namespace Login\src\Models;

    require_once('./src/models/Database.php');

    use Login\src\Models\DatabaseConnection;

    class Account
    {
        public string $guid;

        public string $password;

        public string $salt;

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
        
        public function getPassword(): string
        {
            return $this->password;
        }

        public function getSalt(): string
        {
            return $this->salt;
        }

        public function setGuid(string $guid): void
        {
            $this->guid = $guid;
        }

        public function setPassword(string $password): void
        {
            $this->password = $password;
        }

        public function setSalt(string $salt): void
        {
            $this->salt = $salt;
        }

        public function generateGuid(): int
        {
            $guid = com_create_guid();

            return $guid;
        }

        public function generateSalt(): string
        {
            $salt = bin2hex(random_bytes(16));

            return $salt;
        }

        public function getPasswordFromGuid(string $guid): string
        {
            $query = $this->database->getConnection()->prepare('SELECT password FROM account WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
            $password = $query->fetch();

            return $password['password'];
        
        }

        public function addAccount(string  $guid, string $password, string $salt ): void 
        {
            $query = $this->database->getConnection()->prepare('INSERT INTO account (guid, password, salt) VALUES (:guid, :password, :salt)');
            $query->bindParam(':guid', $guid);
            $query->bindParam(':password', $password);
            $query->bindParam(':salt', $salt);
            $query->execute();
        }

        public function deleteAccount(string $guid): void 
        {
            $query = $this->database->getConnection()->prepare('DELETE FROM account WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
        }

        public function updatePassword(string $guid, string $password, string $salt): void 
        {
            $query = $this->database->getConnection()->prepare('UPDATE account SET password = :password, salt = :salt WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->bindParam(':password', $password);
            $query->bindParam(':salt', $salt);
            $query->execute();
        }

        public function securizePassword(string $password): string
        {
            $password = hash('sha512', $password);
            return $password;

        }

        public function isPassword(string $password, string $input_password): bool
        {
            if (hash('sha512',$input_password) === $password) {
                return true;
            } else {
                return false;
            }
        }

        public function verifPasswordStrength(string $password) : bool
        {
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