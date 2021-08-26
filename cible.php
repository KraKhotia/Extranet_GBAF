<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Codes d'accès au serveur central de la NASA</title>
    </head>
    <body>

        <?php
            if (isset($_POST['MotDePasse']) AND $_POST['MotDePasse'] == "kangourou")
                {
                    echo 'Voici les codes d\'accès secrets !';
                }
            else
                {
                include("formulaire.php");
                echo '<p><strong>Mot de passe incorrect</strong></p>';
                }
        ?>
    </body>
</html>