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
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" name="login" value="Se connecter">
    </form>
    <p>Pas encore inscrit ? <a href="/Login/index.php/register">Inscrivez-vous</a></p>
    <p>Mot de passe oublié ? <a href="/Login/index.php/reset-password">Réinitialisez-le</a></p>
</body>
</html>
