<?php

    namespace Login\Controllers;

    require_once('../src/models/Database.php');

    use Login\Lib\DataBase\DatabaseConnection;

    class VerifPassword
    {
        public static function verifPassword(): bool
        {
            $database = new DatabaseConnection();
            $database = $database->getConnection();

            $pwd = $_POST['pwd'];
            
            if (strlen($pwd) < 12) {
                return false;
            } if (!preg_match("#[a-z]#", $pwd)) {
                    return false;
                } if (!preg_match("#[A-Z]#", $pwd)) {
                        return false;
                    } if (!preg_match("#[0-9]#", $pwd)) {
                            return false;
                        } if (!preg_match("#\W+#", $pwd)) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    }

?>
