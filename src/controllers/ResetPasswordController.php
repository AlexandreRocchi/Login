<?php

    namespace Login\Controllers;

    require_once('./src/models/Database.php');
    require_once('./src/models/Account.php');
    require_once('./src/models/Otp.php');

    use Login\src\Models\DatabaseConnection;
    use Login\src\Models\Account;
    use Login\src\Models\Otp;

    class ResetPasswordController 
    {

        public function resetPassword() 
        {
            require_once('./views/ResetPassword.php');

            if (isset($_POST['reset-password']) && isset($_SESSION['guid'])) {
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirm-password'];
                $old_password = $_POST['old-password'];
                $guid = $_SESSION['guid'];

                $database = new DatabaseConnection();
                $account = new Account($database);
                $otp = new Otp($database);	

                $account->setPassword($password);
                $account->setGuid($guid);
                
                $old_password_verif = $account->getPasswordFromGuid($guid);

                if ($account->isPassword($old_password_verif,$old_password, $account->getSaltFromGuid($account->getGuid())) === false) {
                    echo "Ancien mot de passe invalide !";
                    return;
                } 
                if ($old_password === $password) {
                    echo "Votre nouveau mot de passe a déjà été utilisé sur ce compte !";
                    return;
                }
                if ($password === $confirmPassword) {
                    if ($account->verifPasswordStrength($password) === false) {
                        echo "Votre nouveau mot de passe n'est pas assez sécurisé !";
                        return;
                    } else {
                        $_SESSION['password'] = $password;

                        $otp->setGuid($guid);
                        $otp->setOtp($otp->generateOtp());
                        $otp->insertOtp($otp->getGuid(), $otp->getOtp());
                        $otp->displayOtp($otp->getOtp());

                        
                        // header('Location: reset-password');

                    }
                } else {
                    echo "Les mots de passe ne correspondent pas !";
                    return;
                }

                } else {
                    header('Location: login');
                }
            if (isset($_POST['confirm-otp'])) {
                $input_otp = $_POST['otp'];
                $guid = $_SESSION['guid'];
                $password = $_SESSION['password'];

                $database = new DatabaseConnection();
                $otp = new Otp($database);
                $account = new Account($database);

                if ($otp->verifOtp($guid, $input_otp) === false) {
                    echo "Le code de vérification est incorrect !";
                    return;
                } else {
                    $account->setGuid($guid);
                    $account->setPassword($password);
                    $account->setSalt($account->generateSalt());
                    $account->setPassword($account->securizePassword($account->getPassword()));
                    $account->updatePassword($account->getGuid(), $account->getPassword(), $account->getSalt());
                    $otp->deleteOtp($guid);

                    echo "Votre mot de passe a bien été modifié !";
                    return;
                }


            }
            }
        
            
        }
?>