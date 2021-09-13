<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Extranet GBAF</title>
    <link href="public/css/style.css" rel="stylesheet" />
    </head>
    
    <body>
        <?php session_start();
        include("include/entete.php"); ?>
        <main>
            <?php
            if (isset($_SESSION['id']) AND isset($_SESSION['nom']) AND isset($_SESSION['prenom']))
                {
                    if(isset($_GET['info']) && $_GET['info'] == "erreur") { echo '<div class="erreur">Vous êtes déjà inscrit !</div>';}
                    include("include/acteurs.php");  
                }
            else
                {  
                    include("include/login.php");  
                }
            ?>
        </main>   
        <?php include("include/footer.php"); ?>
    </body>
</html>