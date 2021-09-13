    <h1>Présentation du Groupement Banque Assurance Français</h1>
    <div class="presentation">
        <p>Le Groupement Banque Assurance Français (GBAF) est une fédération représentant les 6 grands groupes français :</p>
        <div class="liste">
            <ul>
                <li> BNP Paribas ;</li>
                <li> BPCE ;</li>
                <li> Crédit Agricole ;</li>
                <li> Crédit Mutuel-CIC ;</li>
                <li> Société Générale ;</li>
                <li> La Banque Postale.</li>
            </ul>
        </div>
        <p>
            Même s’il existe une forte concurrence entre ces entités, elles vont toutes travailler de la même façon pour gérer près de 80 millions de comptes sur le territoire national. Le GBAF est le représentant de la profession bancaire et des assureurs sur tous les axes de la réglementation financière française. Sa mission est de promouvoir l'activité bancaire à l’échelle nationale. C’est aussi un interlocuteur privilégié des pouvoirs publics.
        </p>
        <img src="public/images/illustration.jpg" alt="illustration" /><br />

        <h2>Présentation des acteurs et partenaires</h2>
    </div>
<?php
    include("database/bdd.php");
            
    $reponse = $bdd->query('SELECT id, acteur, description, logo FROM actor ORDER BY id LIMIT 0,5'); 
                
    while ($donnees = $reponse->fetch())
        {
?>
    <div class="acteur_prvw">
        <img src="public/images/<?php echo $donnees['logo']; ?>" alt="logo <?php echo $donnees['acteur'] ?>" class="logo_prvw" />
            <div class="contenu_acteur">
            <h3>
                <?php echo htmlspecialchars($donnees['acteur']); ?>
            </h3>
            <p>
                <?php
                 /* on part de la première lettre, on prend les 110 premiers caractères et on spécifie dans quelle variable on travaille. */
                $apercu_contenu = substr($donnees['description'], 0, 125);
                echo htmlspecialchars($apercu_contenu)
                ?> (...)
                <em><a href="acteur.php?acteur=<?php echo $donnees['id']; ?>">Lire la suite</a></em>
            </p>
            </div>
    </div>
<?php
        }
                
    $reponse->closeCursor();
    
?>