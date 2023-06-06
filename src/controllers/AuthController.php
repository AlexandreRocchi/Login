<?php

    namespace Login\Controllers;

    require_once('./src/models/Database.php');
    require_once('./src/models/User.php');
    require_once('./src/models/Account.php');

    use Login\Lib\DataBase\DatabaseConnection;
    use Login\Lib\Models\User;
    use Login\Lib\Models\Account;

    class AuthController
    {
        public function register() {
            // Logique pour traiter l'inscription de l'utilisateur
            // Utilise le modèle User.php et Account.php ainsi que la vue Register.php
            
        }

        public function login() {
            // Logique pour traiter la connexion de l'utilisateur
            // Utilise le modèle User.php et Account.php ainsi que la vue Login.php
        }
    }
    
?>