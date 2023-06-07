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
            echo "Bienvenue sur votre compte " . $_SESSION['email'] . " !";

            require_once('./views/Session.php');

            if (isset($_POST['delete'])) {
                
            }
            
            if (isset($_POST['logout'])) {
                session_destroy();
                header('Location: login');
            }
        }
    }
?>