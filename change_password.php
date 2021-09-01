<?php
    session_start();
    include("database/bdd.php");
    
    $idsession = $_SESSION['id']
    $password = htmlspecialchars(trim($_POST['password']));
    
        //  Récupération de l'utilisateur et de son pass haché
      $req = $bdd->prepare('SELECT id, password FROM account WHERE id = :id');
      $req->execute(array(
          'id' => $idsession));
      $resultat = $req->fetch();
      
      // Comparaison du pass envoyé via le formulaire avec la base
      $isPasswordCorrect = password_verify($password, $resultat['password']);
      
      if ($isPasswordCorrect)
      {//si correct on vérifie réponse à la question
         if ()
         {//si correct on hache le mdp et on met à jour
            $pass_hache = password_hash($password, PASSWORD_DEFAULT);
            
            $req = $bdd->prepare('UPDATE account SET password = :nvpass WHERE id = :id');
            $req->execute(array(
            'nvpass' => $pass_hache,
            'id' => $resultat['id']
            ));
         } 
         else {
            header('Location: profil.php?info=erreur');
         }          
      }
      else{
        header('Location: profil.php?info=erreur');
        }

?>