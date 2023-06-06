<?php

    namespace Login\Controllers;

    require_once('../src/models/Database.php');
    require_once('../src/controllers/VerifPassword.php');

    use Login\Lib\DataBase\DatabaseConnection;
    use Login\Controllers\VerifPassword;

    class ChangePassword
    {
        public function changePassword(): void
        {

            $database = new DatabaseConnection();
            $database = $database->getConnection();

            $oldpwd = $_POST['oldpwd'];
            $pwd = $_POST['pwd'];
            $guid = $_SESSION['guid'];

            $oldpwd = hash('sha512', $oldpwd);
            $pwd = hash('sha512', $pwd);

            $query = $database->prepare('SELECT password FROM account WHERE guid = :guid');
            $query->bindParam(':guid', $guid);
            $query->execute();
            $password = $query->fetch();
            $password = $password['password'];
            if (VerifPassword::verifPassword() === false) {
                echo 'Mot de passe non conforme !';
            } else {
                if ($oldpwd == $password) {
                    $query = $database->prepare('UPDATE account SET password = :pwd WHERE guid = :guid');
                    $query->bindParam(':pwd', $pwd);
                    $query->bindParam(':guid', $guid);
                    $query->execute();
                    echo 'Mot de passe changé !';
                } else {
                    echo 'Ancien mot de passe incorrect.';
                }
            }      
    }
}
?>