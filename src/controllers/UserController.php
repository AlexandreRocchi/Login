<?php

    namespace Login\Controllers;

    require_once('../src/models/Database.php');;

    use Login\Lib\DataBase\DatabaseConnection;

    class UserController
    {
        public function addUser(): void
        {
            $database = new DatabaseConnection();
            $database = $database->getConnection();

            $pwd = $_POST['pwd'];
            $email = $_POST['email'];

            if (empty($email) || empty($pwd)) {
                echo 'Veuillez remplir tous les champs';
            } else {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo 'Adresse email invalide';
                } else {
                    $query = $database->prepare("SELECT email FROM user WHERE email = :email");
                    $query->bindParam(':email', $email);
                    $query->execute();
                    $user = $query->fetch();
                    if ($user === false) {
                        if (VerifPassword::verifPassword() === false) {
                            echo 'Essayer un autre mot de passe';
                        } else {
                            $salt = crypt($pwd, "SecretSalt");
                            $pwd = hash('sha512', $pwd);
                            
                            $userQuery = $database->prepare('INSERT INTO user (guid, email) VALUES (:guid, :email)');
                            $accountQuery = $database->prepare('INSERT INTO account (guid, password, salt) VALUES (:guid, :password, :salt)');
                
                            $userQuery->bindParam(':guid', $guid);
                            $userQuery->bindParam(':email', $email);
                            $userQuery->execute();
                
                            $accountQuery->bindParam(':guid', $guid);
                            $accountQuery->bindParam(':password', $pwd);
                            $accountQuery->bindParam(':salt', $salt);
                            $accountQuery->execute();
                            header('Location: Login.php');
                        }
                    } else {
                        echo 'Adresse email déjà utilisée';
                    }
                }
            }
            
        }
        
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