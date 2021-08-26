<?php
    include("entete.php");
    include("bdd.php");
    
    $username = htmlspecialchars(trim($_POST['username']));
    
        //  Récupération de l'utilisateur et de son pass hashé
      $req = $bdd->prepare('SELECT id, nom, prenom, password FROM account WHERE username = :username');
      $req->execute(array(
          'username' => $username));
      $resultat = $req->fetch();
      
      // Comparaison du pass envoyé via le formulaire avec la base
      $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);
      
      if (!$resultat)
      {
          echo '<div class="erreur">Mauvais identifiant ou mot de passe !</div>';
          include("login.php");
          
      }
      else
      {
          if ($isPasswordCorrect) {
              session_start();
              $_SESSION['id'] = $resultat['id'];
              $_SESSION['username'] = $username;
              $_SESSION['nom'] = $resultat['nom'];
              $_SESSION['prenom'] = $resultat['prenom'];
              echo 'Vous êtes connecté !';
              header('Location: index.php');
          }
          else {
              echo '<div class="erreur">Mauvais identifiant ou mot de passe !</div>';
              include("login.php");
          }
      }  
?>