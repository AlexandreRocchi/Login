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

                $database = new DatabaseConnection();

                $user = new User($database);
                $account = new Account($database);
                
                $hashedPassword = $_POST['hashed-password'];
                echo $hashedPassword;

                $user->setEmail($_POST['email']);
                $account->setPassword($_POST['password']);
                $user->setGuid($user->generateGuid());
                $account->setSalt($account->generateSalt());

                if ($user->isGuid($user->getGuid()) === true) {
                     echo "Erreur lors de la génération du compte !";
                     return;
                }

                if ($user->isEmail($user->getEmail()) === true) {
                    echo "Adresse e-mail déja utilisé !";
                    return;
                }

                if ($user->verifEmail($user->getEmail()) === false) {
                    echo "Adresse e-mail invalide !";
                    return;
                }

                if ($account->verifPasswordStrength($account->getPassword()) === false) {
                    echo "Mot de passe trop faible !";
                    return;
                } else {
                    $account->setPassword($account->securizePassword($account->getPassword()));
                }

                $user->adduser($user->getGuid(), $user->getEmail());
                $account->addaccount($user->getGuid(), $account->getPassword(), $account->getSalt());
                    
                // header('Location: login');
            }        
        }
    }
    
?>