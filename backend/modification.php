<?php
   session_start();
   include('../database/bdd.php');
    
   if($_SERVER['REQUEST_METHOD'] != 'POST') 
      {
         header('Location: ../profil.php');
      }

   $idsession = $_SESSION['id'];
    
   //  Récupération des informations de l'utilisateur
   $req = $bdd->prepare('SELECT id, nom, prenom, username, password, rep_question FROM account WHERE id = :id');
   $req->execute(array(
      'id' => $idsession));
   $result = $req->fetch();
      
   /* MODIFICATION INFO PERSONNELLES */

      if (isset($_POST['modifier_user']))
         {//Définition des variables
            $password = htmlspecialchars(trim($_POST['password']));
            $nom = htmlspecialchars(trim($_POST['nom']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $username = htmlspecialchars(trim($_POST['username']));
            
            // Comparaison du mdp et reponse envoyés via le formulaire avec la base
            $isPasswordCorrect = password_verify($password, $result['password']);
            
            if (!empty($nom) AND !empty($prenom) AND !empty($username) AND !empty($password))
               {//On vérifie que les nom et prénom ne comporte pas de chiffres et caractères spéciaux inappropriés
                  $regex = "/^[A-Z][a-zA-Z'àáâäãåąčćęèéêěëįìíîïłńòóôöõőùúûüųūűÿýżźñçčšžÀÂÉÈËÓÔŐÙÛÜŰÇČß\s-]{2,}$/";
                  
                  if (preg_match($regex, $nom))
                     {
                        if (preg_match($regex, $prenom))
                           {//On vérifie que le nom, prenom font moins de 50 caractères
                              $nomlength = strlen($nom);
                              
                              if($nomlength <= 50)
                                 {
                                    $prenomlength = strlen($prenom);
                                    if($prenomlength <= 50)
                                       {
                                          if ($isPasswordCorrect)
                                             {//On vérifie que le username fait moins de 50 caractères
                                                $usernamelength = strlen($username);

                                                if($usernamelength <= 50)
                                                   {//On vérifie si le username est identique 
                                                      if ($username == $_SESSION['username'])
                                                         {//si username est identique à celui de la session, on mets à jour dans la base de données
                                                            $req = $bdd->prepare('UPDATE account SET nom = :nom, prenom = :prenom, username = :username WHERE id = :id');
                                                            $req->execute(array(
                                                               'nom' => $nom,
                                                               'prenom' => $prenom,
                                                               'username' => $username,
                                                               'id' => $result['id']));

                                                            //On redéfinit les données de la session
                                                            $_SESSION['username'] = $username;
                                                            $_SESSION['nom'] = $nom;
                                                            $_SESSION['prenom'] = $prenom;

                                                            header('Location: /profil.php?info=valide'); //affiche un message de réussite
                                                         }
                                                      else 
                                                         {//autrement on vérifie s'il existe déjà dans la base de données           
                                                            $requsername = $bdd->prepare("SELECT * FROM account WHERE username=?");
                                                            $requsername->execute(array($username));
                                                            $usernameexist = $requsername->rowCount();

                                                            if ($usernameexist == 0)
                                                               {//s'il n'existe pas, on met à jour les données
                                                                  $req = $bdd->prepare('UPDATE account SET nom = :nom, prenom = :prenom, username = :username WHERE id = :id');
                                                                  $req->execute(array(
                                                                     'nom' => $nom,
                                                                     'prenom' => $prenom,
                                                                     'username' => $username,
                                                                     'id' => $result['id']));

                                                                  //On redéfinit les données de la session
                                                                  $_SESSION['username'] = $username;
                                                                  $_SESSION['nom'] = $nom;
                                                                  $_SESSION['prenom'] = $prenom;

                                                                  header('Location: /profil.php?info=valide');
                                                               }
                                                            else 
                                                               {//si username déjà existant, affiche une erreur
                                                                  header('Location: /profil.php?info=erreur1');
                                                               }                                                            
                                                         }
                                                   }                                                
                                                else 
                                                   {//si username trop long, affiche une erreur  
                                                      header('Location: /profil.php?info=erreur2');
                                                   } 
                                             }
                                          else 
                                             {//si mdp non identique, affiche une erreur
                                                header('Location: /profil.php?info=erreur3');
                                             }
                                       }                                                
                                    else 
                                       {//si prénom trop long, affiche une erreur  
                                          header('Location: /profil.php?info=erreur4');
                                       }
                                 }
                              else
                                 {//si nom trop long, affiche une erreur
                                    header('Location: /profil.php?info=erreur5');
                                 }
                           }
                        else
                           {//si chiffre ou caractères spéciaux dans le prenom, affiche une erreur
                              header('Location: /profil.php?info=erreur6');
                           }
                     }
                  else
                     {//si chiffre ou caractères spéciaux dans le nom, affiche une erreur
                        header('Location: /profil.php?info=erreur6');
                     }
               }
            else 
               {//si un champ est vide, affiche une erreur
                  header('Location: /profil.php?info=erreur7');
               }
         }

         /* FIN MODIFICATION INFO PERSONNELLES */

         /* MODIFICATION MOT DE PASSE */

      if (isset($_POST['modifier_mdp']))
         {//Définition des variables
            $password = htmlspecialchars(trim($_POST['password']));
            $reponse = htmlspecialchars(trim($_POST['rep_question']));
            $nvpass = htmlspecialchars(trim($_POST['nvpassword']));
            
            // Comparaison du mdp et reponse envoyés via le formulaire avec la base
            $isRepCorrect = password_verify($reponse, $result['rep_question']);
            $isPasswordCorrect = password_verify($password, $result['password']);
            
            if ($isRepCorrect)
            {//si correct on vérifie le mdp
            
               if ($isPasswordCorrect)
               {//si correct on hache le mdp et on met à jour
                  $pass_hache = password_hash($nvpass, PASSWORD_DEFAULT);

                  $req = $bdd->prepare('UPDATE account SET password = :nvpass WHERE id = :id');
                  $req->execute(array(
                  'nvpass' => $pass_hache,
                  'id' => $result['id']
                  ));
                  header('Location: /profil.php?info=valide'); //affiche un message de réussite
               } 
               else 
               {//si mdp non identique, affiche une erreur
                  header('Location: /profil.php?info=erreur');
               }          
            }
            else
            {//si reponse non identique, affiche une erreur
               header('Location: /profil.php?info=erreur');
            }
         }
?>