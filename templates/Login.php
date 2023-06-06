<?php
// si une session est déjà ouverte, la fermer

if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
} else {
    session_start();
} 

require_once('../src/models/Database.php');
require_once('../src/controllers/IsUser.php');


use Login\Controllers\IsUser;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'action est une tentative de connexion
    if (isset($_POST['login'])) {
        $isUser = new IsUser();
        $isUser->isUser();
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
    <p>Pas encore inscrit ? <a href="Register.php">Inscrivez-vous</a></p>
    <p>Mot de passe oublié ? <a href="Reset.php">Réinitialisez-le</a></p>
</body>
</html>
