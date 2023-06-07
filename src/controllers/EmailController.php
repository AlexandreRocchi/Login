<?php

    namespace Login\Controllers;

    require_once('./src/models/Database.php');
    require_once('./src/models/User.php');
    require_once('./src/models/Account.php');

    use Login\src\DataBase\DatabaseConnection;
    use Login\src\models\User;
    use Login\src\Models\Account;

    class EmailController 
    {
        public function confirmEmail() {
            // Logique pour traiter la confirmation de l'adresse e-mail
            // Utilise le modèle User.php et la vue ConfirmEmail.php
           
        }
    
        
    }
?>