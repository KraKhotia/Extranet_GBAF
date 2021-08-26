<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Connexion à l'Extranet</title>
    </head>
    <body>
            <h1>Connexion</h1>
            <form action="check_login.php" method="post" class="formulaire">
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
                <p>
                    <a href="inscription.php">S'inscrire</a>
                </p>
            </form>
    </body>
</html>