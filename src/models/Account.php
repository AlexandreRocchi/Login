<?php

    namespace Login\Controllers;

    require_once('../src/models/Database.php');

    use Login\Lib\DataBase\DatabaseConnection;

    class Account
    {
        public int $guid;

        public string $password;

        public string $salt;

        public DatabaseConnection $database;

        public function __construct($guid, $password, $salt, $database)
        {
            $this->guid = $guid;
            $this->password = $password;
            $this->salt = $salt;
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
        
        public function getPassword(): string
        {
            return $this->password;
        }

        public function getSalt(): string
        {
            return $this->salt;
        }

        public function setGuid(int $guid): void
        {
            $this->guid = $guid;
        }

        public function setPassword(string $password): void
        {
            $this->password = $password;
        }

        public function generateGuid(): int
        {
            $guid = com_create_guid();

            return $guid;
        }

        public function getPasswordFromGuid(int $guid): string
        {
            $query = $this->database->prepare('SELECT password FROM account WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
            $password = $query->fetch
            $password = $password['password'];

            return $password;
        
        }

        public function addAccount(int $guid, string $password, string $salt ): void 
        {
            // Trouver une solution pour éviter ça
            $salt = password_get_info($password)['salt'];
            //
            $query = $database->prepare('INSERT INTO account (guid, password, salt) VALUES (:guid, :password, :salt)');
            $query->bindParam(':guid', $guid);
            $query->bindParam(':password', $password);
            $query->bindParam(':salt', $salt);
            $query->execute();
        }

        public function deleteAccount(int $guid): void 
        {
            $query = $database->prepare('DELETE FROM account WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
        }

        public function updatePassword(int $guid, string $password, string $salt): void 
        {
            // Trouver une solution pour éviter ça
            $salt = password_get_info($password)['salt'];
            //
            $query = $database->prepare('UPDATE account SET password = :password, salt = :salt WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->bindParam(':password', $password);
            $query->bindParam(':salt', $salt);
            $query->execute();
        }

        public function securizePassword(string $password): string
        {
            $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 1000]);
            return $password;

        }

        public function isPassword(string $password, string $input_password): bool
        {
            if (password_verify($input_password, $password)) {
                return true;
            } else {
                return false;
            }
        }

        public function verifPasswordStrengh(string $password) : bool
            if (strlen($password) < 12) {
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