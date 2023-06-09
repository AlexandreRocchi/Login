<?php

    namespace Login\Controllers;

    require_once('./src/models/Database.php');
    require_once('./src/models/User.php');
    require_once('./src/models/Account.php');

    use Login\src\Models\DatabaseConnection;
    use Login\src\Models\User;
    use Login\src\Models\Account;
    use Exception;

    class RegisterController
    {
        
        public function register() 
        {
            try {
                if (isset($_POST['password'])) {
                    
                    $database = new DatabaseConnection();

                    $user = new User($database);
                    $account = new Account($database);


                    $user->setEmail($_POST['email']);
                    $account->setPassword($_POST['password']);
                    $user->setGuid($user->generateGuid());
                    $account->setSalt($account->generateSalt());

                    if ($user->isGuid($user->getGuid()) === true) {
                        throw new Exception("GUID déjà utilisé !");
                    }

                    if ($user->isEmail($user->getEmail()) === true) {
                        throw new Exception("Adresse e-mail déja utilisée !");
                    }

                    if ($user->verifEmail($user->getEmail()) === false) {
                        throw new Exception("Adresse e-mail invalide !");
                    }

                    $account->setPassword($account->saltPassword($account->getPassword(), $account->getSalt()));
                    $account->setPassword($account->securizePassword($account->getPassword()));

                    $user->adduser($user->getGuid(), $user->getEmail());
                    $account->addaccount($user->getGuid(), $account->getPassword(), $account->getSalt());
                        
                    header('Location: login');
                }
                else {
                    throw new Exception("Veuillez remplir tous les champs.");

                }
            }   
            catch (Exception $e) {
                $error =  $e->getMessage();
            }
            require_once('./views/Register.php'); 
        }
    }
    
?>