<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Extranet GBAF</title>
    <link href="style.css" rel="stylesheet" />
    </head>
    
    <body>
        <?php session_start();
        include("entete.php");
        if (isset($_SESSION['id']) AND isset($_SESSION['nom']) AND isset($_SESSION['prenom']))
            {
              include("acteurs.php");  
            }
        else
            {
              include("connexion.php");  
            }
        ?>
        
        
        
    </body>
</html>