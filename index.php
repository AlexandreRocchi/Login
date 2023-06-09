<?php

require_once './src/controllers/RegisterController.php';
require_once './src/controllers/LoginController.php';
require_once './src/controllers/AccountController.php';
require_once './src/controllers/ResetPasswordController.php';

use Login\Controllers\RegisterController;
use Login\Controllers\LoginController;
use Login\Controllers\AccountController;
use Login\Controllers\ResetPasswordController;

// On instancie les contrôleurs
$registerController = new RegisterController();
$loginController = new LoginController();
$accountController = new AccountController();
$passwordController = new ResetPasswordController();

// On récupère le chemin de la requête
$path = $_SERVER['REQUEST_URI'];

// On redirige vers les routes correspondantes
switch ($path) {

    // Route pour le contrôleur AccountController
    case '/Login/index.php/account':
        $accountController->session();
        break;

    // Route pour le contrôleur LoginController
    case '/Login/index.php/login':
        $loginController->login();
        break;
    // Route pour le contrôleur RegisterController
    case '/Login/index.php/register':
        $registerController->register();
        break;

    // Route pour le contrôleur PasswordController
    case '/Login/index.php/reset-password':
        $passwordController->resetPassword();
        break;

    // Chemin pour les routes non définies
    default:
        echo 'Erreur 404';
        break;
}
?>
