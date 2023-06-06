<?php

// Inclure les fichiers des contrôleurs
// require_once 'controllers/AccountController.php';
require_once './src/controllers/AuthController.php';
// require_once 'controllers/EmailController.php';
// require_once 'controllers/PasswordController.php';

// use Login\Controllers\AccountController;
use Login\Controllers\AuthController;
// use Login\Controllers\EmailController;
// use Login\Controllers\PasswordController;
// use Login\Lib\DataBase\DatabaseConnection;


// Instancier les contrôleurs
// $accountController = new AccountController();
$authController = new AuthController();
// $emailController = new EmailController();
// $passwordController = new PasswordController();


// Obtenir le chemin demandé dans l'URL
$path = $_SERVER['REQUEST_URI'];

// Aiguiller les requêtes en fonction du chemin
switch ($path) {
    // Routes pour le contrôleur AccountController
    case '/account':
        $accountController->index();
        break;
    case '/account/change-password':
        $accountController->changePassword();
        break;

    // Routes pour le contrôleur AuthController
    case '/login':
        $authController->login();
        break;
    case '/register':
        $authController->register();
        break;

    // Routes pour le contrôleur EmailController
    case '/confirm-email':
        $emailController->confirmEmail();
        break;

    // Routes pour le contrôleur PasswordController
    case '/reset-password':
        $passwordController->resetPassword();
        break;

    // Autres routes...

    default:
        // Gérer les routes non définies
        break;
}
?>
