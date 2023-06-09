<?php

    namespace Login\Controllers;    

    require_once('./src/models/Database.php');
    require_once('./src/models/User.php');
    require_once('./src/models/Account.php');

    use Login\src\Models\DatabaseConnection;
    use Login\src\Models\User;
    use Login\src\Models\Account;
    use Exception;

    class AccountController {
        public function session() {
                if (isset($_SESSION['email'])) {
                    // On personalise le message de bienvenue
                    echo 'Bienvenue ' . $_SESSION['email'];

                    // On affiche la page de session
                    require_once('./views/Session.php'); 
                } else {
                    // On redirige vers la page de connexion les utilisateurs non connectés
                    header('Location: login');
                }
                if (isset($_POST['delete'])) {
                    // On instancie les classes DatabaseConnection, User et Account
                    $database = new DatabaseConnection();
                    $user = new User($database);
                    $account = new Account($database);

                    // On récupère l'email de l'utilisateur connecté
                    $user->setEmail($_SESSION['email']);

                    // On récupère le guid de l'utilisateur connecté grâce à son email
                    $user->setGuid($user->getGuidFromEmail($_SESSION['email']));

                    // On supprime l'utilisateur et son compte ainsi que sa session
                    $user->deleteUser($_SESSION['email']);
                    $account->deleteAccount($user->getGuid());
                    session_destroy();

                    // On redirige vers la page de connexion
                    header('Location: login');
                } 

                if (isset($_POST['logout'])) {
                    // On supprime la session de l'utilisateur
                    session_destroy();
                    // On redirige vers la page de connexion
                    header('Location: login');
                }
                if (isset($_POST['reset'])) {
                    // On redirige vers la page de réinitialisation de mot de passe
                    header('Location: reset-password');
                }           
        }
    }
?>