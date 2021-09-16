<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Extranet GBAF</title>
        <link href="public/css/style.css" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/d30df02282.js" crossorigin="anonymous"></script>
        <script src="public/js/textarea.js"></script>
    </head>
    
    <body>
        <?php session_start();
        include("include/entete.php"); ?>
     
        <main>
        <?php 
            if(isset($_SESSION['id'])) 
                {?>
                    <a href="index.php" class="retour">Retour à l'index</a>

                    <?php
                    include("database/bdd.php");
                    
                    $id_actor = (int) htmlspecialchars($_GET['acteur']);

                    //on récupère l'ID de l'acteur pour afficher le bon contenu
                    $req = $bdd->prepare('SELECT id, acteur, description, logo FROM actor WHERE id=?'); 
                    $req->execute(array($id_actor));   
                    $dataR1 = $req->fetch();  
                    $req->closeCursor(); 
                    ?>
                    
                    <section class="acteur">
                        <img src="public/images/<?php echo $dataR1['logo']; ?>" alt="logo <?php echo $dataR1['acteur'] ?>" class="logo_acteur" />
                        <h2>
                            <?php echo htmlspecialchars($dataR1['acteur']); ?>
                        </h2>
                        <p>
                            <?php echo nl2br(htmlspecialchars($dataR1['description'])); ?><br />
                        </p>
                    </section>
                    <?php
                        
                        //on récupère le nombre de like et de dislike
                        $req = $bdd->prepare('SELECT * FROM v_like WHERE id_actor=:id_actor');
                        $req->execute(array('id_actor' => $id_actor));    
                        $like_count = $req->rowCount();
                        $req->closeCursor();

                        $req = $bdd->prepare('SELECT * FROM v_dislike WHERE id_actor=:id_actor');
                        $req->execute(array('id_actor' => $id_actor));    
                        $dislike_count = $req->rowCount();
                        $req->closeCursor();

                        //on vérifie si l'utilisateur a voté pour cet acteur
                        $req_like = $bdd->prepare("SELECT id FROM v_like WHERE id_account=:id_session AND id_actor=:id_actor");
                        $req_like->execute(array(
                            'id_session' => $_SESSION['id'],
                            'id_actor' => $id_actor));
                        $like_exist = $req_like->fetch();

                        $req_dislike = $bdd->prepare("SELECT id FROM v_dislike WHERE id_account=:id_session AND id_actor=:id_actor");
                        $req_dislike->execute(array(
                            'id_session' => $_SESSION['id'],
                            'id_actor' => $id_actor));
                        $dislike_exist = $req_dislike->fetch();
                    
                    ?>      

                    <section id="commentaires">
                        <h2>Commentaires</h2>
                        <div class="btn_zone_comment">   
                            <div class="nv_comment">
                                <form action="acteur.php?acteur=<?php echo $dataR1['id'] ?>#commentaires" method="POST">
                                    <button type="submit" name="btn_nv_comment" class="btn_nv_comment">Nouveau<br />Commentaire</button>
                                </form>
                            </div>
                            <div class="vote">
                                    <div class="vote_btns">
                                        <form action="backend/vote.php?id_actor=<?php echo $dataR1['id'];?>" method="POST">
                                            <!-- récupération de la requête $like_exist si le like existe, ajoute la class "is-liked" au bouton -->
                                            <button type="submit" class="vote_btn vote_like <?php if($like_exist){echo 'is-liked';}?>" name="vote_like">
                                                <i class="fa fa-thumbs-up fa-2x"></i> <?php echo $like_count ?>
                                            </button>
                                        </form>
                                        <form action="backend/vote.php?id_actor=<?php echo $dataR1['id'];?>" method="POST">
                                            <!-- récupération de la requête $dislike_exist si le dislike existe, ajoute la class "is-disliked" au bouton -->
                                            <button type="submit" class="vote_btn vote_dislike <?php if($dislike_exist){echo 'is-disliked';}?>" name="vote_dislike"><i class="fa fa-thumbs-down fa-2x"></i> <?php echo $dislike_count ?></button>
                                        </form>
                                    </div>
                            </div>
                        </div>
                        <?php     
                        if (isset($_POST['btn_nv_comment'])) 
                            {?>
                                <form action="backend/commentaire_post.php" method="post">
                                    <p>
                                        <strong>Prénom :</strong> <?php echo (isset($_SESSION['prenom'])?$_SESSION['prenom']:''); ?>
                                    </p>
                                    <p>
                                        <label>Commentaire</label><br /> <textarea type="text" cols="40" rows="5" name="commentaire" id="post" onblur="javascript:msg_textarea()" onfocus="javascript:clean_textarea()"></textarea>
                                    </p>
                                    <p>
                                        <input type="hidden" name="id_actor" value="<?php echo $dataR1['id']; ?>" /> 
                                    </p>
                                    <p>
                                        <input type="submit" value="Envoyer" />
                                    </p>
                                </form>
                            <?php
                            }
                        
                        if (empty($dataR1)) //Si la recherche ne donne rien, affiche une erreur
                            {
                                echo '<div class="erreur">Ce partenaire n\'existe pas !<br /><a href="index.php" class="retour">Retour à l\'index</a>';
                            }
                        else //autrement on affiche les commentaires liés à l'acteur
                            {
                                $req = $bdd->prepare('SELECT id_account, commentaire, date_creation FROM post WHERE id_actor = ? ORDER BY date_creation DESC'); 
                                $req->execute(array($_GET['acteur']));   
                                while ($dataR2 = $req->fetch())
                                    {
                                        $req_user = $bdd->prepare('SELECT id, prenom FROM account WHERE id = :id_account'); 
                                        $req_user->execute(array('id_account' => $dataR2['id_account']));
                                        $prenom = $req_user->fetch();

                                        $timestamp = strtotime($dataR2['date_creation']);
                                        $nv_date = date("d/m/Y", $timestamp);//change le format de la date?>
                                    <div class="commentaire">
                                        <p><strong><?php echo htmlspecialchars($prenom['prenom']); ?></strong><br /> <?php echo $nv_date; ?></p>
                                        <p><?php echo nl2br(htmlspecialchars($dataR2['commentaire'])); ?></p>
                                    </div>
                                <?php
                                    } // Fin de la boucle des commentaires
                                $req->closeCursor();
                            }?>
                    </section>
                <?php   
                } 
            else 
                {
                    echo '<div class="erreur">Vous devez être connecté !<br /><img src="public/images/illustration.jpg" alt="illustration" /></div>';
                } ?>      
            
            <a href="index.php" class="retour">Retour à l'index</a>
        </main>
        
        <?php include("include/footer.php"); ?>
    </body>
</html>

