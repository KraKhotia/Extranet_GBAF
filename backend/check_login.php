<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion à l'Extranet</title>
        <link href="public/css/style.css" rel="stylesheet" />
    </head>
    
    <body>
        <main>
            <?php
                include("../include/entete.php");
                include("../database/bdd.php");
                
                $username = htmlspecialchars(trim($_POST['username']));
                
                //  Récupération de l'utilisateur et de son pass hashé
                $req = $bdd->prepare('SELECT id, nom, prenom, password FROM account WHERE username = :username');
                $req->execute(array(
                    'username' => $username));
                $result = $req->fetch();
                
                // Comparaison du pass envoyé via le formulaire avec la base
                $isPasswordCorrect = password_verify($_POST['password'], $result['password']);
                
                if (!$result)
                {
                    echo '<div class="erreur">Mauvais identifiant ou mot de passe !</div>';
                    include("../include/login.php");
                    
                }
                else
                {
                    if ($isPasswordCorrect) {
                        session_start();
                        $_SESSION['id'] = $result['id'];
                        $_SESSION['username'] = $username;
                        $_SESSION['nom'] = $result['nom'];
                        $_SESSION['prenom'] = $result['prenom'];
                        echo 'Vous êtes connecté !';
                        header('Location: ../index.php');
                    }
                    else {
                        echo '<div class="erreur">Mauvais identifiant ou mot de passe !</div>';
                        include("../include/login.php");
                    }
                }
            ?>
        </main>
        <?php include("../include/footer.php"); ?>
    </body>
</html>