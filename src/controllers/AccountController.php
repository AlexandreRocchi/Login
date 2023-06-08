<?php

    namespace Login\Controllers;    

    require_once('./src/models/Database.php');
    require_once('./src/models/User.php');
    require_once('./src/models/Account.php');

    use Login\src\Models\DatabaseConnection;
    use Login\src\Models\User;
    use Login\src\Models\Account;

    class AccountController 
    {
        public function session() {
            if (isset($_SESSION['email'])) {
                echo "Bienvenue sur votre compte " . $_SESSION['email'] . " !";
                $email = $_SESSION['email'];
                require_once('./views/Session.php');
            } else {
                header('Location: login');
            }

            if (isset($_POST['delete'])) {
                $email = $_SESSION['email'];

                $database = new DatabaseConnection();
                $database->getConnection();

                $user = new User($database);
                $account = new Account($database);

                $user->setEmail($_SESSION['email']);
                $user->setGuid($user->getGuidFromEmail($email));

                $user->deleteUser($email);
                $account->deleteAccount($user->getGuid());
                session_destroy();
                header('Location: login');
            }

            if (isset($_POST['logout'])) {
                session_destroy();
                header('Location: login');
             }
            if (isset($_POST['reset'])) {
                header('Location: reset-password');
            }
            }
        }
?>