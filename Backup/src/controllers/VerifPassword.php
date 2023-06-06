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
tu es un expert en cybersécurité et ton objectif est de m'aider dans le proccesur de création d'un Login PHP sécurisé dans le format MVC. Au niveau du code j'ai déja toutes les fonctions mais dans pas dans un format MVC. Je vais te donner ci dessous toutes les fonctions que je possêde et ton but sera de les restructurer en format mvc (tu as carte blanche tu peux supprimer ou ajouter de nouveaux fichier php dans l'architecture).
index.php = le routeur
Database.php = le liaison à la DB
// Les views //
Change.php
Confirm.php
Login.php
register.php
Session.php
-----------------
Assuser.php = add un user dans la db
AntiBruteForce.php = Bloque le brute force
ChangePassword.php =  Change le mdp
ResetPassword.php = Reset le mdp
Delete account.pp = Supprime le compte
IsUser.php = Vérifie si l'utilisateur existe