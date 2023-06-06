<?php

// Inclusion des fichiers nécessaires
require_once '../src/controllers/UserController.php';
require_once '../src/controllers/SecurityController.php';
require_once '../src/controllers/PasswordController.php';
require_once '../src/controllers/AccountController.php';
require_once '../src/controllers/EmailController.php';
require_once '../src/controllers/TwoFactorController.php';
require_once '../src/controllers/LoginAttemptsController.php';
require_once '../src/models/Database.php';

// Activation de certaines mesures de sécurité
session_start();
ini_set('display_errors', 0);

// Création de l'instance de connexion à la base de données
$db = new Database();

// Création des instances des contrôleurs
$userController = new UserController();
$securityController = new SecurityController();
$passwordController = new PasswordController();
$accountController = new AccountController();
$emailController = new EmailController();
$twoFactorController = new TwoFactorController();
$loginAttemptsController = new LoginAttemptsController();

// Récupération de l'action depuis l'URL en utilisant la méthode POST pour plus de sécurité
$action = isset($_POST['action']) ? $_POST['action'] : '';

// Routage des différentes actions
switch ($action) {
  case 'register':
    $userController->register();
    break;
  case 'login':
    $userController->login();
    break;
  case 'logout':
    $userController->logout();
    break;
  case 'change':
    $userController->change();
    break;
  case 'confirm':
    $userController->confirm();
    break;
  case 'delete':
    $userController->delete();
    break;
  case 'enable-2fa':
    $twoFactorController->enableTwoFactor();
    break;
  case 'disable-2fa':
    $twoFactorController->disableTwoFactor();
    break;
  // Autres actions spécifiques à votre application...
  default:
    // Action par défaut, page d'accueil ou gestion des erreurs
    echo 'Page not found';
    break;
}
