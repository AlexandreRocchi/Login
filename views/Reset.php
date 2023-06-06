<?php

session_start();

require_once('../src/models/Database.php');
require_once('../src/controllers/ResetPassword.php');


use Login\Controllers\ResetPassword;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'action est une demande de réinitialisation de mot de passe
    if (isset($_POST['resetpwd'])) {
        $resetPassword = new ResetPassword();
        $resetPassword->resetPassword();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page de réinitialisation</title>
</head>
<body>
    <h1>Mot de passe oublié ?</h1>
    <form method="POST" action="">
        <label for="email">Adresse e-mail:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <input type="submit" name="resetpwd" value="Envoyer">
    </form>
    <p>Vous mémoire vous reviens ? <a href="Login.php">Connectez-vous</a></p>
</body>
</html>
