<!DOCTYPE html>
<html>
<head>
    <title>Page de réinitialisation</title>
</head>
<body>
    <h3>Changer le mot de passe  :</h3>
    <form method="POST" action="">
        <label for="password">Ancien mot de passe :</label>
        <input type="password" id="old-password" name="old-password" required>
        <br>
        <label for="password">Nouveau mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="confirm-password">Confirmer le nouveau mot de passe :</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
        <br>
        <input type="submit" name="reset-password" value="Confirmer">
    </form>
    <p>Attention ! Votre mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre, un caractère spécial et faire au moins 12 caractères.</p>
    <form method="POST" action="">
        <label for="password">Confirmer le changement de mot de passe avec votre code de confirmation:</label>
        <br>
        <input type="password" id="opt" name="otp">
        <br>
        <input type="submit" name="confirm-otp" value="Confirmer">
    </form>
    <br>
    <a href="/Login/index.php/account">Retour</a>
    <br>
    <br>
</body>
</html>
