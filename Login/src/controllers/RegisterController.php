<?php

    namespace Login\Controllers;

    require_once('./src/models/Database.php');
    require_once('./src/models/User.php');
    require_once('./src/models/Account.php');
    require_once('./src/models/OTP.php');

    use Login\src\Models\DatabaseConnection;
    use Login\src\Models\User;
    use Login\src\Models\Account;
    use Login\src\Models\OTP;
    use Exception;

    class RegisterController {
        
        public function register() {
            try {
                if (isset($_POST['password'])) {
                    // On instancie les classes DatabaseConnection, User et Account
                    $database = new DatabaseConnection();
                    $user = new User($database);
                    $account = new Account($database);
                    $otp = new OTP($database);

                    // On récupère les données du formulaire
                    $user->setEmail($_POST['email']);
                    $account->setPassword($_POST['password']);

                    // On génère un guid 
                    $user->setGuid($user->generateGuid());

                    // Si vérifie si le guid exitent déjà dans la base de données (trés peu probable)
                    if ($user->isGuid($user->getGuid()) === true) {
                        throw new Exception("GUID déjà utilisé !");
                    }
                    
                    // On vérifie si l'email existe déjà dans la base de données
                    if ($user->isEmail($user->getEmail()) === true) {
                        throw new Exception("Adresse e-mail déja utilisée !");
                    }

                    // On vérifie si l'email est valide
                    if ($user->verifEmail($user->getEmail()) === false) {
                        throw new Exception("Adresse e-mail invalide !");
                    }

                    $otp->setGuid($user->getGuid());
                    $otp->setOtp($otp->generateOTP());
                    $otp->insertOtp($otp->getGuid(), $otp->getOtp());
                    $otp->displayOtp($otp->getOtp(),'register');

                    // On met le guid dans la session
                    $_SESSION['guid'] = $user->getGuid();
                    $_SESSION['email'] = $user->getEmail();
                    $_SESSION['password'] = $account->getPassword();
                }
                if (isset($_POST['confirm-otp'])) {
                    // On instancie les classes DatabaseConnection,User, Account et Otp
                    $database = new DatabaseConnection();
                    $user = new User($database);
                    $otp = new Otp($database);
                    $account = new Account($database);
                    
                    // On récupère les données de la session
                    $user->setGuid($_SESSION['guid']);
                    $user->setEmail($_SESSION['email']);
                    $account->setPassword($_SESSION['password']);

                    // On génère un salt
                    $account->setSalt($account->generateSalt());

                    // On vérifie si le code de vérification est correct
                    if ($otp->verifOtp($user->getGuid(), $_POST['otp']) === false) {
                        throw new Exception("Code de vérification incorrect !");
                    } else {
                        // On sale et on hashe le mot de passe déjà hashé de l'utilisateur
                        $account->setPassword($account->saltPassword($account->getPassword(), $account->getSalt()));
                        $account->setPassword($account->securizePassword($account->getPassword()));

                        // On ajoute l'utilisateur et son mot de passe dans la base de données
                        $user->adduser($user->getGuid(), $user->getEmail());
                        $account->addaccount($user->getGuid(), $account->getPassword(), $account->getSalt());
                        
                        // On redirige l'utilisateur vers la page de connexion
                        header('Location: login');
                    }
                }
            }
            // On récupère les exceptions et on les affiche
            catch (Exception $e) {
                $error =  $e->getMessage();
            }
            // On affiche la page d'inscription
            require_once('./views/Register.php'); 
        }
    }
    
?>