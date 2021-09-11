<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inscription à l'Extranet</title>
    </head>
    <body>
    <?php
        include("../include/entete.php");
        include("../database/bdd.php"); 
    ?>
        <main>
        <?php
            $erreur = array();
            if(isset($_POST['inscription']))
                {
                    //On définit les variables
                    $nom = htmlspecialchars(trim($_POST['nom']));
                    $prenom = htmlspecialchars(trim($_POST['prenom']));
                    $username = htmlspecialchars(trim($_POST['username']));
                    $password = htmlspecialchars(trim($_POST['password']));
                    $v_password = htmlspecialchars(trim($_POST['v_password']));
                    $question = $_POST['question'];
                    $rep_question = htmlspecialchars(trim($_POST['rep_question']));
                    
                    //on vérifie que tout les champs sont remplis
                    if(!empty($nom) AND !empty($prenom) AND !empty($username) AND !empty($password) AND !empty($v_password) AND !empty($question) AND !empty($rep_question))
                        {
                            $nomlength = strlen($nom);
                            //On vérifie que le nom, prenom et username font moins de 50 caractères
                            if($nomlength <= 50)
                                {
                                    $prenomlength = strlen($prenom);
                                    if($prenomlength <= 50)
                                        {
                                            $usernamelength = strlen($username);
                                            if($usernamelength <= 50)
                                                {
                                                    $requsername = $bdd->prepare("SELECT * FROM account WHERE username=?");
                                                    $requsername->execute(array($username));
                                                    $usernameexist = $requsername->rowCount();
                                                    //on vérifie si le pseudo existe déjà ou non
                                                    if($usernameexist == 0)
                                                        {
                                                            //on vérifie de les mdp sont identiques
                                                            if($password == $v_password)
                                                                {
                                                                    // Hachage du mot de passe
                                                                    $pass_hache = password_hash($password, PASSWORD_DEFAULT);
                                                                    $rep_hache = password_hash($rep_question, PASSWORD_DEFAULT);
                                                                    // Effectuer ici la requête qui insère le compte
                                                                    $req = $bdd->prepare('INSERT INTO account(nom, prenom, username, password, question, rep_question, date_inscr) VALUES(:nom, :prenom, :username, :password, :question, :rep_question, CURDATE())');
                                                                    $req->execute(array(
                                                                            'nom' => $nom,
                                                                            'prenom' => $prenom,
                                                                            'username' => $username,
                                                                            'password' => $pass_hache,
                                                                            'question' => $question,
                                                                            'rep_question' => $rep_hache)); 
                                                                    // Puis rediriger vers index.php
                                                                    header('Location: ../index.php?info=valide');
                                                                
                                                                }
                                                            else{
                                                                    $erreur['password'] = "Vos mots de passes ne correspondent pas!";
                                                                }
                                                        }
                                                    else{
                                                            $erreur['username'] = "UserName dejà utilisé!";
                                                        }
                                                }
                                            else{
                                                    $erreur['username_length'] = "Votre UserName ne doit pas dépasser 50 caractères";
                                                }
                                        }
                                    else{
                                            $erreur['prenom'] = "Votre prénom ne doit pas dépasser 50 caractères";
                                        }     
                                }
                            else{
                                    $erreur['nom'] = "Votre nom ne doit pas dépasser 50 caractères";
                                }       
                        }  
                    else
                        {
                            $erreur['champs'] = "Tout les champs doivent être complétés!";
                        }
                }
                
            if(!empty($erreur))
                {
                    include("../include/inscription.php");
                }
        ?>
        </main>
    <?php    
        include("../include/footer.php");
    ?>
    </body>
</html>
