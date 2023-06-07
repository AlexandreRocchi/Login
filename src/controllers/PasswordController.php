<?php

    namespace Login\Controllers;

    require_once('./src/models/Database.php');
    require_once('./src/models/User.php');
    require_once('./src/models/Account.php');

    use Login\src\DataBase\DatabaseConnection;
    use Login\src\models\User;
    use Login\src\Models\Account;

    class PasswordController 
    {
        public function resetPassword() {
            // Logique pour traiter la réinitialisation du mot de passe
            // Utilise le modèle User.php et la vue ResetPassword.php
        }
    }
?>