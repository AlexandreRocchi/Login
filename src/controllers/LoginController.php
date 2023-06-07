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

                $email = $_POST['email'];
                $password = $_POST['password'];
                
                $database = new DatabaseConnection();
                $database->getConnection();

                $user = new User($email, $database);
                $account = new Account($database);
                $attempt = new Attempt($database);

                if ($user->isEmail($email) === false) {
                    echo "Adresse e-mail invalide !";
                    return;
                } else {
                    $user->setGuid($user->getGuidFromEmail($email));
                }

                if ($account->isPassword($account->getPasswordFromGuid($user->getGuid()),$password) === false) {
                    echo "Mot de passe invalide !";
                    $attempt->addAttempt($user->getGuid());
                    if ($attempt->isBruteForce($user->getGuid()) === true) {
                        echo "Trop de tentatives de connexion !";
                        return;
                    }
                    return;
                    } else {
                        $attempt->resetAttempt($user->getGuid());
                        $_SESSION['email'] = $email;
                        echo "Connexion réussie !";
                        header('Location: account');
                    }
                }
            }
        }
?>
