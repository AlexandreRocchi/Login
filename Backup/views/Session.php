<?php

session_start();

require_once('../src/models/Database.php');
require_once('../src/controllers/DeleteAccount.php');


use Login\Controllers\ResetPassword;
use Login\Controllers\DeleteAccount;

$name = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'action est une demande de réinitialisation de mot de passe
    if (isset($_POST['delete'])) {
        $resetPassword = new DeleteAccount();
        $resetPassword->deleteAccount();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page de session</title>
</head>
<body>
    <h1>Bienvenue <?php echo $name?></h1>
    <form method="POST" action="">
        <p>Voulez vous supprimer ce compte ?</p>
        <input type="submit" name="delete" value="Confirmer">
    </form>
    <p>Vous souhaitez vous déconnecter ? <a href="Login.php">Cliquez ici</a></p>
</body>
</html>
