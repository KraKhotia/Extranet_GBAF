<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Extranet GBAF</title>
    <link href="public/css/style.css" rel="stylesheet" />
    </head>
    
    <body>
        <header>
            <img src="public/images/logo_gbaf.png" alt="logo gbaf" id="logo_header" /> <?php 
                if (isset($_SESSION['id']) AND isset($_SESSION['nom']) AND isset($_SESSION['prenom']))
                {
                    echo '<div class="info_profil">
                            <p><img src="public/images/avatar.png" alt="logo gbaf" class="avatar" />&nbsp;' . $_SESSION['nom'] . ' ' . $_SESSION['prenom'] . '</p>
                            <a href="profil.php">Profil</a><br />
                            <a href="logout.php">Se déconnecter</a>
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