<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mot de passe oublié</title>
        <link href="public/css/style.css" rel="stylesheet" />
    </head>
    <body>        
        <?php 
            session_start();
            include("include/entete.php");
            if (!isset($_SESSION['id']))
                {?>
                    <main>
                        <h1>Mot de passe oublié</h1>
                        <section class="contenant_connexion">
                            <h2>Changer de Password</h2>
                                <?php
                                    include("database/bdd.php");
                                                            
                                    if(isset($_GET['info'])) 
                                        { switch ($_GET['info'])
                                            {
                                                case "valide":
                                                    echo '<div class="succes">Modification effectuée !</div>';
                                                break;
                                                                            
                                                case "erreur1":
                                                    echo '<div class="erreur">Mauvais.e UserName ou password !</div>';
                                                break;

                                                case "erreur2":
                                                    echo '<div class="erreur">Mauvais.e password ou réponse !</div>';
                                                break;
                                            }
                                        }

                                    if(isset($_POST['identifier']) AND !empty($username)) //Si formulaire d'identification rempli on affiche la question correspondant au
                                        {
                                            $username = htmlspecialchars(trim($_POST['username']));
                                            $req = $bdd->prepare('SELECT id, username, question FROM account WHERE username = ?');
                                            $req->execute(array($username));
                                            $req_account = $req->fetch();
                                            $usernameexist = $req->rowCount();
                                            $req->closeCursor();

                                            //on vérifie si le pseudo existe déjà ou non
                                            if($usernameexist == 1)
                                                {
                                                    $req = $bdd->prepare('SELECT id, question FROM question WHERE id = :id');
                                                    $req->execute(array(
                                                            'id' => $req_account['question']));
                                                    $req_question = $req->fetch();
                                            
                                                    $req->closeCursor();
                        
                                                    ?>

                                                    <form action="../mot_de_passe_oublie.php?action=<?php echo $username; ?>" method="post" class="formulaire">
                                                            <p>
                                                                <strong>UserName</strong><br /><br /> <?php echo $username; ?>
                                                            </p>
                                                            <p>
                                                                <label><?php echo $req_question['question']; ?></label> <input type="text" name="rep_question" class="input_perso" />
                                                            </p>
                                                            <p>
                                                                <label>Nouveau Password</label> <input type="password" name="password" class="input_perso" />
                                                            </p>
                                                            <p>
                                                                <label>Confirmation Password</label> <input type="password" name="nvpassword" class="input_perso" />                    
                                                            </p>
                                                            <p>
                                                                <input type="submit" name="modif_mdp_oublie" value="Modifier" />
                                                            </p>
                                                    </form> 
                                            <?php
                                                }
                                            else
                                                {//si username non existant, affiche une erreur
                                                    header('Location: ../mot_de_passe_oublie.php?info=erreur1');
                                                }
                                        }
                                    else
                                        {?>
                                            <form action="../mot_de_passe_oublie.php" method="post" class="formulaire">
                                                <p>
                                                    <label>UserName</label> <input type="text" name="username" class="input_perso" />
                                                </p>
                                                    <input type="submit" name="identifier" value="S'identifier" />
                                                </p>
                                            </form>
                                        <?php    
                                        }

                                        if(isset($_POST['modif_mdp_oublie']))
                                            {
                                                //Définition des variables
                                                $username = htmlspecialchars(trim($_GET['action']));
                                                $password = htmlspecialchars(trim($_POST['password']));
                                                $reponse = htmlspecialchars(trim($_POST['rep_question']));
                                                $nvpass = htmlspecialchars(trim($_POST['nvpassword']));
                                                
                                                $req = $bdd->prepare('SELECT id, username, password, question, rep_question FROM account WHERE username = ?');
                                                $req->execute(array($username));
                                                $req_account = $req->fetch();
                                            
                                                $req->closeCursor();
                                                // Comparaison de la reponse envoyée via le formulaire avec la base de données
                                                $isRepCorrect = password_verify($reponse, $req_account['rep_question']);
                                            
                                                if ($isRepCorrect)
                                                    {//si correct on vérifie le password
                                                    
                                                        if ($password == $nvpass)
                                                            {//si correct on hache le password et on met à jour
                                                                $pass_hache = password_hash($nvpass, PASSWORD_DEFAULT);
                                        
                                                                $req = $bdd->prepare('UPDATE account SET password = :nvpass WHERE id = :id');
                                                                $req->execute(array(
                                                                'nvpass' => $pass_hache,
                                                                'id' => $req_account['id']
                                                                ));

                                                                header('Location: ../mot_de_passe_oublie.php?info=valide'); //affiche un message de réussite
                                                            } 
                                                        else 
                                                            {//si password non identiques, affiche une erreur
                                                                header('Location: ../mot_de_passe_oublie.php?info=erreur2');
                                                            }          
                                                    }
                                                else
                                                    {//si reponse non identique, affiche une erreur
                                                        header('Location: ../mot_de_passe_oublie.php?info=erreur2');
                                                    }
                                            }?>
                        </section>
                        <a href="../index.php" class="retour">Retour à l'index</a>
                    </main>
            <?php
                }
            else 
                {//si session ouverte
                   header('Location: profil.php');
                }?>
    </body>
</html>
        