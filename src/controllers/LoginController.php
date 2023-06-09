<?php

    namespace Login\Controllers;

    session_start();
    
    require_once('./src/models/Database.php');
    require_once('./src/models/User.php');
    require_once('./src/models/Account.php');
    require_once('./src/models/Attempt.php');

    use Login\src\Models\DatabaseConnection;
    use Login\src\Models\User;
    use Login\src\Models\Account;
    use Login\src\Models\Attempt;
    use Exception;

    class LoginController {
        
        public function login() {
            try {
                if (isset($_POST['login'])) {
                    // On instancie les classes DatabaseConnectionn, User, Account et Attempt
                    $database = new DatabaseConnection();
                    $user = new User($database);
                    $account = new Account($database);
                    $attempt = new Attempt($database);

                    // On récupère les données du formulaire
                    $user->setEmail($_POST['email']);
                    $account->setPassword($_POST['password']);

                    // On vérifie si l'email existe dans la base de données
                    if ($user->isEmail($user->getEmail()) === false) {
                        throw new Exception("Adressse mail invalide !");
                    } else {
                        // On récupère le guid avec l'email de l'utilisateur
                        $user->setGuid($user->getGuidFromEmail($user->getEmail()));
                    }

                    // On lance la fonction de débannissement de l'utilisateur
                    $attempt->debanAccount($user->getGuid());

                    // On vérifie si l'utilisateur à dépassé le nombre de tentative de connexion
                    if ($attempt->isBruteForce($user->getGuid()) === true) {
                        throw new Exception("Compte bloqué !");
                    }
                    // On vérifie si le mot de passe est valide
                    if ($account->isPassword($account->getPasswordFromGuid($user->getGuid()), $account->getPassword(), $account->getSaltFromGuid($user->getGuid())) === false) {
                        // Si l'utlisateur n'a pas mis le bon mot de passe, on ajoute une tentative de connexion
                        $attempt->addAttempt($user->getGuid());
                        
                        throw new Exception("Mot de passe invalide !");
                    
                        } else {
                            // On reset le nombre de tentative de connexion et on stocke l'email et le guid dans des variables de session
                            $attempt->resetAttempt($user->getGuid());
                            $_SESSION['email'] = $user->getEmail();
                            $_SESSION['guid'] = $user->getGuid();

                            // On redirige l'utilisateur vers la page de son compte
                            header('Location: account');
                        }
                    }
                    else {
                        throw new Exception("Veuillez remplir tous les champs.");
                    }
                }
                // On récupère les exceptions et on les affiche
                catch (Exception $e) {
                    $error =  $e->getMessage();
                }

                // On affiche la page de connexion
                require_once('./views/Login.php');   
            }
        }
?>
