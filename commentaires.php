<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Extranet GBAF</title>
    <link href="public/css/style.css" rel="stylesheet" />
    </head>
    
    <body>
        <?php session_start();
        include("entete.php"); ?>
        
        <h1>Les acteurs</h1>    
        <p><a href="index.php">Retour à l'index</a></p>
        <?php
            include("bdd.php");
            
            //on récupère l'ID de l'acteur pour afficher le bon contenu
            $req = $bdd->prepare('SELECT ID, acteur, description FROM acteur WHERE ID = ?'); 
            $req->execute(array($_GET['acteur']));   
            $donneesR1 = $req->fetch()   
        ?>
                <div class="news">
                    <h3>
                        <?php echo htmlspecialchars($donneesR1['acteur']); ?>
                    </h3>
                    <p>
                        <?php echo nl2br(htmlspecialchars($donneesR1['description'])); ?><br />
                    </p>
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
                    $req = $bdd->prepare('SELECT ID_user, post, DATE_FORMAT(date_add, \'%d/%m/%Y à %Hh%im%ss\') AS date_add FROM post WHERE ID_acteur = ? ORDER BY date_add'); 
                    $req->execute(array($_GET['acteur']));   
                    while ($donneesR2 = $req->fetch())
                        {
        ?>
                        <p><strong><?php echo htmlspecialchars($donneesR2['username']); ?></strong> le <?php echo $donneesR2['date_add']; ?></p>
                        <p><?php echo nl2br(htmlspecialchars($donneesR2['post'])); ?></p>
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
                    <input type="hidden" name="ID_acteur" value="<?php echo $donneesR1['ID']; ?>" /> 
                </p>
                <p>
                    <input type="submit" value="Envoyer" />
                </p>
            </form>
        <?php
            $req->closeCursor();
        ?>
    </body>
</html>