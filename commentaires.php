<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Extranet GBAF</title>
    <link href="public/css/style.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/d30df02282.js" crossorigin="anonymous"></script>
    </head>
    
    <body>
        <?php session_start();
        include("include/entete.php"); ?>
            
        <main>
            <p><a href="index.php">Retour à l'index</a></p>
            <?php
                include("database/bdd.php");
                
                //on récupère l'ID de l'acteur pour afficher le bon contenu
                $req = $bdd->prepare('SELECT ID, acteur, description, logo FROM actor WHERE ID = ?'); 
                $req->execute(array($_GET['acteur']));   
                $donneesR1 = $req->fetch()   
            
            ?>
                    <div class="acteur">
                        <img src="public/images/<?php echo $donneesR1['logo']; ?>" alt="logo <?php echo $donneesR1['acteur'] ?>" class="logo_acteur" />
                        <h2>
                            <?php echo htmlspecialchars($donneesR1['acteur']); ?>
                        </h2>
                        <p>
                            <?php echo nl2br(htmlspecialchars($donneesR1['description'])); ?><br />
                        </p>
                    </div>
                    <div class="vote">
                        <div class="vote_btns">
                            <button class="vote_btn vote_like"><i class="fa fa-thumbs-up"></i> 145</button>
                            <button class="vote_btn vote_dislike"><i class="fa fa-thumbs-down"></i> 2 </button>
                        </div>
                    </div>
                    
                    <h2>Commentaires</h2>
            <?php 
                $req->closeCursor();
                if (empty($donneesR1)) //Si la recherche ne donne rien
                    {
                        echo 'Cet acteur n\'existe pas';
                    }
                else //autrement on affiche les commentaires liés à l'acteur
                    {
                        $req = $bdd->prepare('SELECT auteur, commentaire, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%im%ss\') AS date_creation FROM post WHERE ID_actor = ? ORDER BY date_creation'); 
                        $req->execute(array($_GET['acteur']));   
                        while ($donneesR2 = $req->fetch())
                            {
            ?>
                            <p><strong><?php echo htmlspecialchars($donneesR2['auteur']); ?></strong> le <?php echo $donneesR2['date_creation']; ?></p>
                            <p><?php echo nl2br(htmlspecialchars($donneesR2['commentaire'])); ?></p>
            <?php
                            } // Fin de la boucle des commentaires
                        $req->closeCursor();
                    }
            ?>
                <p>
                <strong>Laisser un commentaire</strong><br />
                </p>
                <form action="commentaire_post.php" method="post">
                    <p>
                        <label>Prénom</label> <input type="text" name="prenom" id="prenom" value="<?php echo (isset($_SESSION['prenom'])?$_SESSION['prenom']:''); ?>" />
                    </p>
                    <p>
                        <label>Commentaire</label> <input type="text" name="commentaire" id="post" />
                    </p>
                    <p>
                        <input type="hidden" name="ID_actor" value="<?php echo $donneesR1['ID']; ?>" /> 
                    </p>
                    <p>
                        <input type="submit" value="Envoyer" />
                    </p>
                </form>
        </main>
            <?php
                $req->closeCursor();
            
        include("include/footer.php");
        ?>
    </body>
</html>

