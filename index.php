<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
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