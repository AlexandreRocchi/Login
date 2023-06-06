<?php

    namespace Login\Controllers;

    require_once('../src/models/Database.php');

    use Login\Lib\DataBase\DatabaseConnection;

    class ResetPassword
    {
        public function resetPassword(): void
        {
            // ini_set('SMTP', 'login@php.com');
            // ini_set('smtp_port', 25);

            $database = new DatabaseConnection();
            $database = $database->getConnection();
        
            $email = $_POST['email'];

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
    }
?>