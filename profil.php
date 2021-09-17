<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Extranet GBAF</title>
    <link href="public/css/style.css" rel="stylesheet" />
    </head>
    
    <body>
        <?php session_start();
        include("include/entete.php");?>
        
        <?php 
            if(isset($_SESSION['id']))
                { 
                    $idsession = $_SESSION['id'];?>
                    <main>
                        <a href="index.php" class="retour">Retour à l'index</a>
                        <h1>Paramètres du compte</h1>
                        <?php
                            include("database/bdd.php");
                            $req = $bdd->prepare('SELECT id, nom, prenom, username, question FROM account WHERE id = :id');
                            $req->execute(array(
                                'id' => $idsession));
                            $req_account = $req->fetch();
                        
                            $req->closeCursor();
                            
                            $req = $bdd->prepare('SELECT id, question FROM question WHERE id = :id');
                            $req->execute(array(
                                'id' => $req_account['question']));
                            $req_question = $req->fetch();
                        
                            $req->closeCursor();

                            
                            if(isset($_GET['info'])) //Recherche de message de validation ou d'erreur à afficher avant les formulaires
                                { switch ($_GET['info'])
                                    {
                                        case "valide":
                                            echo '<div class="succes">Modification.s effectuée.s !</div>';
                                        break;
                                        
                                        case "erreur":
                                            echo '<div class="erreur">Mauvais.e password ou réponse !</div>';
                                        break;

                                        case "erreur3":
                                            echo '<div class="erreur">Mauvais password !</div>';
                                        break;

                                        case "erreur7":
                                            echo '<div class="erreur">Tous les champs doivent être remplis !</div>';
                                        break;
                                    }
                                }
                        ?>                   
                        <section class="contenant_connexion">
                            <h2>Modifier ses informations personnelles</h2>
                            <form action="backend/modification.php" method="post" class="formulaire">
                                <div class="inline_npu">
                                    <p>
                                        <label>Nom</label> <input type="text" name="nom" value="<?php echo ($req_account['nom']); ?>" class="input_perso" />
                                    </p>
                                    <p>
                                        <label>Prénom</label> <input type="text" name="prenom" value="<?php echo ($req_account['prenom']); ?>" class="input_perso" />
                                    </p>
                                    <p>
                                    <label>UserName</label> <input type="text" name="username" value="<?php echo ($req_account['username']); ?>" class="input_perso" />
                                    </p>
                                </div>    
                                <?php 
                                    if(isset($_GET['info'])) //recherche d'erreur de saisie des info personnelles
                                        { switch ($_GET['info'])
                                            {
                                                case "erreur1":
                                                    echo '<div class="erreur">UserName dejà utilisé !</div>';
                                                break;
                                                    
                                                case "erreur2":
                                                    echo '<div class="erreur">UserName trop long ! (Max 50 caractères)</div>';
                                                break;

                                                case "erreur4":
                                                    echo '<div class="erreur">Prénom trop long ! (Max 50 caractères)</div>';
                                                break;
                                                
                                                case "erreur5":
                                                    echo '<div class="erreur">Nom trop long ! (Max 50 caractères)</div>';
                                                break;

                                                case "erreur6":
                                                    echo '<div class="erreur">Présence de caractères spéciaux et/ou chiffre dans Nom et/ou Prénom </div>';
                                                break;
                        
                                            } 
                                        }
                                ?>
                                <p>
                                    <label>Password</label> <input type="password" name="password" class="input_perso" />                    
                                </p>
                                <p>
                                    <input type="submit" name="modifier_user" value="Modifier" />
                                </p>
                            </form>
                        </section>

                        <section class="contenant_connexion">
                            <h2>Changer de Password</h2>
                            <form action="backend/modification.php" method="post" class="formulaire">
                                <p>
                                    <label><?php echo $req_question['question']; ?></label> <input type="text" name="rep_question" class="input_perso" />
                                </p>
                                <p>
                                    <label>Password actuel</label> <input type="password" name="password" class="input_perso" />
                                </p>
                                <p>
                                    <label>Nouveau Password</label> <input type="password" name="nvpassword" class="input_perso" />                    
                                </p>
                                <p>
                                    <input type="submit" name="modifier_mdp" value="Modifier" />
                                </p>
                            </form>
                        </section>
                        <a href="index.php" class="retour">Retour à l'index</a>
                    </main>
                <?php 
                } 
            else 
                {
                    header('Location: ../index.php');
                }?>
                
    <?php include("include/footer.php"); ?>
    </body>
</html>

