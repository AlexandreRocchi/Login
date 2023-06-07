<?php

    namespace Login\Controllers;

    require_once('./src/models/Database.php');
    require_once('./src/models/User.php');
    require_once('./src/models/Otp.php');

    use Login\src\Models\DatabaseConnection;
    use Login\src\Models\User;
    use Login\src\Models\Otp;

    class ResetPasswordController 
    {
        public function resetPassword() 
        {
            require_once('./views/ResetPassword.php');
            if (isset($_POST['resetpassword'])) {
                $email = $_POST['email'];

                $database = new DatabaseConnection();

                $user = new User($email, $database);
                $otp = new Otp($database);

                if ($user->isEmail($email === true) && $user->verifEmail($email) === true) {
                    $guid = $user->getGuidFromEmail($email);

                    $otp->generateOtp($email);

                    $otp->insertOtp();

                    $otp->displayOtp();

                    header('Location: confirm-email');
                } else {
                    echo 'Le mail n\'a pas pu être envoyé !';
                }
            }
            
        
            
        }
    }
?>