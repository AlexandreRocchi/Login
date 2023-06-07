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
            
        
            
        }
    }
?>