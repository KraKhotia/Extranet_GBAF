<?php
    include("entete.php");
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=extranet;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }
    

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
            if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['username']) AND !empty($_POST['password']) AND !empty($_POST['v_password']) AND !empty($_POST['question']) AND !empty($_POST['rep_question']))
                {
                    $nomlength = strlen($nom);
                    //On vérifie que le nom, prenom et username font moins de 255 caractères
                    if($nomlength <= 255)
                        {
                            $prenomlength = strlen($prenom);
                            if($prenomlength <= 255)
                                {
                                    $usernamelength = strlen($username);
                                    if($usernamelength <= 255)
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
                                                            $pass_hache = password_hash(trim($password), PASSWORD_DEFAULT);
                                                            // Effectuer ici la requête qui insère le compte
                                                            $req = $bdd->prepare('INSERT INTO account(nom, prenom, username, password, question, rep_question, date_inscr) VALUES(:nom, :prenom, :username, :password, :question, :rep_question, CURDATE())');
                                                            $req->execute(array(
                                                                    'nom' => $nom,
                                                                    'prenom' => $prenom,
                                                                    'username' => $username,
                                                                    'password' => $pass_hache,
                                                                    'question' => $question,
                                                                    'rep_question' => $rep_question)); 
                                                            // Puis rediriger vers index.php
                                                            echo "Votre compte a bien été créé!";
                                                            header('Location: index.php');
                                                            
                             
                                                        }
                                                    else{
                                                            echo '<div class="erreur">Vos mots de passes ne correspondent pas!</div>';
                                                            include("inscription.php");
                                                        }
                                                }
                                            else{
                                                    echo '<div class="erreur">Username dejà utilisé!</div>';
                                                    include("inscription.php");
                                                }
                                        }
                                    else{
                                            echo '<div class="erreur">Votre username ne doit pas dépasser 255 caractères</div>';
                                            include("inscription.php");
                                        }
                                }
                            else{
                                    echo '<div class="erreur">Votre prénom ne doit pas dépasser 255 caractères</div>';
                                    include("inscription.php");
                                }     
                        }
                    else{
                            echo '<div class="erreur">Votre nom ne doit pas dépasser 255 caractères';
                            include("inscription.php");
                        }       
                }  
            else
                {
                    echo '<div class="erreur">Tout les champs doivent être complétés!</div>';
                    include("inscription.php");
                }
        }   
?>
