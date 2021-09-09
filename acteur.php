<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Extranet GBAF</title>
    <link href="public/css/style.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/d30df02282.js" crossorigin="anonymous"></script>
    </head>
    
    <body>
        <?php session_start();
        include("include/entete.php"); ?>
     
        <main>
        <?php if(isset($_SESSION['id'])) 
                {?>
                    <a href="index.php" class="retour">Retour à l'index</a>

                <?php
                    include("database/bdd.php");
                        
                    //on récupère l'ID de l'acteur pour afficher le bon contenu
                    $req = $bdd->prepare('SELECT id, acteur, description, logo FROM actor WHERE id=?'); 
                    $req->execute(array($_GET['acteur']));   
                    $donneesR1 = $req->fetch();  
                    $req->closeCursor(); 
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
                <?php
                     
                     //on récupère le nombre de like et de dislike
                     $req = $bdd->query('SELECT * FROM v_like');    
                     $like_count = $req->rowCount();
                     $req->closeCursor();

                     $req = $bdd->query('SELECT * FROM v_dislike');    
                     $dislike_count = $req->rowCount();
                     $req->closeCursor();
                
                ?>      

                <div id="commentaires">
                    <h2>Commentaires</h2>
                    <div class="btn_zone_comment">   
                        <div class="nv_comment">
                            <form action="acteur.php?acteur=<?php echo $donneesR1['id'] ?>#commentaires" method="POST">
                                <button type="submit" name="btn_nv_comment" class="btn_nv_comment">Nouveau<br />Commentaire</button>
                            </form>
                        </div>
                        <div class="vote">
                                <div class="vote_btns">
                                    <form action="vote.php?id_actor=<?php echo $donneesR1['id'];?>" method="POST">
                                        <button type="submit" class="vote_btn vote_like" name="vote_like"><i class="fa fa-thumbs-up fa-2x"></i> <?php echo $like_count ?></button>
                                    </form>
                                    <form action="vote.php?id_actor=<?php echo $donneesR1['id'];?>" method="POST">
                                        <button type="submit" class="vote_btn vote_dislike" name="vote_dislike"><i class="fa fa-thumbs-down fa-2x"></i> <?php echo $dislike_count ?></button>
                                    </form>
                                </div>
                        </div>
                    </div>
                    <?php     
                        if (isset($_POST['btn_nv_comment'])) 
                        {
                ?>
                            <form action="commentaire_post.php" method="post">
                                <p>
                                    <strong>Prénom :</strong> <?php echo (isset($_SESSION['prenom'])?$_SESSION['prenom']:''); ?>
                                </p>
                                <p>
                                    <label>Commentaire</label><br /> <textarea type="text" cols="40" rows="5" name="commentaire" id="post">Rédigez votre commentaire ici</textarea>
                                </p>
                                <p>
                                    <input type="hidden" name="id_actor" value="<?php echo $donneesR1['id']; ?>" /> 
                                </p>
                                <p>
                                    <input type="submit" value="Envoyer" />
                                </p>
                            </form>
                <?php
                        }
                        
                        if (empty($donneesR1)) //Si la recherche ne donne rien
                            {
                                echo 'Cet acteur n\'existe pas';
                            }
                        else //autrement on affiche les commentaires liés à l'acteur
                            {
                                $req = $bdd->prepare('SELECT auteur, commentaire, DATE_FORMAT(date_creation, \'%d/%m/%Y\') AS date_creation FROM post WHERE id_actor = ? ORDER BY date_creation'); 
                                $req->execute(array($_GET['acteur']));   
                                while ($donneesR2 = $req->fetch())
                                    {
                    ?>
                                    <div class="commentaire">
                                        <p><strong><?php echo htmlspecialchars($donneesR2['auteur']); ?></strong><br /> <?php echo $donneesR2['date_creation']; ?></p>
                                        <p><?php echo nl2br(htmlspecialchars($donneesR2['commentaire'])); ?></p>
                                    </div>
                    <?php
                                    } // Fin de la boucle des commentaires
                                $req->closeCursor();
                            }     
                } else {
                    echo '<div class="erreur">Vous devez être connecté !<br /><img src="public/images/illustration.jpg" alt="illustration" /></div>';

                }
                ?>      
            </div>
            <a href="index.php" class="retour">Retour à l'index</a>
        </main>
        
        <?php include("include/footer.php"); ?>
    </body>
</html>

