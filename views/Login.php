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
