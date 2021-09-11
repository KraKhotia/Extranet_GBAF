<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Extranet GBAF</title>
    <link href="public/css/style.css" rel="stylesheet" />
    </head>
    
    <body>
        <?php session_start();
        include("include/entete.php"); 
        $idsession = $_SESSION['id']; 
        ?>
        <main>   
            <a href="index.php" class="retour">Retour à l'index</a>
            <?php
                include("database/bdd.php");
                $req = $bdd->prepare('SELECT id, username, question FROM account WHERE id = :id');
                $req->execute(array(
                    'id' => $idsession));
                $req_account = $req->fetch();
            
                $req->closeCursor();
                
                $req = $bdd->prepare('SELECT id, question FROM question WHERE id = :id');
                $req->execute(array(
                    'id' => $req_account['question']));
                $req_question = $req->fetch();
            
                $req->closeCursor();

                
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
                ?>
                <h1>Paramètres du compte</h1>   
                <div class="contenant_connexion">
                <h2>Changer de UserName</h2>
                <form action="backend/modification.php" method="post" class="formulaire">
                    <p>
                        <strong>UserName actuel</strong><br /><br /> <?php echo $req_account['username']; ?>
                    </p>
                    <p>
                        <label>Nouveau UserName</label> <input type="text" name="nvusername" class="input_perso" />
                    </p>
                    <?php 
                        if(isset($_GET['info']) && $_GET['info'] == "erreur") { echo '<div class="erreur">UserName trop long ! (Max 50 caractères)</div>';} 
                        elseif(isset($_GET['info']) && $_GET['info'] == "erreur3") { echo '<div class="erreur">UserName dejà utilisé !</div>';}
                    ?>
                    <p>
                        <label>Password</label> <input type="password" name="password" class="input_perso" />                    
                    </p>
                    <p>
                        <input type="submit" name="modifier_user" value="Modifier" />
                    </p>
                </form>
            </div>
                <div class="contenant_connexion">
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
            </div>
            <a href="index.php" class="retour">Retour à l'index</a>
        </main>
        <?php include("include/footer.php"); ?>
    </body>
</html>

