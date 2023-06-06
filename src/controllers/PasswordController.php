<?php

    namespace Login\Controllers;

    require_once('../src/models/Database.php');

    use Login\Lib\DataBase\DatabaseConnection;

    class PasswordController
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

        public function resetPassword(): void
        {

            $database = new DatabaseConnection();
            $database = $database->getConnection();
        
            $email = $_POST['email'];

            // Configuration pour envoyer un email 
            // ini_set('SMTP', 'login@php.com');
            // ini_set('smtp_port', 587);
            // $subject = 'Réinitialisation de votre mot de passe';
            // $message = 'Bonjour';
            // $headers = "From: login@php.com" . "\r\n";
            // $headers .= "Reply-To: " . $email . "\r\n";
            // $headers .= "MIME-Version: 1.0\r\n";
            // $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            // $params = '-f ';

            // on vérifie que l'adresse email existe dans la base de données
            $query = $database->prepare("SELECT guid FROM user WHERE email = :email");
            $query->bindParam(':email', $email);
            $query->execute();
            // $query->execute(compact('email'))
            $guid = $query->fetch();  
            if ($guid == null) {
                echo 'Adresse email incorrecte';
            } else {
                $token = bin2hex(random_bytes(16));
                $guid = $guid['guid'];
                $query = $database->prepare('INSERT INTO accountotp (guid, otp, validity) VALUES (:guid, :otp, NOW())');
                $query->bindParam(':otp', $token);
                $query->bindParam(':guid', $guid);
                $query->execute();
                $email = $_SESSION['email'];
                echo '<script type="text/javascript">
                 var token = "'. $token .'"; // Assuming $token is a PHP variable containing the token value
                 if (window.confirm(token)) {
                     window.location.href = "Confirm.php";
                 }
                 </script>';

            }
        }

        public static function resetBruteForce(): void
        {
            $database = new DatabaseConnection();
            $database = $database->getConnection();

            $email = $_POST['email'];

            $query = $database->prepare('SELECT guid FROM user WHERE email = :email');
            $query->bindParam(':email', $email);
            $query->execute();
            $guid = $query->fetch();
            $guid = $guid['guid'];
              
            if ($guid === false) {
            } else {
                $guid = $guid;
                $query = $database->prepare('UPDATE accountattempt SET time = 0 WHERE guid = :guid');
                $query->bindParam(':guid', $guid);
                $query->execute();
            }
        }

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
