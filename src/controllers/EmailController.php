<?php

    namespace Login\Controllers;

    require_once('./src/models/Database.php');
    require_once('./src/models/User.php');
    require_once('./src/models/Account.php');

    use Login\Lib\DataBase\DatabaseConnection;
    use Login\Lib\Models\User;
    use Login\Lib\Models\Account;

    class EmailController 
    {
        public function confirmEmail() {
            // Logique pour traiter la confirmation de l'adresse e-mail
            // Utilise le modèle User.php et la vue ConfirmEmail.php
           
        }
    
        
    }
?>