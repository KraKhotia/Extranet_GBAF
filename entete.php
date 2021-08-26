<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Extranet GBAF</title>
    <link href="style.css" rel="stylesheet" />
    </head>
    
    <body>
        <header>
            <img src="logo_gbaf.png" alt="logo gbaf" id="logo" /> <?php 
if (isset($_SESSION['id']) AND isset($_SESSION['nom']) AND isset($_SESSION['prenom']))
{
    echo $_SESSION['nom'] . ' ' . $_SESSION['prenom'] . '<br /> <a href="deconnexion.php">Déconnexion</a>';
    
}

else
{
    echo '';
}
?>
        </header>
    </body>
</html>