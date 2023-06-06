<?php

    namespace Login\Controllers;

    require_once('./src/models/Database.php');
    require_once('./src/models/User.php');
    require_once('./src/models/Account.php');

    use Login\Lib\DataBase\DatabaseConnection;
    use Login\Lib\Models\User;
    use Login\Lib\Models\Account;

    class AccountController 
    {
        public function index() {
            // Logique pour afficher la page du compte utilisateur
            // Utilise le modèle User.php et Account.php ainsi que la vue ChangePassword.php (Session.php?)
        }
    
        public function changePassword() {
            // Logique pour traiter la modification du mot de passe
            // Utilise le modèle User.php et Account.php ainsi que la vue ChangePassword.php
           
        }
    }
?>