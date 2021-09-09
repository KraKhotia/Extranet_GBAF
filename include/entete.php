<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Extranet GBAF</title>
    <link href="public/css/style.css" rel="stylesheet" />
    </head>
    
    <body>
        <header>
            <img src="public/images/logo_gbaf.png" alt="logo gbaf" id="logo_header" /> <?php 
                if (isset($_SESSION['id']) AND isset($_SESSION['nom']) AND isset($_SESSION['prenom']))
                {
                    echo '<div class="info_profil">
                            <p><img src="public/images/avatar.png" alt="logo gbaf" class="avatar" />&nbsp;<a href="profil.php" id="membre">' . $_SESSION['nom'] . ' ' . $_SESSION['prenom'] . '</a></p>
                            <a href="logout.php" id="logout">Se déconnecter</a>
                        </div>';
                    
                }
                
                else
                {
                    echo '';
                }
                ?>
        </header>
    </body>
</html>