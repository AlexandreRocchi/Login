<?php

    namespace Login\Controllers;

    require_once('./src/models/Database.php');
    require_once('./src/models/User.php');
    require_once('./src/models/Account.php');

    use Login\src\Models\DatabaseConnection;
    use Login\src\Models\User;
    use Login\src\Models\Account;
    use Exception;

    class RegisterController {
        
        public function register() {
            try {
                if (isset($_POST['password'])) {
                    // On instancie les classes DatabaseConnection, User et Account
                    $database = new DatabaseConnection();
                    $user = new User($database);
                    $account = new Account($database);

                    // On récupère les données du formulaire
                    $user->setEmail($_POST['email']);
                    $account->setPassword($_POST['password']);

                    // On génère un guid et un salt
                    $user->setGuid($user->generateGuid());
                    $account->setSalt($account->generateSalt());

                    // Si vérifie si le guid exitent déjà dans la base de données (trés peu probable)
                    if ($user->isGuid($user->getGuid()) === true) {
                        throw new Exception("GUID déjà utilisé !");
                    }
                    
                    // On vérifie si l'email existe déjà dans la base de données
                    if ($user->isEmail($user->getEmail()) === true) {
                        throw new Exception("Adresse e-mail déja utilisée !");
                    }

                    // On vérifie si l'email est valide
                    if ($user->verifEmail($user->getEmail()) === false) {
                        throw new Exception("Adresse e-mail invalide !");
                    }

                    // On sale et on hashe le mot de passe déjà hashé de l'utilisateur
                    $account->setPassword($account->saltPassword($account->getPassword(), $account->getSalt()));
                    $account->setPassword($account->securizePassword($account->getPassword()));

                    // On ajoute l'utilisateur et son mot de passe dans la base de données
                    $user->adduser($user->getGuid(), $user->getEmail());
                    $account->addaccount($user->getGuid(), $account->getPassword(), $account->getSalt());
                    
                    // On redirige l'utilisateur vers la page de connexion
                    header('Location: login');
                }
                else {
                    throw new Exception("Veuillez remplir tous les champs.");

                }
            }
            // On récupère les exceptions et on les affiche
            catch (Exception $e) {
                $error =  $e->getMessage();
            }
            // On affiche la page d'inscription
            require_once('./views/Register.php'); 
        }
    }
    
?>