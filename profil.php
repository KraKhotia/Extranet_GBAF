<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Extranet GBAF</title>
    <link href="public/css/style.css" rel="stylesheet" />
    </head>
    
    <body>
        <?php session_start();
        include("include/entete.php"); 
        $idsession = $_SESSION['id']; 
        ?>
        <main>   
        <p><a href="index.php">Retour à l'index</a></p>
        <?php
            include("database/bdd.php");
            $req = $bdd->prepare('SELECT ID, username, password, question, rep_question FROM account WHERE ID = :ID');
            $req->execute(array(
                'ID' => $idsession));
            $res_account = $req->fetch();
        
            $req->closeCursor();
            
            $req = $bdd->prepare('SELECT ID, question FROM question WHERE ID = :ID');
            $req->execute(array(
                'ID' => $res_account['question']));
            $res_question = $req->fetch();
        
            $req->closeCursor();

            
            if(isset($_GET['info']) && $_GET['info'] == "valide") { echo '<div class="succes">Modification effectuée !</div>';} 
            elseif(isset($_GET['info']) && $_GET['info'] == "erreur1") { echo '<div class="erreur">Mauvais.e UserName ou password !</div>';}
            elseif(isset($_GET['info']) && $_GET['info'] == "erreur2") { echo '<div class="erreur">Mauvais.e password ou réponse !</div>';}

            ?>   
            <div class="contenant_connexion">
            <h1>Changer de UserName</h1>
            <form action="modification.php" method="post" class="formulaire">
                <p>
                    <label>UserName</label> <input type="text" name="username" class="input_perso" />
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
            <h1>Changer de Password</h1>
            <form action="modification.php" method="post" class="formulaire">
                <p>
                    <label><?php echo $res_question['question']; ?></label> <input type="text" name="rep_question" class="input_perso" />
                </p>
                <p>
                    <label>Password</label> <input type="password" name="password" class="input_perso" />
                </p>
                <p>
                    <label>Nouveau Password</label> <input type="password" name="nvpassword" class="input_perso" />                    
                </p>
                <p>
                    <input type="submit" name="modifier_pass" value="Modifier" />
                </p>
            </form>
        </div>
        </main>
        <?php include("include/footer.php"); ?>
    </body>
</html>

