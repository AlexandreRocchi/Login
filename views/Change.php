<?php

session_start();

require_once('../src/models/Database.php');
require_once('../src/controllers/ChangePassword.php');

use Login\Controllers\ChangePassword;
use Login\Lib\Database\DatabaseConnection;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['change'])) {
        $confirmEmail = new ChangePassword();
        $confirmEmail->changePassword();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page de confirmation</title>
</head>
<body>

    <h3>Changer le mot de passe  :</h3>
    <form method="POST" action="">
        <label for="email">Ancien mot de passe :</label>
        <input type="password" id="oldpwd" name="oldpwd" required>
        <br>
        <label for="pwd">Nouveau mot de passe:</label>
        <input type="password" id="pwd" name="pwd" required>
        <br>
        <input type="submit" name="change" value="Appliquer">
        <p>Attention ! Votre mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre, un caractère spécial et faire au moins 12 caractères.</p>
    </form>
</body>
</html>