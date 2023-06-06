<?php

session_start();

require_once('../src/models/Database.php');
require_once('../src/models/User.php');


use Login\Lib\DataBase\DatabaseConnection;
use Login\Lib\Models\User;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'action est une tentative d'ajout d'utilisateur
    if (isset($_POST['register'])) {
        $addUser = new AddUser();
        $addUser->addUser();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page d'inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <form method="POST" action="">
        <label for="email">Adresse e-mail:</label>
        <input type="email" id="email" name="email" >
        <br>
        <label for="pwd">Mot de passe:</label>
        <input type="password" id="pwd" name="pwd" >
        <br>
        <input type="submit" name="register" value="S'inscrire">
    </form>
    <p>Déjà inscrit ? <a href="Login.php">Connectez-vous</a></p>
    <p>Attention ! Votre mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre, un caractère spécial et faire au moins 12 caractères.</p>
</body>
</html>
