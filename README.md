# Login sécurisé
lien github : `https://github.com/AlexandreRocchi/Login`
Ce projet est un système de login sécurisé réalisé par moi-même. Il comprend toutes les fonctionnalités demandées, à l'exception de la gestion des tokens, qui a été remplacée par l'utilisation de sessions PHP ainsi que la gestions des autorisations.

## Installation

1. Assurez-vous d'avoir installé WampServer et MySQL sur votre machine.
2. Clonez ce projet dans le répertoire www de votre serveur Wamp.
3. Importez le fichier de base de données fourni dans votre gestionnaire de base de données (par exemple, PhpMyAdmin).

## La base de donnée

Vous trouverez dans le fichier SQL deux fichiers :
1. le fichier db.sql qui permet de créer la base de donnée.
2. le fichier user.sql qui permet de créer un utilisateur pour la base de donnée.
3. changer username et password dans Database.php afin de se connecter à la BDD

! Attention ! Il faut d'abord générer le script de db.sql puis celui de user.sql .


## Utilisation

1. Accédez au projet en utilisant l'URL de base suivante : `http://localhost/Login/index.php/register`.
2. Vous serez redirigé vers la page d'inscription où vous pouvez créer un compte en fournissant les informations requises. Une confirmation OTP sera simulée par une alerte JavaScript.
3. Une fois l'OTP confirmé, vous serez redirigé vers la page de connexion.
4. Sur la page de connexion, vous pouvez vous connecter à votre session en fournissant vos identifiants.
5. Une fois connecté, vous aurez accès à votre session, où vous pourrez choisir parmi les options suivantes :
   - Supprimer votre compte.
   - Vous déconnecter.
   - Changer votre mot de passe.
6. L'option de déconnexion vous ramènera à la page de connexion.
7. L'option de suppression supprimera définitivement votre compte.
8. L'option de changement de mot de passe vous dirigera vers une page dédiée où vous pourrez effectuer le changement. Vous devrez fournir votre ancien mot de passe ainsi qu'une confirmation OTP similaire à celle utilisée lors de l'inscription.

## Structure du code

Le code est organisé selon l'architecture MVC (Modèle-Vue-Contrôleur) afin de garantir une meilleure sécurité et une séparation claire des rôles des fichier PHP.

## Normes

Les normes utilisées pour certaines options ont été récupérées sur le site de la CNIL.
