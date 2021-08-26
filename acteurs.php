<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Extranet GBAF</title>
    <link href="style.css" rel="stylesheet" />
    </head>
    
    <body>
    <h1>Les acteurs</h1>
    <?php
    include("bdd.php");
            
    $reponse = $bdd->query('SELECT ID, acteur, description FROM acteur ORDER BY ID LIMIT 0,5'); 
                
    while ($donnees = $reponse->fetch())
        {
?>
    <div class="acteur">
        <h3>
            <?php echo htmlspecialchars($donnees['acteur']); ?>
        </h3>
        <p>
        <?php
             /* on part de la première lettre, on prend les 100 premiers caractères et on spécifie dans quelle variable on travaille. */
            $apercu_contenu = substr($donnees['description'], 0, 100);
            echo htmlspecialchars($apercu_contenu)
        ?> (...)
            <em><a href="commentaires.php?acteur=<?php echo $donnees['ID']; ?>">Lire la suite</a></em>
        </p>
    </div>
<?php
        }
                
    $reponse->closeCursor();
?>