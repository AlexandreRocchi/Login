<?php
    namespace Login\src\Models;
    
    class DatabaseConnection {
        public ?\PDO $database = null;

        // Crée une connexion à la base de données
        public function getConnection(): \PDO {
            if ($this->database === null) {
                $this->database = new \PDO('mysql:host=localhost;dbname=users', 'username', 'password');
            }
    
            return $this->database;
        }
    }
?>
