<?php

// Inclure les fichiers des contrôleurs
require_once './src/controllers/RegisterController.php';
require_once './src/controllers/LoginController.php';
require_once './src/controllers/AccountController.php';

use Login\Controllers\RegisterController;
use Login\Controllers\LoginController;
use Login\Controllers\AccountController;


// Instancier les contrôleurs
$registerController = new RegisterController();
$loginController = new LoginController();
$accountController = new AccountController();




// Obtenir le chemin demandé dans l'URL
$path = $_SERVER['REQUEST_URI'];

// Aiguiller les requêtes en fonction du chemin
switch ($path) {

    // Routes pour le contrôleur AccountController
    case '/Login/index.php/account':
        $accountController->session();
        break;
    case '/Login/index.php/account/change-password':
        $accountController->changePassword();
        break;

    // Routes pour le contrôleur LoginController
    case '/Login/index.php/login':
        $loginController->login();
        break;

    case '/Login/index.php/register':
        $registerController->register();
        break;

    // Routes pour le contrôleur EmailController
    case '/Login/index.php/confirm-email':
        $emailController->confirmEmail();
        break;

    // Routes pour le contrôleur PasswordController
    case '/Login/index.php/reset-password':
        $passwordController->resetPassword();
        break;


    default:
        echo 'Erreur 404';
        // Gérer les routes non définies
        break;
}
?>
