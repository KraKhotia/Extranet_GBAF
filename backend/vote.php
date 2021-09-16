<?php
    session_start();

    include("../database/bdd.php");
    if($_SERVER['REQUEST_METHOD'] != 'POST') {

        http_response_code(403);
        die();
    }   
    //Compte le nombre de like et de dislike pour l'utilisateur connecté sur l'article ciblé
    $id_actor = (int) htmlspecialchars($_GET['id_actor']);
    $req_like = $bdd->prepare("SELECT id FROM v_like WHERE id_account=:id_session AND id_actor=:id_actor");
    $req_like->execute(array(
        'id_session' => $_SESSION['id'],
        'id_actor' => $id_actor));
    $like_exist = $req_like->rowCount();

    $req_dislike = $bdd->prepare("SELECT id FROM v_dislike WHERE id_account=:id_session AND id_actor=:id_actor");
    $req_dislike->execute(array(
        'id_session' => $_SESSION['id'],
        'id_actor' => $id_actor));
    $dislike_exist = $req_dislike->rowCount();
    
        if ($like_exist == 0 AND isset($_SESSION['id']) AND isset($id_actor) AND isset($_POST['vote_like'])) 
            {//Si l'utilisateur connecté n'a pas liké, on vérifie pour dislike
            
                if ($dislike_exist == 0) 
                    {//S'il n'y a pas de vote de l'utilisateur on enregistre le like
                        $req = $bdd->prepare('INSERT INTO v_like(id_account, id_actor) VALUES(?, ?)');
                        $req->execute(array($_SESSION['id'], $id_actor));
                        // Puis rediriger vers acteur.php à l'ancre #commentaires 
                        
                        header('Location: ../acteur.php?acteur=' . $_GET['id_actor'] . '#commentaires');

                    } 
                else {//Si vote dislike, on le supprime et ajoute un like
                            $req = $bdd->prepare('DELETE FROM v_dislike WHERE (id_account=:id_account AND id_actor=:id_actor)');
                            $req->execute(array(
                                'id_account' => $_SESSION['id'],
                                'id_actor' => $id_actor));
                            
                            $req = $bdd->prepare('INSERT INTO v_like(id_account, id_actor) VALUES(?, ?)');
                            $req->execute(array($_SESSION['id'],$id_actor));
                            
                            // Puis rediriger vers acteur.php à l'ancre #commentaires 
                            header('Location: ../acteur.php?acteur=' . $id_actor . '#commentaires');
                        }
            
            } 
        else {//Si l'utilisateur avait déjà liké, retirer son vote
                    
                    $req = $bdd->prepare('DELETE FROM v_like WHERE id_account=:id_account AND id_actor=:id_actor');
                    $req->execute(array(
                        'id_account' => $_SESSION['id'],
                        'id_actor' => $id_actor));
                            
                    header('Location: ../acteur.php?acteur=' . $id_actor . '#commentaires'); 
                }
        
        if ($dislike_exist == 0 AND isset($_SESSION['id']) AND isset($id_actor) AND isset($_POST['vote_dislike'])) 
                {//Si l'utilisateur connecté n'a pas disliké, on vérifie pour like
                    
                    if ($like_exist == 0) {//S'il n'y a pas de vote de l'utilisateur on enregistre le dislike
                            $req = $bdd->prepare('INSERT INTO v_dislike(id_account, id_actor) VALUES(?, ?)');
                            $req->execute(array($_SESSION['id'], $id_actor));
                             
                            header('Location: ../acteur.php?acteur=' . $_GET['id_actor'] . '#commentaires');
        
                    } else {//Si vote like, on le supprime et ajoute un dislike
                                $req = $bdd->prepare('DELETE FROM v_like WHERE id_account=:id_session AND id_actor=:id_actor');
                                $req->execute(array(
                                    'id_session' => $_SESSION['id'],
                                    'id_actor' => $id_actor));
                                
                                $req = $bdd->prepare('INSERT INTO v_dislike(id_account, id_actor) VALUES(?, ?)');
                                $req->execute(array($_SESSION['id'],$id_actor));
                                
                                header('Location: ../acteur.php?acteur=' . $id_actor . '#commentaires');
                            }
                    
            } else {//Si l'utilisateur avait déjà disliké, retirer son vote
                        
                        $req = $bdd->prepare('DELETE FROM v_dislike WHERE id_account=:id_account AND id_actor=:id_actor');
                        $req->execute(array(
                            'id_account' => $_SESSION['id'],
                            'id_actor' => $id_actor));
                        
                        header('Location: ../acteur.php?acteur=' . $id_actor . '#commentaires'); 
                    }
    
?>