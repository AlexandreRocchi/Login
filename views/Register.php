<!DOCTYPE html>
<html>
<head>
    <title>Page d'inscription</title>
    <script src="/Login/src/js/script.js" defer></script>
</head>
<body>
    <h1>Inscription</h1>
    <form id="form" method="POST" action="/Login/index.php/register">
        <label for="email">Adresse e-mail:</label>
        <input type="email" id="email" name="email">
        <br>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password">
        <br>
        <input type="submit" name="register" value="S'inscrire">
    </form>
    <p>Déjà inscrit ? <a href="/Login/index.php/login">Connectez-vous</a></p>
    <p>Attention ! Votre mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre, un caractère spécial et faire au moins 12 caractères.</p>
    <p id="output"></p>
    <?php if (isset($error)) { ?>
        <p><?= $error ?></p>
    <?php } ?>
</body>
</html>
