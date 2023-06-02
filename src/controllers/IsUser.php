<?php

    namespace Login\Controllers;

    require_once('../src/lib/database.php');

    use Login\Lib\DataBase\DatabaseConnection;

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
                header('Location: ../templates/index.php');
            } else {
                $hashedPwd = hash('sha512', $pwd);
    
                if ($hashedPwd === $account['password']) {
                    $_SESSION['user'] = $account['guid'];
                    echo 'You are logged in ' . $email;
                    // header('Location: ../src/controllers/Session.php');
                } else {
                    echo $hashedPwd;
                    echo '<br>';
                    echo $account['password'];
                    // header('Location: /Login.php');
                    echo '<br>';
                    echo 'Wrong password';
                }
            }
        }
    }
?>    