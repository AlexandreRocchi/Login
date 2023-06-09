<?php

    namespace Login\Controllers;

    require_once('./src/models/Database.php');
    require_once('./src/models/Account.php');
    require_once('./src/models/Otp.php');

    use Login\src\Models\DatabaseConnection;
    use Login\src\Models\Account;
    use Login\src\Models\Otp;
    use Exception;

    class ResetPasswordController 
    {

        public function resetPassword() 
        {
            try {
                if (isset($_POST['reset-password']) && isset($_SESSION['guid'])) {
                    // On récupère les données du formulaire
                    $confirmPassword = $_POST['confirm-password'];
                    $old_password = $_POST['old-password'];

                    // On instancie les classes DatabaseConnection, Account et Otp
                    $database = new DatabaseConnection();
                    $account = new Account($database);
                    $otp = new Otp($database);	

                    // On récupère le mot de passe et le guid de l'utilisateur
                    $account->setPassword($_POST['password']);
                    $account->setGuid($_SESSION['guid']);
                    
                    // On vérifie si l'ancien mot de passe est correct
                    if ($account->isPassword($account->getPasswordFromGuid($account->getGuid()),$old_password, $account->getSaltFromGuid($account->getGuid())) === false) {
                        throw new Exception("L'ancien mot de passe est incorrect !");
                    }

                    // On vérifie si le nouveau mot de passe n'a pas déjà été utilisé
                    if ($old_password === $account->getPassword()) {
                        throw new Exception("Le nouveau mot de passe à déjà été utilisé sur ce compte !");
                    }

                    // On vérifie si les mots de passe correspondent
                    if ($account->getPassword() === $confirmPassword) {
                        // On vérifie si le nouveau mot de passe est assez sécurisé
                        if ($account->verifPasswordStrength($account->getPassword()) === false) {
                            throw new Exception("Le nouveau mot de passe n'est pas assez sécurisé !");
                        } else {
                            // On stocke le nouveau mot de passe dans la session
                            $_SESSION['password'] = $account->getPassword();

                            // On récupère le guid de l'utilisateur
                            $otp->setGuid($_SESSION['guid']);

                            // On génère un code de vérification
                            $otp->setOtp($otp->generateOtp());

                            // On insère le code de vérification dans la base de données
                            $otp->insertOtp($otp->getGuid(), $otp->getOtp());

                            // On affiche le code de vérification
                            $otp->displayOtp($otp->getOtp(),'reset-password');

                            
                            // header('Location: reset-password');

                        }
                    } else {
                        // On affiche un message d'erreur
                        throw new Exception("Les mots de passe ne correspondent pas !");
                    }
                    }
                if (isset($_POST['confirm-otp'])) {
                    // On instancie les classes DatabaseConnection, Account et Otp
                    $database = new DatabaseConnection();
                    $otp = new Otp($database);
                    $account = new Account($database);

                    $account->setGuid($_SESSION['guid']);

                    // On vérifie si le code de vérification est correct
                    if ($otp->verifOtp($account->getGuid(), $_POST['otp']) === false) {
                        throw new Exception("Le code de vérification est incorrect !");
                    } else {

                        // On récupère le mot de passe de la session
                        $account->setPassword($_SESSION['password']);

                        // On génère un nouveau salt
                        $account->setSalt($account->generateSalt());

                        // On sécurise le mot de passe
                        $account->setPassword($account->securizePassword($account->getPassword()));
                        $account->setPassword($account->saltPassword($account->getPassword(), $account->getSalt()));
                        $account->setPassword($account->securizePassword($account->getPassword()));


                        // On met à jour le mot de passe dans la base de données
                        $account->updatePassword($account->getGuid(), $account->getPassword(), $account->getSalt());

                        // On supprime le code de vérification de la base de données
                        $otp->deleteOtp($_SESSION['guid']);

                        // On affiche un message de succès
                        throw new Exception("Le mot de passe à bien été modifié !");
                    }
                }
            }
            // On récupère les exceptions et on les affiche
            catch (Exception $e) {
                $error =  $e->getMessage();
            }
            // On affiche la page d'inscription
            require_once('./views/ResetPassword.php'); 
            }
        }
?>