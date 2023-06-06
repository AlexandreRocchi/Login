<?php

    namespace Login\Controllers;

    require_once('../src/models/Database.php');
    require_once('../src/controllers/AntiBruteForce.php');
    require_once('../src/controllers/ResetBruteForce.php');

    use Login\Lib\DataBase\DatabaseConnection;
    use Login\Controllers\AntiBruteForce;
    use Login\Controllers\ResetBruteForce;

    class IsUser
    {
        public function isUser(): void
        {
            $database = new DatabaseConnection();
            $database = $database->getConnection();
        
            $email = $_POST['email'];
            $pwd = $_POST['pwd'];
    
            $query = $database->prepare("SELECT * FROM account AS a
                JOIN user AS u ON a.guid = u.guid
                WHERE u.email = :email");
    
            $query->bindParam(':email', $email);
            $query->execute();
    
            $account = $query->fetch();
    
            if ($account === false) {
                echo 'Mauvais identifiant ou mot de passe !';
            } else {
                if (AntiBruteForce::antiBruteforce() === false) {
                    echo 'Trop de tentatives de connexion !';
                    return;
                }
                $hashedPwd = hash('sha512', $pwd);
                if ($hashedPwd === $account['password']) {
                    ResetBruteForce::resetBruteForce();
                    $_SESSION['user'] = $account['guid'];
                    $_SESSION['email'] = $email;
                        header('Location: Session.php');
                } else {
                    echo 'Mauvais identifiant ou mot de passe !';
                }
            }
        }
    }
?>    