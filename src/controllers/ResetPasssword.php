 <?php
     namespace Login\Controllers;

     require_once('../src/lib/database.php');
 
     use Login\Lib\DataBase\DatabaseConnection;
 
     class ResetPassword
     {
         public function resetPassword(): void
         {
             $database = new DatabaseConnection();
             $database = $database->getConnection();
     
             $email = $_POST['email'];

             // on vérifie que l'adresse email existe dans la base de données
             $query = $database->prepare("SELECT email FROM user WHERE email = :email");
             $query->bindParam(':email', $email);
             $query->execute();
             
             // si l'adresse email n'existe pas, on redirige vers la page de connexion
             if ($query == false) {
                echo 'Cette adresse email n\'existe pas';
                } else {
                echo 'Un email vous a été envoyé';
             }

         }

        }
 ?>