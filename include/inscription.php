<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Inscription à l'Extranet</title>
    </head>
    <body>        
         <div class="contenant_inscr">
            <h1>Inscription</h1>
            <form action="inscription_post.php" method="post" class="formulaire">
                <div class="inline_npu">
                    <p>
                        <label>Nom</label> <input type="text" name="nom" value="<?php echo (isset($_POST['nom'])?$_POST['nom']:''); ?>" class="input_perso" />
                    </p>
                    <p>
                        <label>Prénom</label> <input type="text" name="prenom" value="<?php echo (isset($_POST['prenom'])?$_POST['prenom']:''); ?>" class="input_perso" />
                    </p>
                    <p>
                    <label>UserName</label> <input type="text" name="username" value="<?php echo (isset($_POST['username'])?$_POST['username']:''); ?>" class="input_perso" />
                     </p>
                </div>
                    <p>
                        <?php if( isset($erreur) && isset($erreur['nom']) ){ echo '<div class="erreur">' . $erreur['nom'] . '</div>'; } ?>
                    </p>
                    <p>
                        <?php if( isset($erreur) && isset($erreur['prenom']) ){ echo '<div class="erreur">' . $erreur['prenom'] . '</div>'; } ?>
                    </p>
                    <p>
                    <?php if( isset($erreur) && isset($erreur['username']) ){ echo '<div class="erreur">' . $erreur['username'] . '</div>'; }
                     if( isset($erreur) && isset($erreur['username_length']) ){ echo '<div class="erreur">' . $erreur['username_length'] . '</div>'; } ?>
                     </p>
                <div class="inline">   
                    <p>
                        <label>Password</label> <input type="password" name="password" class="input_perso" />
                    </p>
                    <p>
                        <label>Vérification Password</label> <input type="password" name="v_password" class="input_perso" />
                    </p>
                </div>
                <div class="erreur"><?php if( isset($erreur) && isset($erreur['password']) ){ echo $erreur['password']; } ?></div>
                <div class="inline">
                    <p>
                       <label>Question secrète</label> <select name="question" class="input_perso">
                           <option value="1">Qu’est-ce vous vouliez devenir plus grand, lorsque vous étiez enfant ?</option>
                           <option value="2">Quel est le prénom de votre arrière-grand-mère maternelle ?</option>
                           <option value="3">Quel est le nom de votre premier animal de compagnie ?</option>
                           <option value="4">Quelle est la personnalité historique que vous préférez ?</option>
                           <option value="5">Quel est le nom de famille de votre professeur d’enfance préféré ?</option>
                       </select>
                   </p>
                   <p>
                       <label>Réponse à la question secrète</label> <input type="text" name="rep_question" class="input_perso" />
                   </p>
                </div>
                
                <div class="erreur"><?php if( isset($erreur) && isset($erreur['champs']) ){ echo $erreur['champs']; } ?></div>
                <p>
                    <input type="submit" name="inscription" value="S'inscrire" />
                </p>
                <p>
                    <a href="index.php">Retour</a>
                </p>
            </form>
        </div>
    </body>
</html>