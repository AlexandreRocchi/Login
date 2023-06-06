<?php

session_start();

require_once('../src/models/Database.php');
require_once('../src/controllers/ConfirmEmail.php');

use Login\Controllers\ConfirmEmail;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'action est une confirmation de l'adresse e-mail
    if (isset($_POST['confirm'])) {
        $confirmEmail = new ConfirmEmail();
        $confirmEmail->confirmEmail();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page de confirmation</title>
</head>
<body>

    <h3>Confirmation de l'adresse e-mail</h3>
    <form method="POST" action="">
        <label for="otp">Code de confirmation:</label>
        <input type="text" id="otp" name="otp" required>
        <br>    
        <input type="submit" name="confirm" value="Confirmer">
    </form>
</body>
</html>
