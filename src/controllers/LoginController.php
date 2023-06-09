<?php

    namespace Login\Controllers;

    session_start();
    
    require_once('./src/models/Database.php');
    require_once('./src/models/User.php');
    require_once('./src/models/Account.php');
    require_once('./src/models/Attempt.php');

    use Login\src\Models\DatabaseConnection;
    use Login\src\Models\User;
    use Login\src\Models\Account;
    use Login\src\Models\Attempt;

    class LoginController
    {
        
        public function login() {
            require_once('./views/Login.php');

            if (isset($_POST['login'])) {                
                $database = new DatabaseConnection();
                $database->getConnection();

                $user = new User($database);
                $account = new Account($database);
                $attempt = new Attempt($database);

                $user->setEmail($_POST['email']);
                $account->setPassword($_POST['password']);

                if ($user->isEmail($user->getEmail()) === false) {
                    echo "Adresse e-mail invalide !";
                    return;
                } else {
                    $user->setGuid($user->getGuidFromEmail($user->getEmail()));
                }

                $attempt->debanAccount($user->getGuid());

                if ($attempt->isBruteForce($user->getGuid()) === true) {
                    echo "Trop de tentatives de connexion !";
                    return;
                }

                if ($account->isPassword($account->getPasswordFromGuid($user->getGuid()), $account->getPassword(), $account->getSaltFromGuid($user->getGuid())) === false) {
                    echo "Mot de passe invalide !";
                    $attempt->addAttempt($user->getGuid());
                    return;
                    } else {
                        $attempt->resetAttempt($user->getGuid());
                        $_SESSION['email'] = $user->getEmail();
                        $_SESSION['guid'] = $user->getGuid();

                        header('Location: account');
                    }
                }
            }
        }
?>
