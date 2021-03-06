<?php
    if(isset($_SESSION['id'])) 
        {?>
            <h1>Présentation du Groupement Banque Assurance Français</h1>
            <section class="presentation">
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
            </section>

            <?php
                include("database/bdd.php");
                        
                $reponse = $bdd->query('SELECT id, acteur, description, logo FROM actor ORDER BY id LIMIT 0,5'); 
                            
                while ($data = $reponse->fetch())
                    {
            ?>

            <section class="acteur_prvw">
                <img src="public/images/<?php echo $data['logo']; ?>" alt="logo <?php echo $data['acteur'] ?>" class="logo_prvw" />
                    <div class="contenu_acteur">
                    <h3>
                        <?php echo htmlspecialchars($data['acteur']); ?>
                    </h3>
                    <p>
                        <?php
                            /* on part de la première lettre, on prend les 125 premiers caractères et on spécifie dans quelle variable on travaille. */
                        $prvw_descr = substr($data['description'], 0, 125);
                        echo htmlspecialchars($prvw_descr)
                        ?> (...)
                        <em><a href="acteur.php?acteur=<?php echo $data['id']; ?>">Lire la suite</a></em>
                    </p>
                    </div>
                    </section>
            <?php
                    }        
                $reponse->closeCursor();
        }
    else 
        {
            header('Location: ../index.php');
        }?>
