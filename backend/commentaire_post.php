<?php
    include("../database/bdd.php");
    
    session_start();
    if($_SERVER['REQUEST_METHOD'] != 'POST') 
        {
            header('Location: ../index.php');
        }
    // Effectuer ici la requête qui insère le message
    $req = $bdd->prepare('INSERT INTO post(id_actor, id_account, date_creation, commentaire) VALUES(?, ?, NOW(), ?)');
    $req->execute(array($_POST['id_actor'],$_SESSION['id'],$_POST['commentaire']));
    // Puis rediriger vers commentaires.php 

    header('Location: ../acteur.php?acteur=' . $_POST['id_actor'] . '');
?>