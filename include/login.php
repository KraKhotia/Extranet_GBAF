<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion à l'Extranet</title>
        <link href="public/css/style.css" rel="stylesheet" />
    </head>
    <body>
        <?php
            if(isset($_GET['action']) && $_GET['action'] = "inscrire")
                {
                    include("include/inscription.php");
                }
            
            else
                {
                    if(isset($_GET['info']) && $_GET['info'] = "valide")
                        {
                            echo '<div class="succes">Votre compte a été créé avec succès !</div>';
                        }
         ?>       
                    <div class="contenant_connexion">
                        <h1>Connexion</h1>
                        <form action="backend/check_login.php" method="post" class="formulaire">
                            <div class="inline">    
                                <p>
                                    <label>UserName</label> <input type="text" name="username" class="input_perso" />
                                </p>
                                <p>
                                    <label>Password</label> <input type="password" name="password" class="input_perso" />
                                </p>
                            </div>
                            <p>
                                <input type="submit" name="connexion" value="Se connecter" />
                            </p>
                        </form>
                        <form action="index.php?action=inscrire" method="post" class="subscribe">
                            <button type="submit">S'inscrire</button>
                        </form>
                    </div>
        <?php            
                }
        ?>    
    </body>
</html>