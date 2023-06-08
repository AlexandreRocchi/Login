<?php

    namespace Login\Controllers;

    require_once('./src/models/Database.php');
    require_once('./src/models/User.php');
    require_once('./src/models/Account.php');

    use Login\src\Models\DatabaseConnection;
    use Login\src\Models\User;
    use Login\src\Models\Account;

    class RegisterController
    {
        
        public function register() 
        {

            require_once('./views/Register.php');
            
            if (isset($_POST['register'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                // Trouve une solution
                $guid = "";
                $salt = "";
                
                $database = new DatabaseConnection();

                $user = new User($email, $database);
                $account = new Account($database);

                $guid = $user->generateGuid();
                $salt = $account->generateSalt();

                if ($user->isGuid($guid) === true) {
                     echo "Erreur lors de la génération du compte !";
                     return;
                }

                if ($user->isEmail($email) === true) {
                    echo "Adresse e-mail déja utilisé !";
                    return;
                }

                if ($user->verifEmail($email) === false) {
                    echo "Adresse e-mail invalide !";
                    return;
                }

                if ($account->verifPasswordStrength($password) === false) {
                    echo "Mot de passe trop faible !";
                    return;
                } else {
                    $password = $account->securizePassword($password);
                }

                $user->adduser($guid, $email);
                $account->addaccount($guid, $password, $salt);
                    
                header('Location: login');
            }        
        }
    }
    
?>