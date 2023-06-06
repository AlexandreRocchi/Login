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
