<?php

session_start();

require_once('../src/lib/database.php');
require_once('../src/controllers/AddUser.php');
require_once('../src/controllers/IsUser.php');

use Login\Controllers\AddUser;
use Login\Controllers\IsUser;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'action est une tentative de connexion
    if (isset($_POST['login'])) {
        $isUser = new IsUser();
        $isUser->isUser();
    }
    // Vérifier si l'action est une tentative d'ajout d'utilisateur
    elseif (isset($_POST['register'])) {
        $addUser = new AddUser();
        $addUser->addUser();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page de connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <form method="POST" action="">
        <label for="email">Adresse e-mail:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="pwd">Mot de passe:</label>
        <input type="password" id="pwd" name="pwd" required>
        <br>
        <input type="submit" name="login" value="Se connecter">
    </form>

    <h1>Inscription</h1>
    <form method="POST" action="">
        <label for="email">Adresse e-mail:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="pwd">Mot de passe:</label>
        <input type="password" id="pwd" name="pwd" required>
        <br>
        <input type="submit" name="register" value="S'inscrire">
    </form>
</body>
</html>
