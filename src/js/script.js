document.querySelector('form').addEventListener('submit', function (event) {
    event.preventDefault(); // Empêche le rechargement de la page après la soumission du formulaire
    var passwordInput = document.getElementById('password');
    var password = passwordInput.value;
    var texte = document.getElementById('output');

    if (!verifPasswordStrength(password)) {
        texte.innerHTML = 'Qualité du mot de passe : Trop faible';
        return;
    }
    texte.innerHTML = 'Qualité du mot de passe : Convenable';
    sha512(password)
        .then(function (result) {
            document.getElementById('hashed-password').value = result;
        })
        .catch(function (error) {
            console.error(error);
        });
});



function sha512(str) {
    var encoder = new TextEncoder();
    var data = encoder.encode(str);

    return window.crypto.subtle.digest('SHA-512', data).then(function (hash) {
        var hashArray = Array.from(new Uint8Array(hash));
        var hashedString = hashArray
            .map(function (byte) {
                return byte.toString(16).padStart(2, '0');
            })
            .join('');
        return hashedString;
    });
}


function verifPasswordStrength(password) {
    if (password.length < 12) {
        return false;
    }
    if (!/[a-z]/.test(password)) {
        return false;
    }
    if (!/[A-Z]/.test(password)) {
        return false;
    }
    if (!/[0-9]/.test(password)) {
        return false;
    }
    if (!/\W+/.test(password)) {
        return false;
    }
    return true;
}