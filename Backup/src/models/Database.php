<?php

    namespace Login\Lib\DataBase;
    
    class DatabaseConnection
    {
        public ?\PDO $database = null;
    
        public function getConnection(): \PDO
        {
            if ($this->database === null) {
                $this->database = new \PDO('mysql:host=localhost;dbname=users', 'root', '');
            }
    
            return $this->database;
        }
    }
?>