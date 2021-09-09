<?php
    session_start();
    include("database/bdd.php");
    
    $idsession = $_SESSION['id'];
    
        //  Récupération des informations de l'utilisateur
      $req = $bdd->prepare('SELECT id, username, password, rep_question FROM account WHERE id = :id');
      $req->execute(array(
          'id' => $idsession));
      $resultat = $req->fetch();
      
      /* MODIFICATION USERNAME */

      if (isset($_POST['modifier_user']))
         {//Définition des variables
            $password = htmlspecialchars(trim($_POST['password']));
            $username = htmlspecialchars(trim($_POST['username']));
            $nvusername = htmlspecialchars(trim($_POST['nvusername']));
           
            // Comparaison du mdp et reponse envoyés via le formulaire avec la base
            $isPasswordCorrect = password_verify($password, $resultat['password']);
            
            if ($username == $resultat['username'])
               {//si correct on vérifie que le nouveau pseudo n'existe pas
                  
                  $requsername = $bdd->prepare("SELECT * FROM account WHERE username=?");
                  $requsername->execute(array($nvusername));
                  $usernameexist = $requsername->rowCount();
                  
                  if ($usernameexist == 0)
                     {//si correct on vérifie la longueur du pseudo

                        $usernamelength = strlen($nvusername);

                        if($usernamelength <= 50)
                           {//si inférieur à 50 caractères, on vérifie le mdp
                              
                              if ($isPasswordCorrect)
                                 {//si correct on hache le mdp et on met à jour
                                    $pass_hache = password_hash($nvpass, PASSWORD_DEFAULT);

                                    $req = $bdd->prepare('UPDATE account SET username = :nvuser WHERE id = :id');
                                    $req->execute(array(
                                    'nvuser' => $nvusername,
                                    'id' => $resultat['id']
                                    ));
                                    header('Location: profil.php?info=valide'); //affiche un message de réussite
                                 } 
                              else 
                                 {//si mdp non identique, affiche une erreur
                                    header('Location: profil.php?info=erreur1');
                                 }
                           }
                        else 
                           {//si username trop long  
                              header('Location: profil.php?info=erreur');
                           }
                     }
                  else 
                     {//si username déjà existant, affiche une erreur
                        header('Location: profil.php?info=erreur3');
                     }         
               }
            else
               {//si username non identique, affiche une erreur
                  header('Location: profil.php?info=erreur1');
               }
         }

         /* FIN MODIFICATION USERNAME */

         /* MODIFICATION MOT DE PASSE */

      if (isset($_POST['modifier_mdp']))
         {//Définition des variables
            $password = htmlspecialchars(trim($_POST['password']));
            $reponse = htmlspecialchars(trim($_POST['rep_question']));
            $nvpass = htmlspecialchars(trim($_POST['nvpassword']));
            
            // Comparaison du mdp et reponse envoyés via le formulaire avec la base
            $isRepCorrect = password_verify($reponse, $resultat['rep_question']);
            $isPasswordCorrect = password_verify($password, $resultat['password']);
            
            if ($isRepCorrect)
            {//si correct on vérifie le mdp
            
               if ($isPasswordCorrect)
               {//si correct on hache le mdp et on met à jour
                  $pass_hache = password_hash($nvpass, PASSWORD_DEFAULT);

                  $req = $bdd->prepare('UPDATE account SET password = :nvpass WHERE id = :id');
                  $req->execute(array(
                  'nvpass' => $pass_hache,
                  'id' => $resultat['id']
                  ));
                  header('Location: profil.php?info=valide'); //affiche un message de réussite
               } 
               else 
               {//si mdp non identique, affiche une erreur
                  header('Location: profil.php?info=erreur2');
               }          
            }
            else
            {//si reponse non identique, affiche une erreur
               header('Location: profil.php?info=erreur2');
            }
         }
?>