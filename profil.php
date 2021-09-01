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
            $req = $bdd->prepare('SELECT ID, password, question, rep_question FROM account WHERE ID = :ID');
            $req->execute(array(
                'ID' => $idsession));
            $res_account = $req->fetch();
        
            $req->closeCursor();
            
            $req = $bdd->prepare('SELECT ID, question FROM question WHERE ID = :ID');
            $req->execute(array(
                'ID' => $res_account['question']));
            $res_question = $req->fetch();
        
            $req->closeCursor();

        ?>   
            <div class="contenant_connexion">
            <h1>Changer de Password</h1>
            <form action="change_password.php" method="post" class="formulaire">
                <p>
                    <label>Password</label> <input type="password" name="password" class="input_perso" />
                </p>
                <p>
                    <label><?php echo $res_question['question']; ?></label> <input type="text" name="rep_question" class="input_perso" />
                </p>
                <p>
                    <label>Nouveau Password</label> <input type="password" name="password" class="input_perso" />                    
                </p>
                <?php if(isset($_GET['info']) && $_GET['info'] = "erreur") { echo '<div class="erreur">Mauvais.e password ou réponse !</div>';} ?>
                <p>
                    <input type="submit" name="modifier" value="Modifier" />
                </p>
            </form>
        </div>
        </main>
        <?php    
        include("include/footer.php");
        ?>
    </body>
</html>

