function prepareForm(event) {
    console.log('prepareForm');
    event.preventDefault();
    const form = event.target;
    const password = form.password.value;
    if (verifPasswordStrength(password) == false) {
        document.getElementById('output').innerHTML = "Qualité du mot de passe : trop faible";
        return;
    } else {
        sha512(password).then(hash => {
            form.password.value = hash;
            form.submit();
        })
            .catch(error => {
                console.log(error);
            });
    }
}

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

const form = document.getElementById('form');
form.addEventListener('submit', prepareForm);